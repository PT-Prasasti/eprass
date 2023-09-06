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
use App\Http\Requests\Crm\VisitReport\AddVisitReportRequest;
use App\Http\Requests\Crm\VisitReport\EditVisitReportRequest;

class VisitReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View
    {
        return view('crm.visit-report.index');
    }

    public function data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            if(auth()->user()->hasRole('superadmin')){
                $data = VisitReport::all();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = VisitReport::where('sales_id', $sales->id)
                    ->get();
            }
    
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function($q) {
                    return $q->visit_schedule_id;
                })
                ->addColumn('customer', function($q) {
                    return strtoupper($q->visit->customer->name.' - '.$q->visit->customer->company);
                })
                ->editColumn('date', function($q) {
                    return Carbon::parse($q->visit->date)->format('d M Y');
                })
                ->make(true);
    
            return $result;
        }
    }

    public function report($id = null) : RedirectResponse
    {
        $visit = VisitSchedule::where('uuid', $id)->first();
        $report = VisitReport::where('visit_schedule_id', $visit->id)->first();
        if($report) {
            return redirect()->route('crm.visit-report.edit', ['id' => $report->uuid]);
        } else {
            return redirect()->route('crm.visit-report.add', ['id' => $id]);
        }
    }
    
    public function add($id = null) : View
    {
        if($id) {
            $visit = VisitSchedule::where('uuid', $id)->first();

            $data = array(
                'id' => $visit->id,
                'uuid' => $visit->uuid,
                'visit_date' => Carbon::parse($visit->date)->format('d M Y'),
                'visit_time' => isset($visit->time) ? Carbon::parse($visit->time)->format('H:i') : '00:00',
                'customer' => strtoupper($visit->customer->name.' - '.$visit->customer->company),
                'phone' => $visit->customer->phone,
                'email' => $visit->sales->email,
            );  

            return view('crm.visit-report.add', compact('data'));
        } else {
            return view('crm.visit-report.add');
        }
    }

    public function visit() : JsonResponse
    {
        if(auth()->user()->hasRole('superadmin')){
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
                'id' => $item->id,
                'uuid' => $item->uuid,
            );
        }

        return response()->json($result);
    }

    public function visit_detail($id) : JsonResponse
    {
        $visit = VisitSchedule::where('uuid', $id)->first();

        $result = array(
            'visit_date' => Carbon::parse($visit->date)->format('d M Y'),
            'visit_time' => isset($visit->time) ? Carbon::parse($visit->time)->format('H:i') : '00:00',
            'customer' => $visit->customer->name.' - '.$visit->customer->company,
            'phone' => $visit->customer->phone,
            'email' => $visit->customer->email,
        );  

        return response()->json($result);
    }

    public function store(AddVisitReportRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();
    
            $visitReport = new VisitReport();
            $visitReport->id = $request->id;
            $visitReport->visit_schedule_id = VisitSchedule::where('uuid', $request->visit)->first()->id;
            $visitReport->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $visitReport->status = $request->status;
            $visitReport->note = $request->note;
            $visitReport->planing = $request->planing;
            $visitReport->next_date_visit = $request->next_date_visit;
            $visitReport->next_time_visit = $request->next_time_visit;
            $visitReport->save();
    
            $usersToNotify = User::role('manager')->get(); 
            Notification::send($usersToNotify, new NewVisitReportNotification($visitReport));
    
            if(($request->next_date_visit != null) && ($request->next_time_visit != null)) {
                $generate_id = VisitScheduleController::generate_id_static();
                $visit = new VisitSchedule();
                $visit->id = $generate_id;
                $visit->customer_id = $visitReport->visit->customer_id;
                $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
                $visit->devision = $visitReport->visit->devision;
                $visit->date = $request->next_date_visit;
                $visit->time = $request->next_time_visit;
                $visit->note = null;
                $visit->save();
        
                $usersToNotify = User::role('manager')->get();
                Notification::send($usersToNotify, new NewVisitScheduleNotification($visit));

            }
    
            DB::commit();
    
            return redirect()->route('crm.visit-report')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function view($id) : View
    {
        $visit = VisitReport::where('uuid', $id)->first();

        return view('crm.visit-report.view', compact('visit'));
    }

    public function edit($id) : View
    {
        $visit = VisitReport::where('uuid', $id)->first();

        return view('crm.visit-report.edit', compact('visit'));
    }
    
    public function store_edit(EditVisitReportRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();
    
            $visitReport = VisitReport::where('uuid', $request->uuid)->first();
            $visitReport->visit_schedule_id = VisitSchedule::where('uuid', $request->visit)->first()->id;
            $visitReport->status = $request->status;
            $visitReport->note = $request->note;
            $visitReport->planing = $request->planing;
            $visitReport->next_date_visit = $request->next_date_visit;
            $visitReport->next_time_visit = $request->next_time_visit;
            $visitReport->save();
    
            $usersToNotify = User::role('manager')->get(); 
            Notification::send($usersToNotify, new NewVisitReportNotification($visitReport));
    
            if(($request->next_date_visit != null) && ($request->next_time_visit != null)) {
                $generate_id = VisitScheduleController::generate_id_static();
                $visit = new VisitSchedule();
                $visit->id = $generate_id;
                $visit->customer_id = $visitReport->visit->customer_id;
                $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
                $visit->devision = $visitReport->visit->devision;
                $visit->date = $request->next_date_visit;
                $visit->time = $request->next_time_visit;
                $visit->note = null;
                $visit->save();
        
                $usersToNotify = User::role('manager')->get();
                Notification::send($usersToNotify, new NewVisitScheduleNotification($visit));

            }
    
            DB::commit();
    
            return redirect()->route('crm.visit-report')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id) : RedirectResponse
    {
        try {
            $visit = VisitReport::where('uuid', $id)->first();

            DB::beginTransaction();

            $visit->delete();

            DB::commit();
    
            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
