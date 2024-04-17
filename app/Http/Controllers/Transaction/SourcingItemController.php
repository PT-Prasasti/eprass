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
use App\Models\Documentes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use Illuminate\Support\Facades\DB;

class SourcingItemController extends Controller
{

    protected $fileController, $redisController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->fileController = new FilesController();
        $this->redisController = new RedisController();
    }

    public function index(): View
    {
        return view('transaction.sourcing-item.index');
    }

    public function add(): View
    {
        $data['suppliyers'] = \App\Models\Supplier::get();
        return view('transaction.sourcing-item.add', $data);
    }

    public function selected($id): View
    {
        $data = [];
        $res = [];
        $salesorder = \App\Models\SalesOrder::where("uuid", $id)->first();
        if (!empty($salesorder)) {
            $sourching = \App\Models\Sourcing::where("so_id", $salesorder->id)->with("selected_sourcing_suppliers.sourcing_supplier.inquery_product")->first();
            foreach ($sourching->selected_sourcing_suppliers as $selected) {
                if (!empty($selected->sourcing_supplier)) {
                    $sourching_supliyer = $selected->sourcing_supplier;
                    $inquery_product = $selected->sourcing_supplier->inquery_product;
                    if (!empty($sourching_supliyer) && !empty($inquery_product)) {
                        $res[] = [
                            'inquery_item_name' => $inquery_product->item_name,
                            'inquery_material_description' => $inquery_product->description,
                            'inquery_size' => $inquery_product->size,
                            'inquery_remark' => $inquery_product->remark,
                            'inquery_qty' => $inquery_product->qty,
                            'suppliyer_name' => $sourching_supliyer->company,
                            'suppliyer_item_desc' => $sourching_supliyer->item_name,
                            'suppliyer_qty' => $sourching_supliyer->qty,
                            'suppliyer_currency' => strtoupper($sourching_supliyer->currency),
                            'suppliyer_qty' => $sourching_supliyer->qty,
                            'suppliyer_unit_price' => $sourching_supliyer->price,
                            'suppliyer_production_time' => $sourching_supliyer->dt,
                        ];
                    }
                }
            }
        }
        $data['res'] = $res;
        return view('transaction.sourcing-item.selected', $data);
    }

    public function store(Request $re)
    {

        ini_set('max_input_vars', 2000);
        ini_set('max_multipart_body_parts', 2000);

        /* grouping param by product inquery id */

        $inquery_id = $re->so_id[0];
        $par = [];
        foreach ($re->product_inquery_id as $v) {
            /* regroup by supiyer */
            foreach ($re->supplier_id[$v] as $k => $r) {
                $par[$v][$k] = [
                    'so_id' => $inquery_id,
                    'supliyer_id' => $re->supplier_id[$v][$k],
                    'supliyer' => \App\Models\Supplier::find($re->supplier_id[$v][$k]),
                    'inquery_products' => \App\Models\InquiryProduct::find($v),
                    'product_desc' => $re->product_desc[$v][$k],
                    'product_qty' => $re->product_qty[$v][$k],
                    'product_curentcy' => $re->product_curentcy[$v][$k],
                    'product_price' => str_replace(".", "", $re->product_price[$v][$k] ?? ""),
                    'production_time' => $re->production_time[$v][$k] ?? null,
                    'remark' => $re->remark[$v][$k] ?? null,
                ];
            }
        }

        try {
            DB::beginTransaction();
            /* create and replace */
            $sourching = new \App\Models\Sourcings;
            $sourching->so_id = $inquery_id;
            $sourching->save();

            /* sourching supliyer */
            foreach ($par as $product_inquery_id => $items) {
                foreach ($items as $item) {
                    $sourching_suppliyer = new \App\Models\SourcingSuppliers;
                    $sourching_suppliyer->sourcing_id = $sourching->id;
                    $sourching_suppliyer->supplier_id = $item['supliyer']->id;
                    $sourching_suppliyer->inquiry_product_id = $item['inquery_products']->id;
                    $sourching_suppliyer->company = $item['supliyer']->company;
                    $sourching_suppliyer->item_name = $item['inquery_products']->item_name;;
                    $sourching_suppliyer->description = $item['product_desc'];
                    $sourching_suppliyer->qty = $item['product_qty'];
                    $sourching_suppliyer->price = $item['product_price'];
                    $sourching_suppliyer->dt = $item['production_time'];
                    $sourching_suppliyer->currency = $item['product_curentcy'];
                    $sourching_suppliyer->unitprice = $item['product_price'];
                    $sourching_suppliyer->save();

                    $sourching_item = new \App\Models\SourchingItems;
                    $sourching_item->inquiry_product_id = $item['inquery_products']->id;
                    $sourching_item->sourcing_supplier_id = $sourching_suppliyer->id;
                    $sourching_item->save();
                }
            }


            DB::commit();

            return redirect(route('transaction.sourcing-item'))->with("success", "Data has beed successfuly submited");
        } catch (\Exception $e) {
            DB::rollback();

            return redirect(route('transaction.sourcing-item.add'))->with("error", $e->getMessage());
        }
    }

    public function sales_order(): JsonResponse
    {
        $inquiries = SalesOrder::whereRaw("
            id NOT IN (SELECT so_id FROM `sourcings` WHERE deleted_at IS NULL)
        ")->get();

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
            'soid' => $so->id,
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
                    $item->id,
                    $so->id
                );
            }

            Redis::set($key, json_encode($data));
        }

        //documents
        $result['documents'] = Documentes::getDocuments("sales_orders", $so->id);

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
                        return $q->item_name;
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

    public function __store(Request $request)
    {
        try {
            $sourcing = new Sourcing();
            $sourcing->so_id = $request->so;
            $sourcing->save();

            $atLeastOneInputFilled = false;

            $counter = 1;
            foreach ($request->description as $key => $desc) {
                if (!empty($desc)) {
                    $atLeastOneInputFilled = true;
                }

                $supplier = Supplier::where('id', $counter)->first();
                if ($supplier) {
                    $sourSup = new SourcingSupplier();
                    $sourSup->sourcing_id = $sourcing->id;
                    $sourSup->supplier_id = $supplier->id;
                    $sourSup->company = $supplier->company;
                    $sourSup->item_name = '-';
                    $sourSup->description = $desc;
                    $sourSup->qty = $request->quantity[$key];
                    $sourSup->unitprice = $request->unitprice[$key];
                    $sourSup->price = $request->price[$key];
                    $sourSup->dt = $request->dt[$key];
                    $sourSup->save();
                }

                $counter++;
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
        if ($request->q) {
            $data = Supplier::where('company', 'LIKE', "%{$request->q}%")->limit(10)->get();

            return response()->json($data);
        } else {
            $data = Supplier::limit(10)->get();
            return response()->json($data);
        }
    }

    public function review_save_product(Request $request)
    {
        try {
            $so = SalesOrder::where('uuid', $request->so)->first();
            $product = InquiryProduct::where('uuid', $request->uuid)->first();
            $sourcing = Sourcing::where('so_id', $so->id)->where('deleted_at', null)->first();

            if (!$sourcing) {
                $sourcing = Sourcing::create([
                    'uuid' => Uuid::generate(4)->string,
                    'so_id' => $so->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $sourSupp = SourcingSupplier::where('sourcing_id', $sourcing->id)->where('company', Supplier::where('id', $request->supplier)->first()->company)->where('item_name', $product->item_name)->where('description', $request->description)->where('qty', $request->qty)->where('price', $request->price)->where('dt', $request->dt)->where('deleted_at', null)->first();

            if (!$sourSupp) {
                $sourSupp = SourcingSupplier::create([
                    'uuid' => Uuid::generate(4)->string,
                    'sourcing_id' => $sourcing->id,
                    'company' => Supplier::where('id', $request->supplier)->first()->company,
                    'item_name' => $product->item_name,
                    'description' => $request->description,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'dt' => $request->dt,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $sourcingItem = SourcingItem::where('inquiry_product_id', $product->id)->where('sourcing_supplier_id', $sourSupp->id)->where('deleted_at', null)->first();

            if (!$sourcingItem) {
                SourcingItem::create([
                    'uuid' => Uuid::generate(4)->string,
                    'inquiry_product_id' => $product->id,
                    'sourcing_supplier_id' => $sourSupp->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }


            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    public function upload_file(Request $request)
    {
        try {
            $so = SalesOrder::where('uuid', $request->input('so'))->first();
            $inquiry = Inquiry::where('id', $so->inquiry_id)->first();
            $visitSchedule = $inquiry->visit->uuid;
            $path = 'public/inquiry/' . $visitSchedule . '/' . $request->input('folder');
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->storeAs($path, $filename);

            $filesJson = $inquiry->files;

            $filesArray = json_decode($filesJson, true);

            $newFile = [
                'filename' => $request->input('folder') . '/' . $filename,
                'aliases' => $file->getClientOriginalName(),
            ];

            $filesArray[] = $newFile;

            $updatedFilesJson = json_encode($filesArray);

            $inquiry->files = $updatedFilesJson;
            $inquiry->save();

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
