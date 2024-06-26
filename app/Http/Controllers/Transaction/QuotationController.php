<?php

namespace App\Http\Controllers\Transaction;

use Exception;
use App\Constants;
use App\Models\Quotation;
use Illuminate\View\View;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use Illuminate\Http\JsonResponse;
use App\Constants\VatTypeConstant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Constants\PaymentTermConstant;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Http\Requests\Transaction\Quotation\AddQuotationRequest;
use App\Http\Requests\Transaction\Quotation\UpdateQuotationRequest;

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
                    'sales_order.inquiry.visit.customer',
                    'sales_order.inquiry.sales'
                ]);

            if ($request->filter === 'reject') {
                $data->where('status', 'Rejected');
            } elseif ($request->filter === 'revision') {
                $data->where('status', 'Revision');
            }

            if (!$request->filter || !in_array($request->filter, ['reject', 'revision'])) {
                $data->whereIn('status', ['Waiting for Approval', 'Done']);
            }


            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('status', function ($q) {
                    return strtoupper($q->sales_order->status);
                })
                ->addColumn('quotation_status', function ($q) {
                    return $q->status;
                })
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
                'quotations',
            ])
            ->where('sales_orders.id', 'like', '%' . $request->term . '%')
            ->orderBy('sales_orders.id')
            ->get()
            ->where('can_be_added_quotation', true)
            ->take(20);

        return response()->json($data);
    }

    public function store(AddQuotationRequest $request): RedirectResponse
    {
        $salesOrder = SalesOrder::query()
            ->with([
                'inquiry.visit.customer',
                'inquiry.sales',
                'inquiry.products',
                'quotations',
            ])
            ->where('sales_orders.uuid', $request->sales_order)
            ->first();

        try {
            $cost = [];
            foreach ($request->item as $key => $item) {
                $cost[$key] = str_replace(',', '.', str_replace('.', '', $item['cost']));
                if ($item['original_cost'] > $cost[$key]) {

                    return redirect()->back()->withInput($request->input())->with('salesOrder', $salesOrder)->with('error', Constants::ERROR_MSG);
                }
            }

            DB::beginTransaction();

            $quotation = Quotation::query()->create([
                'sales_order_id' => $request->sales_order,
                'quotation_code' =>  $this->handleGenerateQuotationCode($request->sales_order),
                'status' => 'Waiting for Approval',
                'due_date' => $request->due_date,
                'payment_term' => $request->payment_term,
                'delivery_term' => $request->delivery_term,
                'vat' => $request->vat,
                'validity' => $request->validity,
                'attachment' => $request->attachment,
            ]);

            $quotation->quotation_items()->delete();
            foreach ($request->item as $inquiryProductId => $item) {
                $quotationItem = QuotationItem::query()->updateOrCreate([
                    'quotation_id' => $quotation->id,
                    'inquiry_product_id' => $inquiryProductId,
                ], [
                    'cost' =>  $cost[$inquiryProductId],
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

    public function reCreate($id): View
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

        return view('transaction.quotation.re_create', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes
        ]);
    }

    public function reCreateStore($id, AddQuotationRequest $request): RedirectResponse
    {
        // dd($request->all());
        $quotation = Quotation::query()
            ->with([
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'sales_order.inquiry.products',
            ])
            ->findOrFail($id);

        try {
            $cost = [];
            foreach ($request->item as $key => $item) {
                $cost[$key] = str_replace(',', '.', str_replace('.', '', $item['cost']));
                if ($item['original_cost'] > $cost[$key]) {

                    return redirect()->back()->withInput($request->input())->with('error', 'Nilai up price tidak boleh kurang dari unit price yang sudah ditentukan');
                }
            }

            DB::beginTransaction();

            $quotation = Quotation::query()->create([
                'sales_order_id' => $quotation->sales_order_id,
                // 'quotation_code' =>  $this->handleGenerateQuotationCode($quotation->sales_order_id),
                'quotation_code' =>  $quotation->quotation_code,
                'status' => 'Waiting for Approval',
                'due_date' => $request->due_date,
                'payment_term' => $request->payment_term,
                'delivery_term' => $request->delivery_term,
                'vat' => $request->vat,
                'validity' => $request->validity,
                'attachment' => $request->attachment,
            ]);

            $quotation->quotation_items()->delete();
            foreach ($request->item as $inquiryProductId => $item) {
                $quotationItem = QuotationItem::query()->updateOrCreate([
                    'quotation_id' => $quotation->id,
                    'inquiry_product_id' => $inquiryProductId,
                ], [
                    'cost' =>  $cost[$inquiryProductId],
                ]);

                $quotationItem->total_cost = number_format($quotationItem->inquiry_product->sourcing_qty * $quotationItem->cost, 2, '.', '');
                $quotationItem->save();
            }

            DB::commit();

            return redirect()->route('transaction.quotation')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('error', Constants::ERROR_MSG);
        }
    }

    public function revision($id): View
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
        $revCode = $this->handleGenerateRevisionCode($query->quotation_code);

        return view('transaction.quotation.revision', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
            'revCode' => $revCode
        ]);
    }

    public function revisionStore($id, Request $request): RedirectResponse
    {
        $quotation = Quotation::query()
            ->with([
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'sales_order.inquiry.products',
            ])
            ->findOrFail($id);

        try {
            $cost = [];
            foreach ($request->item as $key => $item) {
                $cost[$key] = str_replace(',', '.', str_replace('.', '', $item['cost']));
                if ($item['original_cost'] > $cost[$key]) {

                    return redirect()->back()->withInput($request->input())->with('error', 'Nilai up price tidak boleh kurang dari unit price yang sudah ditentukan');
                }
            }

            DB::beginTransaction();

            $quotation = Quotation::query()->create([
                'sales_order_id' => $quotation->sales_order_id,
                'quotation_code' =>  $this->handleGenerateRevisionCode($quotation->quotation_code),
                'status' => 'Waiting for Approval',
                'due_date' => $request->due_date,
                'payment_term' => $request->payment_term,
                'delivery_term' => $request->delivery_term,
                'vat' => $request->vat,
                'validity' => $request->validity,
                'attachment' => $request->attachment,
            ]);

            $quotation->quotation_items()->delete();
            foreach ($request->item as $inquiryProductId => $item) {
                $quotationItem = QuotationItem::query()->updateOrCreate([
                    'quotation_id' => $quotation->id,
                    'inquiry_product_id' => $inquiryProductId,
                ], [
                    'cost' =>  $cost[$inquiryProductId],
                ]);

                $quotationItem->total_cost = number_format($quotationItem->inquiry_product->sourcing_qty * $quotationItem->cost, 2, '.', '');
                $quotationItem->save();
            }

            DB::commit();

            return redirect()->route('transaction.quotation')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
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
            'id' => $id,
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function update($id, UpdateQuotationRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if ($request->status === 'approve') {
                $query = Quotation::query()->findOrFail($id);
                $query->status = 'Done';
            } else {
                $query = Quotation::query()->findOrFail($id);
                $query->reason_for_refusing = $request->reason_for_refusing;
                $query->status = 'Rejected';
            }

            $query->save();

            DB::commit();

            return redirect()->route('transaction.quotation')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->with('salesOrder', $salesOrder)->with('error', Constants::ERROR_MSG);
        }
    }

    public function revisionComment($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $query = Quotation::query()->findOrFail($id);

            if ($query) {
                $query->revision_note = $request->revision_note;
                $query->status = 'Revision';
                $query->save();
            }
            DB::commit();

            return redirect()->route('transaction.quotation')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
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

    public function print($id)
    {
        $query = Quotation::query()
            ->with([
                'sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product.quotation_item',
                'sales_order.inquiry.visit.customer',
                'sales_order.inquiry.sales',
                'sales_order.inquiry.products',
            ])
            ->findOrFail($id);

        $paymentTerms = PaymentTermConstant::texts();
        $vatTypes = VatTypeConstant::texts();

        return view('transaction.quotation.print', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
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

            $lastData = Quotation::query()
                ->withTrashed()
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->orderBy('created_at', 'DESC')
                ->first();

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

    public function handleGenerateRevisionCode($quotationCode): string
    {
        $baseParts = explode('/', preg_replace('/\/Rev-\d+/', '', $quotationCode));
        $revisionNumber = $this->getRevisionNumber($quotationCode);
    
        $newRevisionNumber = $revisionNumber + 1;
    
        $revisedQuotationCode = implode('/', $baseParts) . "/Rev-" . $newRevisionNumber;
    
        return $revisedQuotationCode;
    }

    private function getRevisionNumber($quotationCode): int
    {
        $parts = explode('/Rev-', $quotationCode);
        if (count($parts) > 1) {
            return (int) $parts[1];
        }

        return 0;
    }
}