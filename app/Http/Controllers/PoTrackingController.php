<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Stock;
use App\Models\Tracking;
use App\Models\Forwarder;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ForwarderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderSupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
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
            $tracking->name_pickup_information = $request->name;
            $tracking->email_pickup_information = $request->email;
            $tracking->phone_number_pickup_information = $request->phone_number;
            $tracking->mobile_number_pickup_information = $request->mobile_number;
            $tracking->pickup_address = $request->pickup_address;
            $tracking->status = 'Ready Pick Up';
            $tracking->save();

            $files = json_decode($request->pdf, true);
            
            foreach ($files as $item) {
                $sourcePath = storage_path('app/temp/' . $tracking->po_suplier_id . '/' . $item['filename']);
                $destinationPath = storage_path('app/public/tracking/' . $tracking->po_suplier_id . '/' . $item['filename']);

                if (!Storage::exists('public/tracking/' . $tracking->po_suplier_id)) {
                    Storage::makeDirectory('public/tracking/' . $tracking->po_suplier_id);
                }

                if (file_exists($sourcePath)) {
                    rename($sourcePath, $destinationPath);
                }
            }

            $tracking->files = $request->pdf;
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

            $key = 'tracking_pickup_pdf_' . $tracking->po_suplier_id . '_' . auth()->user()->uuid;
            Redis::del($key);

            return redirect()->route('po-tracking.index')->with("success", Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function update_status(Request $req, $id)
    {
        try {
            DB::beginTransaction();

            $tracking = Tracking::find($id);
            if (!$tracking) {
                throw new \Exception("Tracking not found");
            }

            $tracking->status = $req->status;

            if ($req->status == 'Done') {
                $items = $tracking->purchase_order_supplier->sales_order->inquiry->products;
                $itemsQty = $tracking->purchase_order_supplier->sales_order->sourcing->sourcing_supplier;
                $poc_id = $tracking->purchase_order_supplier->sales_order->quotations[0]->purchase_order_customer->kode_khusus;

                foreach ($items as $i => $item) {
                    $stock = new Stock();
                    $stock->po_supplier_id = $tracking->po_suplier_id;
                    $stock->po_customer_id = $poc_id;
                    $stock->item_name = $item->item_name;
                    $stock->description = $item->description;
                    $stock->size = $item->size;
                    $stock->remark = $item->remark;
                    $stock->qty = $itemsQty[$i]->qty;
                    $stock->save();
                }
            }

            $tracking->save();

            DB::commit();
            return redirect()->back()->with("success", Constants::CHANGE_STATUS_SUCCESS_MSG);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with("error", "Failed to update status: " . $e->getMessage());
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

    public function open($id)
    {
        $tracking = Tracking::with([
            'purchase_order_supplier',
            'purchase_order_supplier.sales_order.sourcing.selected_sourcing_suppliers.supplier',
            'purchase_order_supplier.sales_order.sourcing.selected_sourcing_suppliers.sourcing_supplier.inquiry_product',
            'purchase_order_supplier.sales_order.inquiry.visit.customer',
            'purchase_order_supplier.sales_order.quotations.purchase_order_customer',
        ])->where('uuid', $id)->first();
        $forwarders = ForwarderItem::where("tracking_id", $tracking->id)->orderBy("created_at", "desc")->first();
        $forwarders_items = [];
        foreach ($forwarders->tracking->purchase_order_supplier->sales_order->sourcing->sourcing_supplier as $v) {
            $forwarders_items[$v->inquiry_product_id][] = $v;
        }

        $data['forwarders'] = \App\Models\Forwarder::get();
        $data['forwarders_item'] = $forwarders_items;

        return view('po_tracking.open', compact('tracking', 'data'));
    }

    public function get_pdf(Request $request): JsonResponse
    {
        $po_supplier = $request->po_supplier;
        $po = PurchaseOrderSupplier::where('transaction_code', $po_supplier)->first();
        $key = 'tracking_pickup_pdf_' . $po->uuid . '_' . auth()->user()->uuid;
        $data = json_decode(Redis::get($key), true);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function upload_pdf(Request $request): JsonResponse
    {
        try {
            if ($request->hasFile('file')) {
                $po_supplier = $request->po_supplier;
                $po = PurchaseOrderSupplier::where('id', $po_supplier)->first();
                $file = $request->file('file');
                $path = $po_supplier;
                $upload = $this->fileController->store_temp($file, $path);
                if ($upload->original['status'] == 200) {
                    $key = 'tracking_pickup_pdf_' . $po_supplier . '_' . auth()->user()->uuid;
                    $data = $upload->original['data'];
                    $redis = $this->redisController->store($key, $data);

                    if ($redis->original['status'] == 200) {
                        $data = json_decode(Redis::get($key), true);

                        return response()->json([
                            'status' => 200,
                            'message' => 'success',
                            'data' => $data
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => "error: " . $e->getMessage() . " at line " . $e->getLine(),
            ]);
        }
    }

    public function delete_pdf(Request $request): JsonResponse
    {
        try {
            $po_supplier = $request->po_supplier;
            $file = $request->file;
            if ($request->has('edit')) {
                $path = 'public/po-tracking/' . $po_supplier . '/' . $file;
            } else {
                $path = 'temp/' . $po_supplier . '/' . $file;
            }
            $exist = Storage::exists($path);
            if ($exist) {
                $delete = Storage::delete($path);

                if ($delete) {
                    $key = 'tracking_pickup_pdf_' . $po_supplier . '_' . auth()->user()->uuid;
                    $redis = $this->redisController->delete_item($key, 'filename', $file);
                    if ($redis->original['status'] == 200) {
                        $data = json_decode(Redis::get($key), true);

                        if (sizeof($data) == 0) {
                            Redis::del($key);
                        }

                        return response()->json([
                            'status' => 200,
                            'message' => 'success',
                            'data' => $data
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'error'
            ]);
        }
    }
}
