<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants;
use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Models\PaymentRequest;
use App\Models\PurchaseOrderSupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ListPaymentController extends Controller
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
                'payment_requests.kode_payment AS kode_payment',
            ]);

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('list-payment.index');
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

        return view('list-payment.edit', [
            'query' => $query,
        ]);
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $query = PaymentRequest::query()->findOrFail($id);
            $query->status = 'Waiting for Approval Manager';

            $query->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function bukti_transfer($id)
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

        return view('list-payment.bukti', [
            'query' => $query,
        ]);
    }
}
