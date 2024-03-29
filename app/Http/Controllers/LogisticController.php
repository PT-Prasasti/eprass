<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\DeliverySchedule;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Models\BTB;
use App\Models\PurchaseOrderSupplier;
use App\Models\Supplier;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class LogisticController extends Controller
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

    public function index()
    {
        $deliverySchedule = DeliverySchedule::all();
        return view('logistic.dashboard', compact('deliverySchedule'));
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $potracking = Tracking::with('purchase_order_supplier.sales_order.inquiry')->select('*'); // Select all columns you need
            $result = DataTables::of($potracking)
                ->addIndexColumn()
                ->addColumn('pos_number', function ($tracking) {
                    return $tracking->purchase_order_supplier->transaction_code;
                })
                ->addColumn('status', function ($tracking) {
                    return $tracking->status;
                })
                ->addColumn('estimate_date', function ($tracking) {
                    return Carbon::parse($tracking->purchase_order_supplier->sales_order->inquiry->due_date)->format('d F Y');
                })
                ->addColumn('uuid', function ($tracking) {
                    return $tracking->uuid;
                })
                ->make(true);
            return $result;
        }
    }

    public function dataStock(Request $request)
    {
        if ($request->ajax()) {
            $stock = Stock::orderBy('po_customer_id', 'ASC')->get();
            $result = DataTables::of($stock)
                ->addIndexColumn()
                ->addColumn('item_name', function ($item) {
                    return $item->item_name;
                })
                ->addColumn('qty', function ($item) {
                    return $item->qty;
                })
                ->addColumn('po_customer', function ($item) {
                    return $item->po_customer_id;
                })
                ->make(true);
            return $result;
        }
    }

    public function dataDo(Request $request)
    {
        if ($request->ajax()) {
            $deliverySchedule = DeliverySchedule::orderBy('created_at', 'ASC')->get();
            $result = DataTables::of($deliverySchedule)
                ->addIndexColumn()
                ->addColumn('po_customer_id', function ($item) {
                    return $item->po_customer_id;
                })
                ->addColumn('customer_name', function ($item) {
                    return $item->poc->quotation->sales_order->inquiry->visit->customer->name;
                })
                ->addColumn('due_date', function ($item) {
                    return Carbon::parse($item->poc->quotation->sales_order->inquiry->due_date)->format('d M Y');
                })
                ->addColumn('schedule_date', function ($item) {
                    return Carbon::parse($item->delivery_date)->format('d M Y');
                })
                ->addColumn('status', function ($item) {
                    return $item->status;
                })
                ->addColumn('id', function ($item) {
                    return $item->id;
                })
                ->make(true);
            return $result;
        }
    }

    public function gr_index()
    {
        return view('logistic.good_received.index');
    }

    public function gr_data()
    {
        $btb = BTB::all();
        $result = DataTables::of($btb)
            ->addIndexColumn()
            ->make(true);

        return $result;
    }

    public function gr_add()
    {
        return view('logistic.good_received.add');
    }

    public function gr_get_supplier(Request $request)
    {
        $purchase_order_supplier = PurchaseOrderSupplier::where('purchase_order_suppliers.id', $request->id)->join('suppliers', 'purchase_order_suppliers.supplier_id', '=', 'suppliers.uuid')->select('purchase_order_suppliers.*', 'suppliers.company')->first();

        return response()->json($purchase_order_supplier);
    }

    public function gr_get_product(Request $request)
    {
        $supp_items = PurchaseOrderSupplier::where('purchase_order_suppliers.id', $request->id)
            ->join('purchase_order_supplier_items', 'purchase_order_suppliers.id', '=', 'purchase_order_supplier_items.purchase_order_supplier_id')
            ->join('selected_sourcing_suppliers', 'purchase_order_supplier_items.selected_sourcing_supplier_id', '=', 'selected_sourcing_suppliers.uuid')
            ->join('sourcings', 'selected_sourcing_suppliers.sourcing_id', '=', 'sourcings.id')
            ->join('sales_orders', 'sourcings.so_id', '=', 'sales_orders.id')
            ->join('inquiries', 'sales_orders.inquiry_id', '=', 'inquiries.id')
            ->join('inquiry_products', 'inquiries.id', '=', 'inquiry_products.inquiry_id')
            ->select('inquiry_products.id', 'inquiry_products.item_name', 'inquiry_products.qty')
            ->get();

        $result = DataTablesDataTables::of($supp_items)
            ->addIndexColumn()
            ->make(true);

        return $result;
    }

    public function gr_store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'purchase_order_supplier_id' => 'required|exists:purchase_order_suppliers,id',
            'supplier_name' => 'required',
            'date' => 'required',
            'note' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' => $validation->errors()->first()]);
        }

        BTB::create([
            'purchase_order_supplier_id' => $request->purchase_order_supplier_id,
            'purchase_order_supplier_number' => PurchaseOrderSupplier::find($request->purchase_order_supplier_id)->transaction_code,
            'supplier_name' => $request->supplier_name,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        $purchase_order_supplier = PurchaseOrderSupplier::find($request->purchase_order_supplier_id);
        $purchase_order_supplier->update([
            'document_list' => ($request->pdf == 'null') ? '' : $request->pdf,
        ]);

        $po_supplier_number = $purchase_order_supplier->transaction_code;

        if ($request->pdf != 'null') {
            $files = json_decode($request->pdf, true);
            foreach ($files as $item) {
                $sourcePath = storage_path('app/temp/' . str_replace('/', '_', $po_supplier_number) . '/' . $item['filename']);
                $destinationPath = storage_path('app/public/good-received/' . str_replace('/', '_', $po_supplier_number) . '/' . $item['filename']);

                if (!Storage::exists('public/good-received/' . str_replace('/', '_', $po_supplier_number))) {
                    Storage::makeDirectory('public/good-received/' . str_replace('/', '_', $po_supplier_number));
                }

                if (file_exists($sourcePath)) {
                    rename($sourcePath, $destinationPath);
                }
            }

            Storage::deleteDirectory('temp/' . $po_supplier_number);
        }

        $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
        Redis::del($key);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    public function gr_view($uuid)
    {
        $btb = BTB::where('b_t_b_s.uuid', $uuid)
            ->join('purchase_order_suppliers', 'b_t_b_s.purchase_order_supplier_id', '=', 'purchase_order_suppliers.id')
            ->join('suppliers', 'purchase_order_suppliers.supplier_id', '=', 'suppliers.uuid')
            ->select('suppliers.company', 'b_t_b_s.*', 'purchase_order_suppliers.id as purchase_order_supplier_id')
            ->first();

        return view('logistic.good_received.view', compact('btb'));
    }

    public function gr_update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'uuid' => 'required|exists:b_t_b_s,uuid',
            'date' => 'required',
            'note' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' => $validation->errors()->first()]);
        }

        $btb = BTB::where('uuid', $request->uuid)->first();
        $btb->update([
            'date' => $request->date,
            'note' => $request->note,
        ]);

        $purchase_order_supplier = PurchaseOrderSupplier::find($btb->purchase_order_supplier_id);
        $purchase_order_supplier->update([
            'document_list' => ($request->pdf == 'null') ? '' : $request->pdf,
        ]);

        $po_supplier_number = $purchase_order_supplier->transaction_code;

        if ($request->pdf != 'null') {
            $files = json_decode($request->pdf, true);
            foreach ($files as $item) {
                $sourcePath = storage_path('app/temp/' . str_replace('/', '_', $po_supplier_number) . '/' . $item['filename']);
                $destinationPath = storage_path('app/public/good-received/' . str_replace('/', '_', $po_supplier_number) . '/' . $item['filename']);

                if (!Storage::exists('public/good-received/' . str_replace('/', '_', $po_supplier_number))) {
                    Storage::makeDirectory('public/good-received/' . str_replace('/', '_', $po_supplier_number));
                }

                if (file_exists($sourcePath)) {
                    rename($sourcePath, $destinationPath);
                }
            }

            Storage::deleteDirectory('temp/' . $po_supplier_number);
        }

        $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
        Redis::del($key);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    public function gr_delete(Request $request)
    {
        $btb = BTB::where('uuid', $request->uuid)->first();
        $purchase_order_supplier = PurchaseOrderSupplier::find($btb->purchase_order_supplier_id);
        $po_supplier_number = str_replace('/', '_', $purchase_order_supplier->transaction_code);

        $files = $purchase_order_supplier->document_list == '' ? [] : json_decode($purchase_order_supplier->document_list, true);
        if (sizeof($files) > 0) {
            foreach ($files as $item) {
                $path = 'public/good-received/' . $po_supplier_number . '/' . $item['filename'];
                $exist = Storage::exists($path);
                if ($exist) {
                    Storage::delete($path);
                }
            }
        }

        $purchase_order_supplier->update([
            'document_list' => null,
        ]);

        $btb->delete();

        $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
        Redis::del($key);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }

    public function gr_upload_pdf(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $po_supplier_number = str_replace('/', '_', $request->po_supplier_number);
                $file = $request->file('file');
                $path = $po_supplier_number;
                $upload = $this->fileController->store_temp($file, $path);
                if ($upload->original['status'] == 200) {
                    $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
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
                'message' => 'error'
            ]);
        }
    }

    public function gr_get_pdf(Request $request)
    {
        $po_supplier_number = $request->po_supplier_number;
        $po_supplier_number = str_replace('/', '_', $po_supplier_number);
        $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
        $data = json_decode(Redis::get($key), true);

        if ($data == null) {
            // 
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function gr_delete_pdf(Request $request)
    {
        try {
            $po_supplier_number = $request->po_supplier_number;
            $po_supplier_number = str_replace('/', '_', $po_supplier_number);
            $file = $request->file;
            if ($request->has('edit')) {
                $path = 'public/good-received/' . $po_supplier_number . '/' . $file;
            } else {
                $path = 'temp/' . $po_supplier_number . '/' . $file;
            }
            $exist = Storage::exists($path);
            if ($exist) {
                $delete = Storage::delete($path);

                if ($delete) {
                    $key = 'good_received_pdf_' . $po_supplier_number . '_' . auth()->user()->uuid;
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
