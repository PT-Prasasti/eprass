<?php

namespace App\Http\Controllers;

use App\Constants;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PaymentRequestExim;
use App\Models\PaymentRequestItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentRequestEximController extends Controller
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
    }

    public function add(): View
    {
        $transactionCode = $this->handle_generate_transaction_code(date('Y-m-d'));

        return view('payment-request.exim.add', [
            'transactionCode' => $transactionCode,
        ]);
    }

    public function store_product(Request $request): JsonResponse
    {
        try {
            $paymentReqId = $request->payment_code;
            $userId = auth()->user()->uuid;

            // Cari nomor iterasi terakhir dari key yang sesuai dengan $paymentReqId
            $iteration = 1;
            $key = 'payment_request_item_' . $paymentReqId . '_' . $userId . '_' . $iteration;
            while (Redis::get($key)) {
                $iteration++;
                $key = 'payment_request_item_' . $paymentReqId . '_' . $userId . '_' . $iteration;
            }

            $data = $request->data;

            if ($data != null) {
                // Simpan data ke Redis dengan key yang baru
                $newKey = 'payment_request_item_' . $paymentReqId . '_' . $userId . '_' . $iteration;
                Redis::set($newKey, json_encode($data));

                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'error'
            ]);
        }
    }

    public function getProductList(Request $request): JsonResponse
    {
        $paymentCode = $request->paymentCode;

        $keys = Redis::keys("payment_request_item_" . $paymentCode . "_*");
        $data = [];

        foreach ($keys as $key) {
            $redisKey = str_replace("eprass_database_", "", $key);
            $jsonData = Redis::get($redisKey);
            $item = json_decode($jsonData, true);

            $item['redis_key'] = $redisKey;

            $data[] = $item;
        }

        $result = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function ($item) {
                return date('d/m/Y', strtotime($item['date']));
            })
            ->addColumn('item', function ($item) {
                return $item['item'];
            })
            ->addColumn('description', function ($item) {
                return $item['description'];
            })
            ->addColumn('amount', function ($item) {
                return 'Rp ' . number_format($item['amount'], 0, ',', '.');
            })
            ->addColumn('remark', function ($item) {
                return $item['remark'];
            })
            ->make(true);

        return $result;
    }

    public function getEditData(Request $request)
    {
        $key = $request->redis_key;

        $redis = Redis::get($key);

        $data = json_decode($redis, true);

        return response()->json([
            'data' => $data,
            'status' => 200,
            'key' => $key
        ]);
    }

    public function updateProduct(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $key = $request->redis_key;
            $data = $request->data;

            $jsonData = Redis::get($key);
            $redis = json_decode($jsonData, true);

            if ($redis) {
                Redis::del($key);

                Redis::set($key, json_encode($data));
            }

            return response()->json([
                'message' => 'Data updated successfully',
                'status' => 200,
            ]);
        }
    }

    public function deleteData(Request $request)
    {
        $key = $request->input('redis_key');

        $redis = Redis::get($key);

        if ($redis) {
            $redis = Redis::del($key);
        }

        return response()->json([
            "message" => "Successfully deleted item",
            "status" => 200,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        try {
            $paymentReqId = $request->payment_code;
            $userId = auth()->user()->uuid;
            DB::beginTransaction();

            $paymentRequest = new PaymentRequestExim();
            $paymentRequest->id = $paymentReqId;
            $paymentRequest->subject = $request->subject;
            $paymentRequest->submission_date = date('Y-m-d');
            $paymentRequest->name = $request->name;
            $paymentRequest->position = $request->position;
            $paymentRequest->bank_name = $request->bank_name;
            $paymentRequest->bank_swift = $request->bank_swift;
            $paymentRequest->bank_account = $request->bank_account;
            $paymentRequest->bank_number = $request->bank_number;
            $paymentRequest->status = 'Waiting for Approval';
            $paymentRequest->save();

            $keyPrefix = 'eprass_database_';
            $key = 'payment_request_item_' . $paymentReqId . '_' . $userId . '_*';
            $redisKeys = Redis::keys($key);

            foreach ($redisKeys as $redisKey) {
                $redisKey = str_replace($keyPrefix, '', $redisKey);
                $jsonData = Redis::get($redisKey);
                if($jsonData) {
                    $itemData = json_decode($jsonData, true);
                    
                    $paymentRequestItem = new PaymentRequestItem();
                    $paymentRequestItem->payment_request_id = $paymentRequest->id;
                    $paymentRequestItem->date = $itemData['date'];
                    $paymentRequestItem->item = $itemData['item'];
                    $paymentRequestItem->description = $itemData['description'];
                    $paymentRequestItem->amount = $itemData['amount'];
                    $paymentRequestItem->remark = $itemData['remark'];
                    $paymentRequestItem->save();

                    Redis::del($redisKey);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function generate_id(): JsonResponse
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $code = 'PR';
        $month = (int) date('m');
        $year = date('y');

        $last_data = PaymentRequestExim::orderBy('created_at', 'DESC')->withTrashed()->first();

        if ($last_data) {
            $last_id = $last_data->id;
            $id = explode("/", $last_id);
            $number = (int) $id[0];
            $number++;
        } else {
            $number = 1;
        }

        $generate_id = sprintf("%04s", $number) . "/" . $code . "/" . $romans[$month - 1] . "/" . $year;

        return response()->json($generate_id);
    }

    public function handle_generate_transaction_code($date): string
    {
        $prefix = 'PR';
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = (int) date('m', strtotime($date));
        $year = date('y', strtotime($date));
        $query = PaymentRequestExim::query()->orderBy('id', 'DESC')->first();
        if ($query) {
            $paymentCodes = explode('/',  $query->id);
            $number = ((int) $paymentCodes[0]) + 1;
        } else {
            $number = 1;
        }

        return sprintf("%04s", $number) . "/" . $prefix . "/" . $romans[$month - 1] . "/" . $year;
    }
}
