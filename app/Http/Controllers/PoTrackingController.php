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

        $query = Tracking::with(
            [
                'purchase_order_supplier'
            ]
        );
        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }
        return view('po_tracking.index');
    }

    public function add(): View
    {
        return view('po_tracking.add');
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
        DB::beginTransaction();
        try {
            $query = new Tracking();
            $query->po_suplier_id = $request->po_suplier_id;
            $query->status = 'Ready Pick Up';
            $query->save();

            foreach ($request->input('details') as $detail) {
                ForwarderItem::create([
                    'tracking_id' => $query->id,
                    'forwarder_id' => $detail['forwarder_id'],
                    'price' => $detail['price'],
                    'track' => $detail['track'],
                    'description' => $detail['description'],
                ]);
            }

            // if ($request->document_list) {
            //     $files = json_decode($request->document_list, true);
            //     $fileDirectory = 'purchase-order-suppliers';
            //     foreach ($files as $item) {
            //         $sourceFilePath = storage_path('app/temp/' . $fileDirectory . '/' . $item['filename']);
            //         $destinationFilePath = storage_path('app/public/' . $fileDirectory . '/' . $item['filename']);

            //         if (!Storage::exists('public/' . $fileDirectory)) {
            //             Storage::makeDirectory('public/' . $fileDirectory);
            //         }

            //         if (file_exists($sourceFilePath)) {
            //             rename($sourceFilePath, $destinationFilePath);
            //         }
            //     }
            // }

            DB::commit();

            return ["data" => $query];
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput($request->input())->with('quotation', $quotation)->with('error', Constants::ERROR_MSG);
        }
    }
}
