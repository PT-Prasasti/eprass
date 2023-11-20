<?php

namespace App\Http\Controllers\PaymentRequest;

use App\Constants;
use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Models\PaymentRequest;
use App\Models\PurchaseOrderSupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PaymentRequestController extends Controller
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
        $query = PaymentRequest::query()
            ->with([
                'purchase_order_supplier.supplier',
            ])
            ->select([
                'payment_requests.id AS id',
                'payment_requests.purchase_order_supplier_id AS purchase_order_supplier_id',
                'payment_requests.transaction_date AS transaction_date',
                'payment_requests.transaction_due_date AS transaction_due_date',
                'payment_requests.transaction_code AS transaction_code',
                'payment_requests.status AS status',
            ]);

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('payment-request.index');
    }

    public function add(): View
    {
        $transactionCode = $this->handle_generate_transaction_code(date('Y-m-d'));
        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('payment-request.add', [
            'transactionCode' => $transactionCode,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function search_purchase_order_supplier(Request $request): JsonResponse
    {
        $query = PurchaseOrderSupplier::query()
            ->with([
                'supplier',
                'purchase_order_supplier_items.selected_sourcing_supplier.sourcing_supplier.inquiry_product',
                'sales_order.inquiry',
            ])
            ->whereHas('purchase_order_supplier_items')
            ->whereHas('supplier')
            ->where('id', 'like', '%' . $request->term . '%')
            // ->where('status', 'Price List Ready')
            ->orderBy('transaction_code')
            ->get()
            ->take(20);

        return response()->json($query);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $query = new PaymentRequest;
            $query->purchase_order_supplier_id = $request->purchase_order_supplier;
            $query->transaction_date = date('Y-m-d');
            $query->transaction_due_date = date('Y-m-d', strtotime($request->due_date));
            $query->transaction_code = $this->handle_generate_transaction_code($query->transaction_date);
            $query->value = str_replace(',', '', str_replace('.', '', $request->nominal));
            $query->note = $request->note;

            $query->pick_up_information_name = $request->pick_up_information_name;
            $query->pick_up_information_email = $request->pick_up_information_email;
            $query->pick_up_information_phone_number = $request->pick_up_information_phone_number;
            $query->pick_up_information_mobile_number = $request->pick_up_information_mobile_number;
            $query->pick_up_information_pick_up_address = $request->pick_up_information_pick_up_address;

            $query->status = 'Waiting for Approval';

            $query->save();

            DB::commit();

            return redirect()->route('payment-request')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function edit($id): View
    {
        $query = PaymentRequest::query()
            ->with([
                'purchase_order_supplier.supplier',
                'purchase_order_supplier.purchase_order_supplier_items.selected_sourcing_supplier.sourcing_supplier.inquiry_product',
                'purchase_order_supplier.sales_order.inquiry',
            ])
            ->select([
                'payment_requests.id AS id',
                'payment_requests.purchase_order_supplier_id AS purchase_order_supplier_id',
                'payment_requests.transaction_date AS transaction_date',
                'payment_requests.transaction_due_date AS transaction_due_date',
                'payment_requests.transaction_code AS transaction_code',
                'payment_requests.value AS value',
                'payment_requests.note AS note',
                'payment_requests.pick_up_information_name AS pick_up_information_name',
                'payment_requests.pick_up_information_email AS pick_up_information_email',
                'payment_requests.pick_up_information_phone_number AS pick_up_information_phone_number',
                'payment_requests.pick_up_information_mobile_number AS pick_up_information_mobile_number',
                'payment_requests.pick_up_information_pick_up_address AS pick_up_information_pick_up_address',
                'payment_requests.status AS status',
            ])
            ->findOrFail($id);

        return view('payment-request.edit', [
            'query' => $query,
        ]);
    }


    public function update($id, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $query = PaymentRequest::query()->findOrFail($id);
            $query->transaction_due_date = date('Y-m-d', strtotime($request->due_date));
            $query->value = str_replace(',', '', str_replace('.', '', $request->nominal));
            $query->note = $request->note;

            $query->pick_up_information_name = $request->pick_up_information_name;
            $query->pick_up_information_email = $request->pick_up_information_email;
            $query->pick_up_information_phone_number = $request->pick_up_information_phone_number;
            $query->pick_up_information_mobile_number = $request->pick_up_information_mobile_number;
            $query->pick_up_information_pick_up_address = $request->pick_up_information_pick_up_address;

            $query->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id)
    {
        try {
            $query = PaymentRequest::find($id);

            DB::beginTransaction();

            if ($query) {
                $query->delete();

                DB::commit();

                return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
            }

            return redirect()->back()->with('error', Constants::ERROR_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function upload_document(Request $request)
    {
        try {
            $fileDirectory = 'request-payments';
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
        $prefix = 'PY-R';
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = (int) date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $query = PaymentRequest::query()->orderBy('transaction_code', 'DESC')->first();
        if ($query) {
            $transactionCodes = explode('/',  $query->transaction_code);
            $number = ((int) $transactionCodes[0]) + 1;
        } else {
            $number = 1;
        }

        return sprintf("%04s", $number) . "/" . $prefix . "/" . $romans[$month - 1] . "/" . $year;
    }
}
