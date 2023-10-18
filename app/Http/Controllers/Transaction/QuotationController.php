<?php

namespace App\Http\Controllers\Transaction;

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
use App\Http\Requests\Transaction\Quotation\AddQuotationRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;

class QuotationController extends Controller
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

    public function index(): View
    {
        return view('transaction.quotation.index');
    }

    public function data(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Quotation::query()
                ->with([
                    'sales_order',
                    'sales_order.inquiry.visit.customer',
                ]);

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->toJson();
        }
    }

    public function add(): View
    {
        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('transaction.quotation.add', [
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes
        ]);
    }

    public function search_sales_orders(Request $request): JsonResponse
    {
        $data = SalesOrder::query()
            ->with([
                'inquiry.visit.customer',
                'inquiry.sales',
                'inquiry.products',
                'quotation',
            ])
            ->where('sales_orders.id', 'like', '%' . $request->term . '%')
            ->take(20)
            ->orderBy('sales_orders.id')
            ->get();

        return response()->json($data);
    }

    public function store(AddQuotationRequest $request): RedirectResponse
    {
        $salesOrder = SalesOrder::query()
            ->with([
                'inquiry.visit.customer',
                'inquiry.sales',
                'inquiry.products',
                'quotation',
            ])
            ->where('sales_orders.uuid', $request->sales_order)
            ->first();

        try {
            foreach ($request->item as $item) {
                if ($item['original_cost'] > $item['cost']) {

                    return redirect()->back()->withInput($request->input())->with('salesOrder', $salesOrder)->with('error', Constants::ERROR_MSG);
                }
            }

            DB::beginTransaction();

            $filePath = null;
            if ($request->hasFile('attachment')) {
                $fileDirectory = 'quotations';
                $file = $request->file('attachment');
                $filePath = $this->fileController->store($fileDirectory, $file);
            }

            $quotation = Quotation::query()->updateOrCreate([
                'sales_order_id' => $request->sales_order,
            ], [
                'quotation_code' =>  $this->handleGenerateQuotationCode($request->sales_order),
                'status' => 'Waiting for Approval',
                'due_date' => $request->due_date,
                'payment_term' => $request->payment_term,
                'delivery_term' => $request->delivery_term,
                'vat' => $request->vat,
                'validity' => $request->validity,
                'attachment_url' => $filePath,
            ]);

            $quotation->quotation_items()->delete();
            foreach ($request->item as $inquiryProductId => $item) {
                $quotationItem = QuotationItem::query()->updateOrCreate([
                    'quotation_id' => $quotation->id,
                    'inquiry_product_id' => $inquiryProductId,
                ], [
                    'cost' => $item['cost']
                ]);

                $quotationItem->total_cost = number_format($quotationItem->inquiry_product->sourcing_qty * $quotationItem->cost, 2, '.', '');
                $quotationItem->save();
            }

            DB::commit();

            return redirect()->route('transaction.quotation')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('salesOrder', $salesOrder)->with('error', Constants::ERROR_MSG);
        }
    }

    public function view($id): View
    {
        $query = Quotation::query()
            ->with([
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'sales_order.inquiry.products',
            ])
            ->findOrFail($id);

        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('transaction.quotation.view', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function delete($id)
    {
        try {
            $query = Quotation::find($id);

            DB::beginTransaction();

            $query->quotation_items()->delete();
            $query->delete();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function handleGenerateQuotationCode($salesOrderId): string
    {
        $salesOrder = SalesOrder::query()->whereUuid($salesOrderId)->first();
        $code = '';
        if ($salesOrder) {
            $salesOrderCodes = explode('/',  $salesOrder->id);
            $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            $prefix = 'Q';
            $month = (int) date('m');
            $year = date('y');

            $lastData = Quotation::orderBy('created_at', 'DESC')->withTrashed()->first();
            if ($lastData) {
                $codes = explode("/", $lastData->quotation_code);
                $number = (int) $codes[0];
                $number++;
            } else {
                $number = 1;
            }

            $code = sprintf("%04s", $number) . "/" . $prefix . "/" . $salesOrderCodes[0] . "/" . $romans[$month - 1] . "/" . $year;
        }

        return $code;
    }
}