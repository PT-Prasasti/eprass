<?php

namespace App\Http\Controllers;

use App\Constants;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PaymentRequestExim;
use App\Models\PaymentRequestItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\DataTables as DataTablesDataTables;

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

    public function index(Request $request)
    {
        $userRole = Auth::user()->roles[0]->name;

        if ($userRole === 'exim') {
            $query = PaymentRequestExim::query();
        } else {
            $statusToFilter = null;
            if ($userRole === 'hrd') {
                $statusToFilter = 'Waiting for HRD Approval';
            } elseif ($userRole === 'hod') {
                $statusToFilter = 'Waiting for HOD Approval';
            } elseif ($userRole === 'manager') {
                $statusToFilter = 'Waiting for Manager Approval';
            }

            $query = PaymentRequestExim::query()->where(function ($query) use ($statusToFilter) {
                if ($statusToFilter) {
                    $query->where('status', '=', $statusToFilter)->orWhere('status', '=', 'Approved')->orWhere('status', 'like', 'Rejected%');
                } else {
                    $query->where('status', '=', 'Approved');
                }
            });
        }

        if ($request->ajax()) {
            $result = DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('id', function ($q) {
                    return $q->id;
                })
                ->addColumn('subject', function ($q) {
                    return $q->subject;
                })
                ->addColumn('submission_date', function ($q) {
                    $date = Carbon::parse($q->submission_date)->format('d F Y');
                    return $date;
                })
                ->addColumn('status', function ($q) {
                    return $q->status;
                })
                ->make(true);
            return $result;
        }

        return view('payment-request.exim.index');
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
    
            // Check if the request has a file
            if ($request->hasFile('file')) {
                $tempPath = 'payment_request/' . $userId . '/' . $iteration;
    
                // Create the temp directory if it doesn't exist
                if (!Storage::disk('public')->exists($tempPath)) {
                    Storage::disk('public')->makeDirectory($tempPath);
                }
    
                // Store the file in the temp directory
                $fileResponse = $this->fileController->store_temp($request->file('file'), $tempPath);
    
                if ($fileResponse->getData()->status == 200) {
                    $data['file'] = $fileResponse->getData()->data;
                } else {
                    throw new \Exception('File upload failed');
                }
            }
    
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
            ->addColumn('file', function ($item) {
                return $item['file'];
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

    public function getUpdateItem(Request $request): JsonResponse
    {

        $data = PaymentRequestItem::where('uuid', $request->id)->first();

        return response()->json([
            'data' => $data,
            'message' => 'success',
            'status' => 200,
        ]);
    }

    public function updateProduct2(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $data = PaymentRequestItem::find($request->id);
            $amount = floatval(str_replace('.', '', $request->amount));
            $data->update([
                'date' => $request->date,
                'item' => $request->item,
                'description' => $request->description,
                'amount' => $amount,
                'remark' => $request->remark
            ]);

            return response()->json([
                'message' => 'success',
            ], 200);
        }
    }

    public function deleteData(Request $request)
    {
        $key = $request->input('redis_key');
    
        $redis = Redis::get($key);
    
        if ($redis) {
            $itemData = json_decode($redis, true);
    
            if (isset($itemData['file'])) {
                $parts = explode('_', $key);
                $iteration = end($parts);
    
                $tempPath = 'temp/payment_request/' . auth()->user()->uuid . '/' . $iteration . '/' . $itemData['file']['filename'];
    
                if (Storage::disk('local')->exists($tempPath)) {
                    Storage::disk('local')->delete($tempPath);
                }
            }
    
            Redis::del($key);
        }
    
        return response()->json([
            "message" => "Successfully deleted item",
            "status" => 200,
        ]);
    }

    public function view($uuid)
    {
        $query = PaymentRequestExim::where('uuid', $uuid)->with('payment_request_item')->first();

        return view('payment-request.exim.edit', compact('query'));
    }

    public function update(Request $request, $uuid)
    {
        try {
            $paymentReq = PaymentRequestExim::where('uuid', $uuid)->first();

            DB::beginTransaction();

            $rejectedNote = null;
            $statusToUpdate = null; // Initialize both variables

            if ($request->rejected_note != null) {
                $rejectedNote = $request->rejected_note;

                $userRole = Auth::user()->roles[0]->name; // Get current user role

                // Set dynamic rejected status based on user role
                if ($userRole == 'hrd') {
                    $statusToUpdate = 'Rejected by HRD';
                } elseif ($userRole == 'hod') {
                    $statusToUpdate = 'Rejected by HOD';
                } elseif ($userRole == 'manager') {
                    $statusToUpdate = 'Rejected by Manager';
                }
            } else {
                if (Auth::user()->roles[0]->name == 'hrd') {
                    $statusToUpdate = 'Waiting for HOD Approval';
                } elseif (Auth::user()->roles[0]->name == 'hod') {
                    $statusToUpdate = 'Waiting for Manager Approval';
                } elseif (Auth::user()->roles[0]->name == 'manager') {
                    $statusToUpdate = 'Approved';
                }
            }

            $paymentReq->update([
                'subject' => $request->subject,
                'submission_date' => $request->submission_date,
                'name' => $request->name,
                'position' => $request->position,
                'bank_name' => $request->bank_name,
                'bank_swift' => $request->bank_swift,
                'bank_account' => $request->bank_account,
                'bank_number' => $request->bank_number,
                'status' => $statusToUpdate,
                'rejected_note' => $rejectedNote,
            ]);

            DB::commit();

            return redirect()->route('payment-request.exim')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }



    public function delete($uuid): RedirectResponse
    {
        try {
            $paymentReq = PaymentRequestExim::where('uuid', $uuid)->first();

            DB::beginTransaction();

            $paymentRequestItems = PaymentRequestItem::where('payment_request_id', $paymentReq->id)->get();

            foreach ($paymentRequestItems as $paymentRequestItem) {
                if ($paymentRequestItem->file_document && Storage::disk('public')->exists($paymentRequestItem->file_document)) {
                    // Delete the file from the public directory
                    Storage::disk('public')->delete($paymentRequestItem->file_document);
                }

                $paymentRequestItem->delete();
            }

            $paymentReq->delete();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
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

            if ($request->subject != 'REIMBURSE') {
                $paymentRequest->status = 'Waiting for HOD Approval';
            } else {
                $paymentRequest->status = 'Waiting for HRD Approval';
            }

            $paymentRequest->save();

            $keyPrefix = 'eprass_database_';
            $key = 'payment_request_item_' . $paymentReqId . '_' . $userId . '_*';
            $redisKeys = Redis::keys($key);
            $iteration = 1;

            foreach ($redisKeys as $redisKey) {
                $redisKey = str_replace($keyPrefix, '', $redisKey);
                $jsonData = Redis::get($redisKey);
                if ($jsonData) {
                    $itemData = json_decode($jsonData, true);
    
                    $paymentRequestItem = new PaymentRequestItem();
                    $paymentRequestItem->payment_request_id = $paymentRequest->id;
                    $paymentRequestItem->date = $itemData['date'];
                    $paymentRequestItem->item = $itemData['item'];
                    $paymentRequestItem->description = $itemData['description'];
                    $paymentRequestItem->amount = $itemData['amount'];
                    $paymentRequestItem->remark = $itemData['remark'];
    
                    if (isset($itemData['file'])) {
                        // Get the file from the temp directory
                        $tempPath = 'temp/payment_request/' . $userId . '/' . $iteration . '/' . $itemData['file']['filename'];
                    
                        // Check if the file exists in the temp directory
                        if (Storage::disk('local')->exists($tempPath)) {
                            // Define the new directory
                            $newPath = 'payment_request/' . $paymentRequest->uuid . '/' . $iteration . '/' . $itemData['file']['filename'];
                    
                            // Create the new directory if it doesn't exist
                            if (!Storage::disk('public')->exists(dirname($newPath))) {
                                Storage::disk('public')->makeDirectory(dirname($newPath));
                            }

                            $file = Storage::disk('local')->get($tempPath);

                            Storage::disk('public')->put($newPath, $file);
                            Storage::disk('local')->delete($tempPath);
                    
                            $paymentRequestItem->file_document = $newPath;
                            $paymentRequestItem->file_aliases = $itemData['file']['aliases'];
                        } else {
                            throw new \Exception('File not found: ' . $tempPath);
                        }
                    }
    
                    $paymentRequestItem->save();
    
                    Redis::del($redisKey);
                }

                $iteration++;
            }

            DB::commit();

            return redirect()->route('payment-request.exim')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            DB::rollback();
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