<?php

namespace App\Http\Controllers\PurchaseOrderCustomer;

use App\Constants;
use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use Illuminate\View\View;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Http\Requests\PurchaseOrderCustomer\AddPurchaseOrderCustomerRequest;
use App\Http\Requests\PurchaseOrderCustomer\UpdatePurchaseOrderCustomerRequest;
use App\Http\Requests\Transaction\Quotation\AddQuotationRequest;
use App\Http\Requests\Transaction\Quotation\UpdateQuotationRequest;
use App\Models\PurchaseOrderCustomer;
use App\Models\Quotation;
use App\Models\QuotationItem;

class PurchaseOrderCustomerController extends Controller
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
        $query = PurchaseOrderCustomer::query()
            ->with([
                'quotation.sales_order.inquiry.visit.customer',
                'quotation.sales_order.inquiry.sales',
            ])
            ->select([
                'purchase_order_customers.id AS id',
                'purchase_order_customers.quotation_id AS quotation_id',
                'purchase_order_customers.transaction_date AS transaction_date',
                'purchase_order_customers.purchase_order_number AS purchase_order_number',
                'purchase_order_customers.status AS status',
                'purchase_order_customers.document_url AS document_url',
            ]);

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('purchase-order-customer.index');
    }

    public function add(): View
    {
        return view('purchase-order-customer.add');
    }

    public function search_quotation(Request $request): JsonResponse
    {
        $query = Quotation::query()
            ->with([
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'quotation_items.inquiry_product',
            ])
            ->where('quotation_code', 'like', '%' . $request->term . '%')
            ->take(20)
            ->orderBy('quotation_code')
            ->get();

        return response()->json($query);
    }

    public function store(AddPurchaseOrderCustomerRequest $request): RedirectResponse
    {
        $quotation = Quotation::query()
            ->with([
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'quotation_items.inquiry_product',
            ])
            ->find($request->quotation)
            ->first();
        try {
            DB::beginTransaction();

            $query = PurchaseOrderCustomer::query()->updateOrCreate(
                [
                    'quotation_id' => $request->quotation,
                ],
                [
                    'transaction_date' => date('Y-m-d'),
                    'purchase_order_number' => $request->purchase_order_number,
                    'document_url' => $request->document,
                    'status' => 'ON PROGRESS',
                ]
            );

            if ($query->quotation->quotation_items->count() > 0) {
                foreach ($query->quotation->quotation_items as $quotationItem) {
                    if (isset($request->item[$quotationItem->id])) {
                        $quotationItem->delivery_time_of_purchase_order_customer = $request->item[$quotationItem->id]['delivery_time'];
                        $quotationItem->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('purchase-order-customer')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function edit($id, Request $request): View
    {
        $query = PurchaseOrderCustomer::query()
            ->with([
                'quotation.sales_order.inquiry.visit.customer',
                'quotation.sales_order.inquiry.sales',
                'quotation.quotation_items',
            ])
            ->findOrFail($id);

        return view('purchase-order-customer.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdatePurchaseOrderCustomerRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $query = PurchaseOrderCustomer::query()->findOrFail($id);
            $query->purchase_order_number = $request->purchase_order_number;
            if (isset($request->document)) {
                $query->document_url = $request->document;
            }

            if ($query->quotation->quotation_items->count() > 0) {
                foreach ($query->quotation->quotation_items as $quotationItem) {
                    if (isset($request->item[$quotationItem->id])) {
                        $quotationItem->delivery_time_of_purchase_order_customer = $request->item[$quotationItem->id]['delivery_time'];
                        $quotationItem->save();
                    }
                }
            }

            $query->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('salesOrder', $salesOrder)->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id)
    {
        try {
            $query = PurchaseOrderCustomer::find($id);

            DB::beginTransaction();

            $query->quotation->quotation_items()->update([
                'delivery_time_of_purchase_order_customer' => null
            ]);
            $query->delete();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function uploadDocument(Request $request)
    {
        $filePath = null;
        if ($request->hasFile('file')) {
            $fileDirectory = 'purchase-order-customers';
            $file = $request->file('file');
            $filePath = $this->fileController->store($fileDirectory, $file);
        }

        return $filePath;
    }
}
