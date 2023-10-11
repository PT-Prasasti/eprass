<?php

namespace App\Http\Controllers\Transaction;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class SourcingItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() : View
    {
        return view('transaction.sourcing-item.index');
    }
    
    public function add() : View
    {
        $data['suppliyers'] = \App\Models\Supplier::get();
        return view('transaction.sourcing-item.add', $data);
    }

    public function store(Request $re)
    {
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
                    'product_price' => $re->product_price[$v][$k],
                    'production_time' => $re->production_time[$v][$k],
                    'remark' => $re->remark[$v][$k],
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
            foreach($par as $product_inquery_id => $items) {
                foreach($items as $item) {
                    $sourching_suppliyer = new \App\Models\SourcingSuppliers;
                    $sourching_suppliyer->sourcing_id = $sourching->id;
                    $sourching_suppliyer->company = $item['supliyer']->company;
                    $sourching_suppliyer->item_name = $item['inquery_products']->item_name;;
                    $sourching_suppliyer->description = $item['product_desc'];
                    $sourching_suppliyer->qty = $item['product_qty'];
                    $sourching_suppliyer->price = $item['product_price'];
                    $sourching_suppliyer->dt = $item['production_time'];
                    $sourching_suppliyer->currency = $item['product_curentcy'];
                    $sourching_suppliyer->save();

                    $sourching_item = new \App\Models\SourchingItems;
                    $sourching_item->inquiry_product_id = $item['inquery_products']->id;
                    $sourching_item->sourcing_supplier_id = $sourching_suppliyer->id;
                    $sourching_item->save();
                }
            }

            
            DB::commit();

            return redirect(route('transaction.sourcing-item.add'))->with("success", "Data has beed successfuly submited");

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect(route('transaction.sourcing-item.add'))->with("error", "Database Error, please contact administrator!");
        }
    }
        
    public function sales_order() : JsonResponse
    {
        $inquiries = SalesOrder::whereRaw("
            id NOT IN (SELECT so_id FROM `sourcings`)
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
    
    public function so_detail($id) : JsonResponse
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
        if($redis) {
            Redis::del($key);
        }
        Redis::set($key, $so->inquiry->files);

        $key = 'so_product_' . $id . '_' . auth()->user()->uuid;
        $redis = Redis::get($key);
        if($redis) {
            Redis::del($key);
        }
        if(isset($so->inquiry->products)) {
            $data = array();
            
            foreach($so->inquiry->products as $item) {
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

        return response()->json($result);  
    }
    
    public function get_pdf(Request $request) : JsonResponse
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
    
    public function get_product(Request $request) : JsonResponse
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
            'uuid' =>$uuid
        ]);
    }
}
