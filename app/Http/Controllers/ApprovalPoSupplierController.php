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

class ApprovalPoSupplierController extends Controller
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

        return view('approval_po.index');
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

        return view('approval_po.edit', [
            'query' => $query,
            'paymentTerms' => $paymentTerms,
            'vatTypes' => $vatTypes,
        ]);
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $query = PurchaseOrderSupplier::query()->findOrFail($id);
            $query->status = 'Send PO';

            $query->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    public function reject($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $query = PurchaseOrderSupplier::query()->findOrFail($id);
            $query->status = 'Rejected By Manager';
            $query->reason = $request->reason_for_refusing;

            $query->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }

    
}
