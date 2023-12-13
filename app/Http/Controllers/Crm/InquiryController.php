<?php

namespace App\Http\Controllers\Crm;

use App\Constants;
use App\Events\InquiryExcelExport;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Sales;
use App\Models\Inquiry;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewInquiryNotification;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Http\Requests\Crm\Inquiry\AddInquiryRequest;
use App\Http\Requests\Crm\Inquiry\EditInquiryRequest;
use App\Mail\InquiryMail;
use App\Models\InquiryProduct;

use Mail;

class InquiryController extends Controller
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
        $keys = Redis::keys('*');
        foreach ($keys as $item) {
            $key = 'inquiry_pdf_';
            if (str_contains($item, $key)) {
                if (str_contains($item, auth()->user()->uuid)) {
                    $item = explode($key, $item);
                    $redis = $key . $item[1];
                    Redis::del($redis);
                }
            }
            $key = 'inquiry_product_';
            if (str_contains($item, $key)) {
                if (str_contains($item, auth()->user()->uuid)) {
                    $item = explode($key, $item);
                    $redis = $key . $item[1];
                    Redis::del($redis);
                }
            }
        }
        return view('crm.inquiry.index');
    }

    public function data(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin_sales')) {
                $data = Inquiry::orderBy('created_at', 'DESC')->get();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = Inquiry::where('sales_id', $sales->id)
                    ->orderBy('created_at', 'DESC')->get();
            }

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_visit', function ($q) {
                    return $q->visit->id;
                })
                ->addColumn('id_inquiry', function ($q) {
                    return $q->id;
                })
                ->addColumn('customer', function ($q) {
                    return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
                })
                ->addColumn('date', function ($q) {
                    $date = Carbon::parse($q->created_at)->format('d M Y');
                    $due_date = Carbon::parse($q->due_date)->format('d M Y');
                    return $date . ' - ' . $due_date;
                })
                ->editColumn('status', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->status;
                    }
                    return $so;
                })
                ->addColumn('sales', function ($q) {
                    $sales = null;
                    if (isset($q->sales)) {
                        $sales = strtoupper($q->sales->name);
                    }
                    return $sales;
                })
                ->addColumn('so_number', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->id;
                    }
                    return $so;
                })
                ->addColumn('warning', function ($q) {
                    $now = Carbon::now();
                    $date = Carbon::parse($q->due_date);
                    $daysDifference = $date->diffInDays($now);
                    if ($daysDifference <= 2) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->make(true);

            return $result;
        }
    }

    public function data_grade(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin_sales')) {
                $data = Inquiry::whereBetween('grade', [$request->value1, $request->value2])
                    ->orderBy('created_at', 'DESC')
                    ->get();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = Inquiry::where('sales_id', $sales->id)
                    ->whereBetween('grade', [$request->value1, $request->value2])
                    ->orderBy('created_at', 'DESC')->get();
            }

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_visit', function ($q) {
                    return $q->visit->id;
                })
                ->addColumn('id_inquiry', function ($q) {
                    return $q->id;
                })
                ->addColumn('customer', function ($q) {
                    return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
                })
                ->addColumn('date', function ($q) {
                    $date = Carbon::parse($q->created_at)->format('d M Y');
                    $due_date = Carbon::parse($q->due_date)->format('d M Y');
                    return $date . ' - ' . $due_date;
                })
                ->editColumn('status', function ($q) {
                    return strtoupper($q->status);
                })
                ->addColumn('sales', function ($q) {
                    $sales = null;
                    if (isset($q->sales)) {
                        $sales = strtoupper($q->sales->name);
                    }
                    return $sales;
                })
                ->addColumn('so_number', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->id;
                    }
                    return $so;
                })
                ->addColumn('warning', function ($q) {
                    $now = Carbon::now();
                    $date = Carbon::parse($q->due_date);
                    $daysDifference = $date->diffInDays($now);
                    if ($daysDifference <= 2) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->make(true);

            return $result;
        }
    }

    public function data_status(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin_sales')) {
                $data = Inquiry::where('status', $request->value)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = Inquiry::where('sales_id', $sales->id)
                    ->where('status', $request->value)
                    ->orderBy('created_at', 'DESC')->get();
            }

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_visit', function ($q) {
                    return $q->visit->id;
                })
                ->addColumn('id_inquiry', function ($q) {
                    return $q->id;
                })
                ->addColumn('customer', function ($q) {
                    return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
                })
                ->addColumn('date', function ($q) {
                    $date = Carbon::parse($q->created_at)->format('d M Y');
                    $due_date = Carbon::parse($q->due_date)->format('d M Y');
                    return $date . ' - ' . $due_date;
                })
                ->editColumn('status', function ($q) {
                    return strtoupper($q->status);
                })
                ->addColumn('sales', function ($q) {
                    $sales = null;
                    if (isset($q->sales)) {
                        $sales = strtoupper($q->sales->name);
                    }
                    return $sales;
                })
                ->addColumn('so_number', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->id;
                    }
                    return $so;
                })
                ->addColumn('warning', function ($q) {
                    $now = Carbon::now();
                    $date = Carbon::parse($q->due_date);
                    $daysDifference = $date->diffInDays($now);
                    if ($daysDifference <= 2) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->make(true);

            return $result;
        }
    }

    public function data_customer(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin_sales')) {
                $data = Inquiry::whereHas('visit.customer', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->value . '%');
                })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = Inquiry::where('sales_id', $sales->id)
                    ->whereHas('visit.customer', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->value . '%');
                    })
                    ->orderBy('created_at', 'DESC')->get();
            }

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_visit', function ($q) {
                    return $q->visit->id;
                })
                ->addColumn('id_inquiry', function ($q) {
                    return $q->id;
                })
                ->addColumn('customer', function ($q) {
                    return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
                })
                ->addColumn('date', function ($q) {
                    $date = Carbon::parse($q->created_at)->format('d M Y');
                    $due_date = Carbon::parse($q->due_date)->format('d M Y');
                    return $date . ' - ' . $due_date;
                })
                ->editColumn('status', function ($q) {
                    return strtoupper($q->status);
                })
                ->addColumn('sales', function ($q) {
                    $sales = null;
                    if (isset($q->sales)) {
                        $sales = strtoupper($q->sales->name);
                    }
                    return $sales;
                })
                ->addColumn('so_number', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->id;
                    }
                    return $so;
                })
                ->addColumn('warning', function ($q) {
                    $now = Carbon::now();
                    $date = Carbon::parse($q->due_date);
                    $daysDifference = $date->diffInDays($now);
                    if ($daysDifference <= 2) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->make(true);

            return $result;
        }
    }

    public function data_sales(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin_sales')) {
                $data = Inquiry::whereHas('sales', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->value . '%');
                })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }

            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_visit', function ($q) {
                    return $q->visit->id;
                })
                ->addColumn('id_inquiry', function ($q) {
                    return $q->id;
                })
                ->addColumn('customer', function ($q) {
                    return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
                })
                ->addColumn('date', function ($q) {
                    $date = Carbon::parse($q->created_at)->format('d M Y');
                    $due_date = Carbon::parse($q->due_date)->format('d M Y');
                    return $date . ' - ' . $due_date;
                })
                ->editColumn('status', function ($q) {
                    return strtoupper($q->status);
                })
                ->addColumn('sales', function ($q) {
                    $sales = null;
                    if (isset($q->sales)) {
                        $sales = strtoupper($q->sales->name);
                    }
                    return $sales;
                })
                ->addColumn('so_number', function ($q) {
                    $so = null;
                    if (isset($q->sales_order)) {
                        $so = $q->sales_order->id;
                    }
                    return $so;
                })
                ->addColumn('warning', function ($q) {
                    $now = Carbon::now();
                    $date = Carbon::parse($q->due_date);
                    $daysDifference = $date->diffInDays($now);
                    if ($daysDifference <= 2) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->make(true);

            return $result;
        }
    }

    public function add(): View
    {
        return view('crm.inquiry.add');
    }

    public function download_template()
    {
        $data = array();

        return Excel::download(new InquiryExcelExport($data), 'products_list.xlsx');
    }

    public function generate_id(): JsonResponse
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $code = 'IQ';
        $month = (int) date('m');
        $year = date('y');

        $last_data = Inquiry::orderBy('created_at', 'DESC')->withTrashed()->first();

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

    public function visit(): JsonResponse
    {
        if (auth()->user()->hasRole('superadmin')) {
            $visit = VisitSchedule::whereNotIn('id', Inquiry::select('visit_schedule_id')->get())
                ->get();
        } else {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereNotIn('id', Inquiry::select('visit_schedule_id')->get())
                ->get();
        }

        $result = array();

        foreach ($visit as $item) {
            $result[] = array(
                'id' => $item->id,
                'uuid' => $item->uuid,
            );
        }

        return response()->json($result);
    }

    public function visit_detail($id): JsonResponse
    {
        $visit = VisitSchedule::where('uuid', $id)->first();

        $result = array(
            'company' => $visit->customer->company,
            'customer' => $visit->customer->name,
            'telp' => $visit->customer->company_phone,
            'phone' => $visit->customer->phone,
            'email' => $visit->customer->email,
        );

        return response()->json($result);
    }

    public function get_pdf(Request $request): JsonResponse
    {
        $so = $request->so;
        $so = str_replace('/', '_', $so);
        $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;
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
                $so = $request->so;
                $so = str_replace('/', '_', $so);
                $file = $request->file('file');
                $path = $so;
                $upload = $this->fileController->store_temp($file, $path);
                if ($upload->original['status'] == 200) {
                    $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;
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

    public function delete_pdf(Request $request): JsonResponse
    {
        try {
            $so = $request->so;
            $so = str_replace('/', '_', $so);
            $file = $request->file;
            if ($request->has('edit')) {
                $path = 'public/inquiry/' . $so . '/' . $file;
            } else {
                $path = 'temp/' . $so . '/' . $file;
            }
            $exist = Storage::exists($path);
            if ($exist) {
                $delete = Storage::delete($path);

                if ($delete) {
                    $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;
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

    public function get_product(Request $request): JsonResponse
    {
        $so = $request->so;
        $so = str_replace('/', '_', $so);
        $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
        $data = json_decode(Redis::get($key), true);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function upload_excel(Request $request): JsonResponse
    {
        try {
            if ($request->hasFile('file')) {
                $so = $request->so;
                $file = $request->file('file');

                $excel = Excel::toArray(null, $file, null, null, null, true, false, false)[0];
                $excel = array_slice($excel, 1);
                $data = array();

                foreach ($excel as $item) {
                    $data[] = array_slice($item, 1);
                }

                $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
                $redis = Redis::get($key);

                if ($redis) {
                    $array = json_decode($redis, true);
                    $new = array();

                    foreach ($data as $item) {
                        $found = false;

                        foreach ($array as &$row) {
                            if ($item[0] == $row[0] && $item[2] == $row[2]) {
                                $row[3] += $item[3];
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $new[] = array($item[0], $item[1], $item[2], $item[3], $item[4]);
                        }
                    }

                    $array = array_merge($array, $new);

                    Redis::set($key, json_encode($array));
                } else {
                    Redis::set($key, json_encode($data));
                }

                $data = Redis::get($key);
                $data = json_decode($data, true);

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

    public function store_product(Request $request)
    {
        try {
            $so = $request->so;
            $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
            $redis = Redis::get($key);
            $data = $request->data;

            if ($redis) {
                $redis = Redis::del($key);
            }

            Redis::set($key, json_encode($data));

            $data = Redis::get($key);
            $data = json_decode($data, true);

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'error'
            ]);
        }
    }

    public function store(AddInquiryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $inquiry = new Inquiry();
            $inquiry->id = $request->id;
            $inquiry->visit_schedule_id = VisitSchedule::where('uuid', $request->visit)->first()->id;
            $inquiry->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
            $inquiry->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $inquiry->subject = $request->subject;
            $inquiry->grade = $request->grade;
            $inquiry->description = $request->description;
            $inquiry->files = ($request->pdf == 'null') ? '' : $request->pdf;
            $inquiry->save();

            $so = $request->visit;

            if ($request->pdf != 'null') {
                $files = json_decode($request->pdf, true);
                foreach ($files as $item) {
                    $sourcePath = storage_path('app/temp/' . $so . '/' . $item['filename']);
                    $destinationPath = storage_path('app/public/inquiry/' . $so . '/' . $item['filename']);

                    if (!Storage::exists('public/inquiry/' . $so)) {
                        Storage::makeDirectory('public/inquiry/' . $so);
                    }

                    if (file_exists($sourcePath)) {
                        rename($sourcePath, $destinationPath);
                    }
                }

                Storage::deleteDirectory('temp/' . $so);
            }

            $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
            $redis = Redis::get($key);

            $products = [];
            if ($redis) {
                $data = json_decode($redis, true);

                foreach ($data as $item) {
                    $product = new InquiryProduct();
                    $product->inquiry_id = $inquiry->id;
                    $product->item_name = $item[0];
                    $product->description = $item[1];
                    $product->size = $item[2];
                    $product->qty = $item[3];
                    $product->remark = $item[4];
                    $product->save();
                    array_push($products, $product);
                }

                $redis = Redis::del($key);
            }

            
            $usersToNotify = User::role('admin_sales')->get();
            Notification::send($usersToNotify, new NewInquiryNotification($inquiry));
            $dataInquiry = [
                'id'                => $inquiry->id,
                'id_visit'          => $inquiry->visit_schedule_id,
                'due_date'          => $inquiry->due_date,
                'subject'           => $inquiry->subject,
                'grade'             => $inquiry->grade,
                'description'       => $inquiry->description,
                'products'          => $products
            ];
            $email = new InquiryMail(collect($dataInquiry));
            $sendmail = 'sales@pt-prasasti.com';
            $sendmail1 = 'dhita@pt-prasasti.com';
            Mail::to($sendmail)->send($email);
            Mail::to($sendmail1)->send($email);

            DB::commit();

            $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;

            Redis::del($key);

            return redirect()->route('crm.inquiry')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function view($id): View
    {
        $inquiry = Inquiry::where('uuid', $id)->first();
        return view('crm.inquiry.view', compact('inquiry'));
    }

    public function edit($id): View
    {
        $inquiry = Inquiry::where('uuid', $id)->first();
        $so = $inquiry->visit->uuid;

        $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;
        Redis::del($key);
        Redis::set($key, $inquiry->files);

        $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
        Redis::del($key);
        if (isset($inquiry->products)) {
            $data = array();

            foreach ($inquiry->products as $item) {
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

        return view('crm.inquiry.edit', compact('inquiry'));
    }

    public function store_edit(EditInquiryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $inquiry = Inquiry::where('uuid', $request->uuid)->first();
            $inquiry->visit_schedule_id = VisitSchedule::where('uuid', $request->visit)->first()->id;
            $inquiry->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
            $inquiry->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $inquiry->subject = $request->subject;
            $inquiry->grade = $request->grade;
            $inquiry->description = $request->description;
            $inquiry->files = $request->pdf;
            $inquiry->save();

            $so = str_replace('/', '_', $request->visit);

            if (!empty($request->pdf)) {
                $files = json_decode($request->pdf, true);
                foreach ($files as $item) {
                    $sourcePath = storage_path('app/temp/' . $so . '/' . $item['filename']);
                    $destinationPath = storage_path('app/public/inquiry/' . $so . '/' . $item['filename']);

                    if (!Storage::exists('public/inquiry/' . $so)) {
                        Storage::makeDirectory('public/inquiry/' . $so);
                    }

                    if (file_exists($sourcePath)) {
                        rename($sourcePath, $destinationPath);
                    }
                }

                Storage::deleteDirectory('temp/' . $so);
            }

            $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
            $redis = Redis::get($key);

            if ($redis) {
                $data = json_decode($redis, true);

                foreach ($data as $key => $value) {
                    if (isset($inquiry->products[$key])) {
                        $product_id = $inquiry->products[$key]->id;
                        $product = InquiryProduct::find($product_id);
                        $product->item_name = $value[0];
                        $product->description = $value[1];
                        $product->size = $value[2];
                        $product->qty = $value[3];
                        $product->remark = $value[4];
                        $product->save();
                    } else {
                        $product = new InquiryProduct();
                        $product->inquiry_id = $inquiry->id;
                        $product->item_name = $item[0];
                        $product->description = $item[1];
                        $product->size = $item[2];
                        $product->qty = $item[3];
                        $product->remark = $item[4];
                        $product->save();
                    }
                }
            }

            $key = 'inquiry_product_' . $so . '_' . auth()->user()->uuid;
            Redis::del($key);

            DB::commit();

            $key = 'inquiry_pdf_' . $so . '_' . auth()->user()->uuid;

            Redis::del($key);

            return redirect()->route('crm.inquiry')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete_product(Request $request)
    {
        try {
            InquiryProduct::where('inquiry_id', $request->so)
                ->where('item_name', $request->item_name)
                ->where('description', $request->description)
                ->where('size', $request->size)
                ->where('qty', $request->qty)
                ->where('remark', $request->remark)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => $e
            ]);
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            $visit = Inquiry::where('uuid', $id)->first();

            DB::beginTransaction();

            $visit->delete();

            DB::commit();

            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
