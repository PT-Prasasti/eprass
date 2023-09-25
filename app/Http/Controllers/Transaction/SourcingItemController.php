<?php

namespace App\Http\Controllers\Transaction;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\InquiryProduct;
use App\Models\Supplier;
use App\Models\Sourcing;
use App\Models\SourcingItem;
use App\Models\SourcingSupplier;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SourcingItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('transaction.sourcing-item.index');
    }

    public function add(): View
    {
        return view('transaction.sourcing-item.add');
    }

    public function sales_order(): JsonResponse
    {
        $inquiries = SalesOrder::all();

        $result = array();

        foreach ($inquiries as $item) {
            $result[] = array(
                'id' => $item->id,
                'uuid' => $item->uuid,
            );
        }

        return response()->json($result);
    }

    public function so_detail($id): JsonResponse
    {
        // $redis = Redis::keys('*');
        // foreach($redis as $item) {
        //     if(str_contains($item, auth()->user()->uuid)) {
        //         if($this->hosting == false) {
        //             $item = explode('database_', $item);
        //             $item = $item[1];
        //         }
        //         Redis::del($item);
        //     }
        // }

        $so = SalesOrder::where('uuid', $id)->first();

        $result = array(
            'sales' => $so->inquiry->visit->sales->name,
            'customer' => $so->inquiry->visit->customer->name,
            'company' => $so->inquiry->visit->customer->company,
            'phone' => $so->inquiry->visit->customer->phone,
            'email' => $so->inquiry->visit->customer->email,
            'company_phone' => $so->inquiry->visit->customer->company_phone,
            'subject' => $so->inquiry->subject,
            'due_date' => Carbon::parse($so->inquiry->due_date)->format('d M Y'),
            'grade' => $so->inquiry->grade,
            'note' => $so->inquiry->description,
            'uuid' => $so->inquiry->visit->uuid
        );

        $id = $so->inquiry->visit->uuid;
        $key = 'so_pdf_' . $id . '_' . auth()->user()->uuid;
        $redis = Redis::get($key);
        if ($redis) {
            Redis::del($key);
        }
        Redis::set($key, $so->inquiry->files);

        $key = 'so_product_' . $id . '_' . auth()->user()->uuid;
        $redis = Redis::get($key);
        if ($redis) {
            Redis::del($key);
        }
        if (isset($so->inquiry->products)) {
            $data = array();

            foreach ($so->inquiry->products as $item) {
                $data[] = array(
                    $item->item_name,
                    $item->description,
                    $item->size,
                    $item->qty,
                    $item->remark,
                );
            }

            Redis::set($key, json_encode($data));
        }

        return response()->json($result);
    }

    public function get_pdf(Request $request): JsonResponse
    {
        $so = SalesOrder::where('uuid', $request->so)->first();
        $key = 'so_pdf_' . $so->inquiry->visit->uuid . '_' . auth()->user()->uuid;
        $data = json_decode(Redis::get($key), true);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function get_product(Request $request): JsonResponse
    {
        $so = SalesOrder::where('uuid', $request->so)->first();
        $uuid = $so->inquiry->uuid;
        $so = $so->inquiry->visit->uuid;
        $so = str_replace('/', '_', $so);
        $key = 'so_product_' . $so . '_' . auth()->user()->uuid;
        $data = json_decode(Redis::get($key), true);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data,
            'uuid' => $uuid
        ]);
    }

    public function review_get_data(Request $request)
    {
        try {
            if ($request->ajax()) {
                $salesOrder = SalesOrder::where('uuid', $request->inquiry)->first();
                $data = InquiryProduct::where('inquiry_id', $salesOrder->inquiry_id)->get();

                $result = DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('uuid', function ($q) {
                        return $q->uuid;
                    })
                    ->addColumn('item_desc', function ($q) {
                        return $q->description;
                    })
                    ->addColumn('qty', function ($q) {
                        return $q->qty;
                    })
                    ->make(true);

                return $result;
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function store_sourcing_suppliers(Request $request)
    {
        // 
    }

    public function store(Request $request) 
    {
        try {
            $sourcing = new Sourcing();
            $sourcing->so_id = $request->so;
            $sourcing->save();
        
            $atLeastOneInputFilled = false;
    
            foreach ($request->description as $key => $desc) {
                if (!empty($desc)) {
                    $atLeastOneInputFilled = true;
                }
                
                $sourSup = new SourcingSupplier();
                $sourSup->sourcing_id   = $sourcing->id;
                $sourSup->supplier_id   = 11;
                $sourSup->company       = "-";
                $sourSup->item_name     = "-";
                $sourSup->description   = $desc;
                $sourSup->qty           = $request->quantity[$key];
                $sourSup->unitprice     = $request->unitprice[$key];
                $sourSup->price         = $request->price[$key];
                $sourSup->dt            = $request->dt[$key];
                $sourSup->save();
            }

            if ($atLeastOneInputFilled) {
                // Proses berhasil
            } else {

            }
            return view('transaction.sourcing-item.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    

    public function get_storage(Request $request)
    {
        if ($request->ajax()) {
            $so = SalesOrder::where('uuid', $request->inquiry)->first();
            $inquiry = Inquiry::where('id', $so->inquiry_id)->first();
            $visitSchedule = $inquiry->visit->uuid;
            $path = 'public/inquiry/' . $visitSchedule;
            $data = array();

            $directories = Storage::directories($path);
            foreach ($directories as $dir) {
                $data[] = array(
                    'type' => 'folder',
                    'name' => explode('/', $dir)[3],
                    'url' => Storage::url($dir),
                );
            }

            $files = Storage::files($path);
            foreach ($files as $item) {
                $data[] = array(
                    'type' => 'file',
                    'filename' => $item,
                    'name' => explode('/', $item)[3],
                    'size' => Storage::size($item),
                    'url' => url('file/show/inquiry/' . $visitSchedule . '/' . explode('/', $item)[3]),
                );
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        }
    }

    public function save_folder(Request $request)
    {
        if ($request->ajax()) {
            $so = SalesOrder::where('uuid', $request->inquiry)->first();
            $inquiry = Inquiry::where('id', $so->inquiry_id)->first();
            $visitSchedule = $inquiry->visit->uuid;
            $path = 'public/inquiry/' . $visitSchedule . '/' . $request->folderName;
            Storage::makeDirectory($path);
            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        }
    }

    public function delete_file_folder(Request $request)
    {
        if ($request->ajax()) {
            $so = SalesOrder::where('uuid', $request->inquiry)->first();
            $inquiry = Inquiry::where('id', $so->inquiry_id)->first();
            $visitSchedule = $inquiry->visit->uuid;
            $files = $request->file;
            foreach ($files as $file) {
                $path = storage_path('app/public/inquiry/' . $visitSchedule . '/' . $file);

                if (File::exists($path)) {
                    if (File::isDirectory($path)) {
                        File::deleteDirectory($path);
                    } else {
                        File::delete($path);
                    }
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        }
    }

    public function get_supplier(Request $request): JsonResponse
    {
        if($request->q) {
            $data = Supplier::where('company', 'LIKE', "%{$request->q}%")->limit(10)->get();

            return response()->json($data);
        }else {
            $data = Supplier::limit(10)->get();
            return response()->json($data);
        }
    }

    
}
