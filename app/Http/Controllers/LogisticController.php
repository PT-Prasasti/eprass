<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;

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
        $listStock = Stock::orderBy('created_at', 'ASC')->get();
        return view('logistic.dashboard', compact('listStock'));
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
                ->addColumn('uuid', function($tracking) {
                    return $tracking->uuid;
                })
                ->make(true);
            return $result;
        }
    }
}