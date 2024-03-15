<?php

namespace App\Http\Controllers;

use App\Constants;
use Illuminate\Http\Request;
use App\Models\DeliverySchedule;
use App\Models\DeliveryScheduleItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderCustomer;
use Illuminate\Http\RedirectResponse;
use App\Models\SelectedSourcingSupplier;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        $deliverySchedule = DeliverySchedule::all();
        return view('logistic.delivery_schedule.index', compact('deliverySchedule'));
    }

    public function add()
    {
        $transactionCode = $this->handle_generate_transaction_code(date('Y-m-d'));
        return view('logistic.delivery_schedule.add', [
            'transactionCode' => $transactionCode,
        ]);
    }

    public function search_po_customer(Request $request): JsonResponse
    {
        $query = PurchaseOrderCustomer::query()
            ->with([
                'quotation.sales_order.inquiry.visit.customer',
                'quotation.sales_order.inquiry.sales',
                'quotation.sales_order.sourcing.sales_order',
                'quotation.sales_order.sourcing.selected_sourcing_suppliers',
                'quotation.sales_order.sourcing.selected_sourcing_suppliers.supplier',
                'quotation.sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier',
                'quotation.sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product.inquiry',
                'quotation.quotation_items',
                'quotation.quotation_items.inquiry_product',
                'quotation.quotation_items.inquiry_product.inquiry',
                'quotation.quotation_items.inquiry_product.sourcing_items.sourcing_supplier'
            ])
            ->select([
                'purchase_order_customers.id AS id',
                'purchase_order_customers.kode_khusus AS kode_khusus',
                'purchase_order_customers.quotation_id AS quotation_id',
                'purchase_order_customers.transaction_date AS transaction_date',
                'purchase_order_customers.purchase_order_number AS purchase_order_number',
                'purchase_order_customers.status AS status',
                'purchase_order_customers.document_url AS document_url',
            ])
            ->whereRaw('purchase_order_customers.kode_khusus NOT IN (SELECT po_customer_id FROM delivery_schedules)')
            ->where('id', 'like', '%' . $request->term . '%')
            ->where('kode_khusus', '!=', null)
            ->orderBy('id')
            ->get()
            ->take(20);

        return response()->json($query);
    }

    public function handle_generate_transaction_code($date): string
    {
        $prefix = 'DO';
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = (int) date('m', strtotime($date));
        $year = date('y', strtotime($date));
        $query = DeliverySchedule::query()->orderBy('transaction_code', 'DESC')->first();
        if ($query) {
            $transactionCodes = explode('/',  $query->transaction_code);
            $number = ((int) $transactionCodes[0]) + 1;
        } else {
            $number = 1;
        }

        return sprintf("%04s", $number) . "/" . $prefix . "/" . $romans[$month - 1] . "/" . $year;
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'delivery_date' => 'required',
                'terms' => 'required',
                'item' => 'required',
            ]);

            DB::beginTransaction();

            $deliverySchedule = new DeliverySchedule();
            $deliverySchedule->transaction_code = $this->handle_generate_transaction_code(date('Y-m-d'));
            $deliverySchedule->po_customer_id = $request->po_customer_id;
            $deliverySchedule->delivery_date = $request->delivery_date;
            $deliverySchedule->terms = $request->terms;
            $deliverySchedule->status = 'On Progress';
            $deliverySchedule->save();

            foreach ($request->item as $selectedSourcingSupplierId => $item) {
                $selectedSourcingSupplier = SelectedSourcingSupplier::query()->whereUuid($selectedSourcingSupplierId)->first();
                if ($selectedSourcingSupplier) {
                    $DeliveryScheduleItem = new DeliveryScheduleItem();
                    $DeliveryScheduleItem->delivery_schedule_id = $deliverySchedule->id;
                    $DeliveryScheduleItem->selected_sourcing_supplier_id = $selectedSourcingSupplier->uuid;
                    $DeliveryScheduleItem->save();
                }
            }

            DB::commit();

            return redirect()->route('logistic.delivery_order.index')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput($request->input())->with('error', Constants::ERROR_MSG);
        }
    }

    public function update_status(Request $request, $id): RedirectResponse
    {
        try {
            $deliverySchedule = DeliverySchedule::where('id', $id)->first();
            if ($deliverySchedule) {
                $deliverySchedule->status = $request->status;
                $deliverySchedule->save();
            }

            return redirect()->back()->with('success', Constants::CHANGE_STATUS_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
