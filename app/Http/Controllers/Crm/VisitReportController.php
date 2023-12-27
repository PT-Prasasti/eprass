<?php

namespace App\Http\Controllers\Crm;

use App\Constants;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Sales;
use Illuminate\View\View;
use App\Models\VisitReport;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewVisitReportNotification;
use App\Notifications\NewVisitScheduleNotification;
use App\Http\Controllers\Crm\VisitScheduleController;
use App\Http\Controllers\Helper\FilesController;
use App\Http\Controllers\Helper\RedisController;
use App\Http\Requests\Crm\VisitReport\AddVisitReportRequest;
use App\Http\Requests\Crm\VisitReport\EditVisitReportRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

use App\Mail\VisitMail;
use App\Mail\ReportMail;
use Mail;
use Auth;

class VisitReportController extends Controller
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
            $key = 'visit_report_pdf_';
            if (str_contains($item, $key)) {
                if (str_contains($item, auth()->user()->uuid)) {
                    $item = explode($key, $item);
                    $redis = $key . $item[1];
                    Redis::del($redis);
                }
            }
        }
        return view('crm.visit-report.index');
    }

    public function generate_id(): JsonResponse
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $code = 'IQ';
        $month = (int) date('m');
        $year = date('y');

        $last_data = VisitReport::orderBy('created_at', 'DESC')->withTrashed()->first();

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

    public function data(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('hod'))
                $data = VisitReport::all();
        } else {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $data = VisitReport::where('sales_id', $sales->id)
                ->get();
        }

        $result = DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('id', function ($q) {
                return $q->visit_schedule_id;
            })
            ->addColumn('customer', function ($q) {
                return strtoupper($q->visit->customer->name . ' - ' . $q->visit->customer->company);
            })
            ->addColumn('sales', function ($q) {
                return $q->sales->name;
            })
            ->editColumn('date', function ($q) {
                return Carbon::parse($q->visit->date)->format('d M Y');
            })
            ->make(true);

        return $result;
    }

    public function report($id = null): RedirectResponse
    {
        $visit = VisitSchedule::where('uuid', $id)->first();
        $report = VisitReport::where('visit_schedule_id', $visit->id)->first();
        if ($report) {
            return redirect()->route('crm.visit-report.edit', ['id' => $report->uuid]);
        } else {
            return redirect()->route('crm.visit-report.add', ['id' => $id]);
        }
    }

    public function add($id = null): View
    {
        if ($id) {
            $visit = VisitSchedule::where('uuid', $id)->first();

            $data = array(
                'id' => $visit->id,
                'uuid' => $visit->uuid,
                'visit_date' => Carbon::parse($visit->date)->format('d M Y'),
                'visit_time' => isset($visit->time) ? Carbon::parse($visit->time)->format('H:i') : '00:00',
                'customer' => strtoupper($visit->customer->name . ' - ' . $visit->customer->company),
                'phone' => $visit->customer->phone,
                'email' => $visit->sales->email,
            );

            return view('crm.visit-report.add', compact('data'));
        } else {
            return view('crm.visit-report.add');
        }
    }

    public function visit(): JsonResponse
    {
        if (auth()->user()->hasRole('superadmin')) {
            $visit = VisitSchedule::whereNotIn('id', VisitReport::select('visit_schedule_id')->get())
                ->get();
        } else {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereNotIn('id', VisitReport::select('visit_schedule_id')->get())
                ->get();
        }

        $result = array();

        foreach ($visit as $item) {
            $result[] = array(
                'id' => $item->id . ' / ' . $item->customer->company . ' - ' . $item->customer->name,
                'uuid' => $item->uuid,
            );
        }

        return response()->json($result);
    }

    public function visit_detail($id): JsonResponse
    {
        $visit = VisitSchedule::where('uuid', $id)->first();

        $result = array(
            'visit_date' => Carbon::parse($visit->date)->format('d M Y'),
            'visit_time' => isset($visit->time) ? Carbon::parse($visit->time)->format('H:i') : '00:00',
            'customer' => $visit->customer->name . ' - ' . $visit->customer->company,
            'phone' => $visit->customer->phone,
            'email' => $visit->customer->email,
        );

        return response()->json($result);
    }

    public function get_pdf(Request $request): JsonResponse
    {
        $so = $request->so;
        $so = str_replace('/', '_', $so);
        $key = 'visit_report_pdf_' . $so . '_' . auth()->user()->uuid;
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
                    $key = 'visit_report_pdf_' . $so . '_' . auth()->user()->uuid;
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
                    $key = 'visit_report_pdf_' . $so . '_' . auth()->user()->uuid;
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

    public function store(AddVisitReportRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $visitschedule = VisitSchedule::where('uuid', $request->visit)->first();

            $visitReport = new VisitReport();
            $visitReport->id = $request->id;
            $visitReport->visit_schedule_id = $visitschedule->id;
            $visitReport->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $visitReport->status = $request->status;
            $visitReport->note = $request->note;
            $visitReport->planing = $request->planing;
            // $visitReport->next_date_visit = $request->next_date_visit;
            // $visitReport->next_time_visit = $request->next_time_visit;
            $visitReport->files = ($request->pdf == 'null') ? '' : $request->pdf;
            $visitReport->save();

            $so = $request->visit;

            if ($request->pdf != 'null') {
                $files = json_decode($request->pdf, true);
                foreach ($files as $item) {
                    $sourcePath = storage_path('app/temp/' . $so . '/' . $item['filename']);
                    $destinationPath = storage_path('app/public/visit-report/' . $so . '/' . $item['filename']);

                    if (!Storage::exists('public/visit-report/' . $so)) {
                        Storage::makeDirectory('public/visit-report/' . $so);
                    }

                    if (file_exists($sourcePath)) {
                        rename($sourcePath, $destinationPath);
                    }
                }

                Storage::deleteDirectory('temp/' . $so);
            }

            $usersToNotify = User::role('manager')->get();
            Notification::send($usersToNotify, new NewVisitReportNotification($visitReport));

            $dataVisitReport = [
                'id' => $visitReport->visit_schedule_id,
                'date' => $visitReport->visit->date,
                'time' => $visitReport->visit->time,
                'customer_company' => $visitReport->visit->customer->name . " - " . $visitReport->visit->customer->company,
                'customer_phone'     => $visitReport->visit->customer->phone,
                'customer_email'     => $visitReport->visit->customer->email,
                'status'           => $visitReport->status,
                'note'      => $visitReport->note,
                'plan'      => $visitReport->planing,
                'sales'     => $visitReport->sales->name
            ];

            $email_report = new ReportMail(collect($dataVisitReport));
            $sendmail = 'eprass.d@pt-prasasti.com';
            $sendmail1 = 'dhita@pt-prasasti.com';
            Mail::to($sendmail)->send($email_report);
            Mail::to($sendmail1)->send($email_report);

            if (($request->next_date_visit != null) && ($request->next_time_visit != null)) {

                $generate_id = VisitScheduleController::generate_id_static();
                $visit = new VisitSchedule();
                $visit->id = $generate_id;
                $visit->customer_id = $visitReport->visit->customer_id;
                $visit->visit_by    = $visitschedule->visit_by;
                $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
                $visit->devision = $visitReport->visit->devision;
                $visit->date = $request->next_date_visit;
                $visit->time = $request->next_time_visit;
                $visit->enginer_email = json_encode($request->engineer);
                $visit->note = null;
                $visit->save();

                $usersToNotify = User::role('manager')->get();
                Notification::send($usersToNotify, new NewVisitScheduleNotification($visit));

                $dataVisit = [
                    'id'                => $visit->id,
                    'company'           => $visit->customer->company,
                    'company_phone'     => $visit->customer->company_phone,
                    'customer_name'     => $visit->customer->name,
                    'customer_phone'    => $visit->customer->phone,
                    'customer_email'    => $visit->customer->email,
                    'visit_by'          => $visit->visit_by,
                    'user_created'      => $visit->sales->name,
                    'schedule'          => $visitReport->planing
                ];

                $email = new VisitMail(collect($dataVisit));

                Mail::to($sendmail)->send($email);

                foreach ($request->engineer as $enginer) {
                    Mail::to($enginer)->send($email);
                }
            }

            DB::commit();

            return redirect()->route('crm.visit-report')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function view($id): View
    {
        $visit = VisitReport::where('uuid', $id)->first();

        return view('crm.visit-report.view', compact('visit'));
    }

    public function edit($id): View
    {
        $visit = VisitReport::where('uuid', $id)->first();

        return view('crm.visit-report.edit', compact('visit'));
    }

    public function store_edit(EditVisitReportRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $visitschedule = VisitSchedule::where('uuid', $request->visit)->first();

            $visitReport = VisitReport::where('uuid', $request->uuid)->first();
            $old_nextdate = $visitReport->next_date_visit;
            $old_nexttime = $visitReport->next_time_visit;
            $visitReport->visit_schedule_id = $visitschedule->id;
            $visitReport->status = $request->status;
            $visitReport->note = $request->note;
            $visitReport->planing = $request->planing;
            // $visitReport->next_date_visit = $request->next_date_visit;
            // $visitReport->next_time_visit = $request->next_time_visit;
            $visitReport->files = $request->pdf;
            $visitReport->save();

            $so = str_replace('/', '_', $request->visit);

            if (!empty($request->pdf)) {
                $files = json_decode($request->pdf, true);
                foreach ($files as $item) {
                    $sourcePath = storage_path('app/temp/' . $so . '/' . $item['filename']);
                    $destinationPath = storage_path('app/public/visit-report/' . $so . '/' . $item['filename']);

                    if (!Storage::exists('public/visit-report/' . $so)) {
                        Storage::makeDirectory('public/visit-report/' . $so);
                    }

                    if (file_exists($sourcePath)) {
                        rename($sourcePath, $destinationPath);
                    }
                }

                Storage::deleteDirectory('temp/' . $so);
            }

            $usersToNotify = User::role('manager')->get();
            Notification::send($usersToNotify, new NewVisitReportNotification($visitReport));

            if (($old_nextdate == null) && ($old_nexttime == null)) {
                if ($request->next_date_visit != null && $request->next_time_visit != null) {
                    $generate_id = VisitScheduleController::generate_id_static();
                    $visit = new VisitSchedule();
                    $visit->id = $generate_id;
                    $visit->customer_id = $visitReport->visit->customer_id;
                    $visit->visit_by    = $visitschedule->visit_by;
                    $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
                    $visit->devision = $visitReport->visit->devision;
                    $visit->date = $request->next_date_visit;
                    $visit->time = $request->next_time_visit;
                    $visit->note = null;
                    $visit->save();

                    $usersToNotify = User::role('manager')->get();
                    Notification::send($usersToNotify, new NewVisitScheduleNotification($visit));
                }
            } else {
            }

            DB::commit();

            return redirect()->route('crm.visit-report')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            $visit = VisitReport::where('uuid', $id)->first();

            DB::beginTransaction();

            $visit->delete();

            DB::commit();

            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
