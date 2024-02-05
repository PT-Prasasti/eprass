<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Forwarder;
use App\Models\ForwarderItem;
use App\Models\PurchaseOrderSupplier;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;

class PoTrackingController extends Controller
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
        $data = Tracking::with(['purchase_order_supplier.supplier'])->orderBy('created_at', 'DESC')
        ->get();
        return view('po_tracking.index', compact('data'));
    }

    public function add(): View
    {
        $data['forwarders'] = \App\Models\Forwarder::get();
        return view('po_tracking.add', $data);
    }

    public function search_po_supplier(Request $request): JsonResponse
    {
        $query = PurchaseOrderSupplier::query()
            ->with([
                'sales_order.sourcing.selected_sourcing_suppliers.supplier',
                'sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product',
                'sales_order.inquiry',
                'sales_order.inquiry.visit.customer',
                'sales_order.quotations.purchase_order_customer',
            ])

            ->whereHas('sales_order.quotations.purchase_order_customer')
            ->whereHas('sales_order.sourcing.selected_sourcing_suppliers.supplier')
            ->whereHas('sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product')
            ->where('id', 'like', '%' . $request->term . '%')
            ->orderBy('id')
            ->get()
            ->take(20);

        return response()->json($query);
    }

    public function search_forwarder(Request $request): JsonResponse
    {
        $query = Forwarder::query()
            ->where('id', 'like', '%' . $request->term . '%')
            ->get()
            ->take(20);

        return response()->json($query);
    }

    public function store(Request $request)
    {
        $inquery_id = $request->so_id[0];
        $par = [];

        foreach ($request->product_inquery_id as $value) {
            foreach ($request->forwarder_id[$value] as $key => $r) {
                $par[$value][$key] = [
                    'so_id' => $inquery_id,
                    'forwarder_id' => $request->forwarder_id[$value][$key],
                    'forwarder' => \App\Models\Forwarder::find($request->forwarder_id[$value][$key]),
                    'inquery_products' => \App\Models\InquiryProduct::find($value),
                    'price' => str_replace(".", "", $request->price[$value][$key]),
                    "track" => $request->track[$value][$key],
                    "description" => $request->description[$value][$key],
                ];
            }
        }

        try {
            DB::beginTransaction();
            $tracking = new Tracking();
            $tracking->po_suplier_id = $request->selected_po_supplier;
            $tracking->status = 'Ready Pick Up';
            $tracking->save();

            foreach ($par as $product_inquery_id => $items) {
                foreach ($items as $item) {
                    $forwarderItem = new \App\Models\ForwarderItem;
                    $forwarderItem->tracking_id = $tracking->id;
                    $forwarderItem->forwarder_id = $item['forwarder']->id;
                    $forwarderItem->price = $item['price'];
                    $forwarderItem->track = $item['track'];
                    $forwarderItem->description = $item['description'];
                    $forwarderItem->save();
                }
            }

            DB::commit();

            return redirect(route('po-tracking.add'))->with("success", "Data has beed successfuly submited");
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function update_status(Request $req, $id)
    {
        $tracking = Tracking::find($id);
        if ($tracking) {
            $tracking->status = $req->status;
            $tracking->save();
            return redirect()->back()->with("success", "Status updated successfully");
        } else {
            return redirect()->back()->with("error", "Failed to update status");
        }
    }

    public function view($id)
    {
        $tracking = Tracking::with([
            'purchase_order_supplier',
            'purchase_order_supplier.sales_order.sourcing.selected_sourcing_suppliers.supplier',
            'purchase_order_supplier.sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product',
            'purchase_order_supplier.sales_order.inquiry.visit.customer',
            'purchase_order_supplier.sales_order.quotations.purchase_order_customer',
        ])->where('uuid', $id)->first();
    
        return view('po_tracking.view', compact('tracking'));
    }
}
