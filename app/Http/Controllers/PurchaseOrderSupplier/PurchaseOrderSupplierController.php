<?php

namespace App\Http\Controllers\PurchaseOrderSupplier;

use App\Constants;
use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Models\PurchaseOrderSupplier;
use App\Models\PurchaseOrderSupplierItem;
use App\Models\SalesOrder;
use App\Models\SelectedSourcingSupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderSupplierController extends Controller
{
    protected $fileController, $redisController, $hosting;

    public function __construct()
    {
        $this->middleware('auth');
        $this->fileController = new FilesController();
        $this->redisController = new RedisController();

        if (env('HOSTING')) {
            $this->hosting = env('HOSTING');
        } else {
            $this->hosting = false;
        }
    }

    public function index(Request $request)
    {
        $query = PurchaseOrderSupplier::query()
            ->with([
                'sales_order',
                'supplier',
            ])
            ->select([
                'purchase_order_suppliers.id AS id',
                'purchase_order_suppliers.sales_order_id AS sales_order_id',
                'purchase_order_suppliers.supplier_id AS supplier_id',
                'purchase_order_suppliers.transaction_date AS transaction_date',
                'purchase_order_suppliers.transaction_code AS transaction_code',
                'purchase_order_suppliers.status AS status',
            ]);

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('purchase-order-supplier.index');
    }

    public function add(): View
    {
        $transactionCode = $this->handle_generate_transaction_code(date('Y-m-d'));
        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('purchase-order-supplier.add', [
            'transactionCode' => $transactionCode,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function search_sales_order(Request $request): JsonResponse
    {
        $query = SalesOrder::query()
            ->with([
                'sourcing.selected_sourcing_suppliers' => function ($query) {
                    $query->doesntHave('purchase_order_supplier_item');
                },
                'sourcing.selected_sourcing_suppliers.supplier',
                'sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product',
                'inquiry',
            ])
            ->whereHas('sourcing.selected_sourcing_suppliers', function ($query) {
                $query->doesntHave('purchase_order_supplier_item');
            })
            ->whereHas('sourcing.selected_sourcing_suppliers.supplier')
            ->whereHas('sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product')
            ->where('id', 'like', '%' . $request->term . '%')
            ->where('status', 'Price List Ready')
            ->orderBy('id')
            ->get()
            ->take(20);

        return response()->json($query);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $filePath = null;
            if ($request->hasFile('invoice')) {
                $fileDirectory = 'invoices-of-purchase-order-supplier';
                $file = $request->file('invoice');
                $filePath = $this->fileController->store($fileDirectory, $file);
            }

            $query = new PurchaseOrderSupplier;
            $query->sales_order_id = $request->sales_order_id;
            $query->transaction_date = date('Y-m-d');
            $query->transaction_code = $this->handle_generate_transaction_code($query->transaction_date);

            $query->term = $request->term;
            $query->payment_term = $request->payment_term;
            $query->delivery = $request->delivery;
            $query->vat = $request->vat;
            $query->note = $request->note;
            $query->attachment = $request->attachment;

            $query->bank_name = $request->bank_name;
            $query->bank_swift = $request->bank_swift;
            $query->bank_account = $request->bank_account;
            $query->bank_number = $request->bank_number;
            $query->invoice_url = $filePath;

            $query->total_shipping_note = $request->total_shipping_note;
            $query->total_shipping_value = $request->total_shipping_value ? str_replace(',', '.', str_replace('.', '', $request->total_shipping_value)) : 0;

            $query->document_list = $request->document_list;
            $query->status = 'Waiting For Payment';

            $query->save();

            foreach ($request->item as $selectedSourcingSupplierId => $item) {
                $selectedSourcingSupplier = SelectedSourcingSupplier::query()->whereUuid($selectedSourcingSupplierId)->first();
                if ($selectedSourcingSupplier) {
                    $purchaseOrderSupplierItem = new PurchaseOrderSupplierItem();
                    $purchaseOrderSupplierItem->purchase_order_supplier_id = $query->id;
                    $purchaseOrderSupplierItem->selected_sourcing_supplier_id = $selectedSourcingSupplier->uuid;
                    $purchaseOrderSupplierItem->quantity = str_replace(',', '.', str_replace('.', '', $item['quantity']));
                    $purchaseOrderSupplierItem->cost = str_replace(',', '.', str_replace('.', '', $item['cost']));
                    $purchaseOrderSupplierItem->price = $purchaseOrderSupplierItem->quantity * $purchaseOrderSupplierItem->price;
                    $purchaseOrderSupplierItem->delivery_time = $item['delivery_time'];
                    $purchaseOrderSupplierItem->save();
                }
            }

            $query->supplier_id = $selectedSourcingSupplier->supplier->uuid;
            $query->save();

            if ($request->document_list) {
                $files = json_decode($request->document_list, true);
                $fileDirectory = 'purchase-order-suppliers';
                foreach ($files as $item) {
                    $sourceFilePath = storage_path('app/temp/' . $fileDirectory . '/' . $item['filename']);
                    $destinationFilePath = storage_path('app/public/' . $fileDirectory . '/' . $item['filename']);

                    if (!Storage::exists('public/' . $fileDirectory)) {
                        Storage::makeDirectory('public/' . $fileDirectory);
                    }

                    if (file_exists($sourceFilePath)) {
                        rename($sourceFilePath, $destinationFilePath);
                    }
                }
            }

            DB::commit();

            return redirect()->route('purchase-order-supplier')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function edit($id, Request $request): View
    {
        $query = PurchaseOrderSupplier::query()
            ->with([
                'sales_order.sourcing.selected_sourcing_suppliers' => function ($query) {
                    $query->doesntHave('purchase_order_supplier_item');
                },
                'sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product',
                'supplier',
                'purchase_order_supplier_items',
            ])
            ->findOrFail($id);
        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('purchase-order-supplier.edit', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function update($id, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $query = PurchaseOrderSupplier::query()
                ->with([
                    'sales_order',
                    'supplier',
                    'purchase_order_supplier_items',
                ])
                ->findOrFail($id);

            if ($request->hasFile('invoice')) {
                $fileDirectory = 'invoices-of-purchase-order-supplier';
                $file = $request->file('invoice');
                $filePath = $this->fileController->store($fileDirectory, $file);

                $query->invoice_url = $filePath;
            }

            $query->term = $request->term;
            $query->payment_term = $request->payment_term;
            $query->delivery = $request->delivery;
            $query->vat = $request->vat;
            $query->note = $request->note;
            $query->attachment = $request->attachment;

            $query->bank_name = $request->bank_name;
            $query->bank_swift = $request->bank_swift;
            $query->bank_account = $request->bank_account;
            $query->bank_number = $request->bank_number;

            $query->total_shipping_note = $request->total_shipping_note;
            $query->total_shipping_value = str_replace(',', '.', str_replace('.', '', $request->total_shipping_value));

            $query->document_list = $request->document_list;

            $query->save();

            $purchaseOrderSupplierItemIds = $query->purchase_order_supplier_items->pluck('id', 'id');
            foreach ($request->item as $selectedSourcingSupplierId => $item) {
                $selectedSourcingSupplier = SelectedSourcingSupplier::query()->whereUuid($selectedSourcingSupplierId)->first();
                if ($selectedSourcingSupplier) {
                    $purchaseOrderSupplierItem = PurchaseOrderSupplierItem::query()
                        ->updateOrCreate([
                            'purchase_order_supplier_id' => $query->id,
                            'selected_sourcing_supplier_id' =>  $selectedSourcingSupplier->uuid,
                        ], [
                            'quantity' => str_replace(',', '.', str_replace('.', '', $item['quantity'])),
                            'cost' => str_replace(',', '.', str_replace('.', '', $item['cost'])),
                            'delivery_time' => $item['delivery_time'],
                        ]);

                    $purchaseOrderSupplierItem->price = $purchaseOrderSupplierItem->quantity * $purchaseOrderSupplierItem->price;
                    $purchaseOrderSupplierItem->save();


                    if ($purchaseOrderSupplierItemIds->contains($purchaseOrderSupplierItem->id)) {
                        $purchaseOrderSupplierItemIds->forget($purchaseOrderSupplierItem->id);
                    }
                }
            }

            $query->supplier_id = $selectedSourcingSupplier->supplier->uuid;
            $query->save();

            if ($purchaseOrderSupplierItemIds->count()) {
                $query->purchase_order_supplier_items()->whereIn('id', $purchaseOrderSupplierItemIds->toArray())->delete();
            }

            if ($request->document_list) {
                $files = json_decode($request->document_list, true);
                $fileDirectory = 'purchase-order-suppliers';
                foreach ($files as $item) {
                    $sourceFilePath = storage_path('app/temp/' . $fileDirectory . '/' . $item['filename']);
                    $destinationFilePath = storage_path('app/public/' . $fileDirectory . '/' . $item['filename']);

                    if (!Storage::exists('public/' . $fileDirectory)) {
                        Storage::makeDirectory('public/' . $fileDirectory);
                    }

                    if (file_exists($sourceFilePath)) {
                        rename($sourceFilePath, $destinationFilePath);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput($request->input())->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id)
    {
        try {
            $query = PurchaseOrderSupplier::find($id);

            DB::beginTransaction();

            $query->purchase_order_supplier_items()->delete();
            $query->delete();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function upload_document(Request $request)
    {
        try {
            $fileDirectory = 'purchase-order-suppliers';
            $data = $request->other_files ? json_decode($request->other_files) : [];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $upload = $this->fileController->store_temp($file, $fileDirectory);
                if ($upload->original['status'] == 200) {
                    $fileUploaded = $upload->original['data'];

                    array_push($data, $fileUploaded);

                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $data,
                    ]);
                }
            } elseif ($request->method === "DELETE" && $request->file_name) {
                $fileName = $request->file_name;
                $filePath = $fileDirectory . '/' . $fileName;
                if (Storage::exists('public/' . $filePath) || Storage::exists('temp/' . $filePath)) {
                    if (Storage::exists('public/' . $filePath)) {
                        Storage::delete('public/' . $filePath);
                    } elseif (Storage::exists('temp/' . $filePath)) {
                        Storage::delete('temp/' . $filePath);
                    }

                    if ($data) {
                        foreach ($data as $key => $file) {
                            if ($file->filename === $fileName) {
                                unset($data[$key]);
                            }
                        }

                        $data = array_values($data);
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $data,
                    ]);
                }
            }

            return response()->json([
                'status' => 409,
                'message' => 'failed',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'error',
                'data' => [],
            ]);
        }
    }

    public function handle_generate_transaction_code($date): string
    {
        $prefix = 'PO/PRASASTI';
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = (int) date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $query = PurchaseOrderSupplier::query()->orderBy('transaction_code', 'DESC')->first();
        if ($query) {
            $transactionCodes = explode('/',  $query->transaction_code);
            $number = ((int) $transactionCodes[0]) + 1;
        } else {
            $number = 1;
        }

        return sprintf("%04s", $number) . "/" . $prefix . "/" . $romans[$month - 1] . "/" . $year;
    }
}
