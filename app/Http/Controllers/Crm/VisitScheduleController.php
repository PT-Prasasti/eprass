<?php

namespace App\Http\Controllers\Crm;

use App\Constants;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\Enginer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewVisitScheduleNotification;
use App\Http\Requests\Crm\VisitSchedule\AddVisitScheduleRequest;
use App\Http\Requests\Crm\VisitSchedule\EditVisitScheduleRequest;
use App\Http\Requests\Crm\VisitSchedule\StatusVisitScheduleRequest;

use App\Mail\VisitMail;
use Mail;

class VisitScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View
    {
        return view('crm.visit-schedule.index');
    }

    public function data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            if(auth()->user()->hasRole('superadmin')){
                $data = VisitSchedule::all();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = VisitSchedule::where('sales_id', $sales->id)
                    ->get();
            }
    
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function($q) {
                    return $q->id;
                })
                ->addColumn('customer', function($q) {
                    return strtoupper($q->customer->name.' - '.$q->customer->company);
                })
                ->editColumn('date', function($q) {
                    return Carbon::parse($q->date)->format('d M Y');
                })
                ->editColumn('time', function($q) {
                    if(isset($q->time)) {
                        return Carbon::parse($q->time)->format('H:i');
                    } else {
                        return '-';
                    }
                })
                ->addColumn('status', function($q) {
                    $status = array(
                        'uuid' => $q->uuid,
                        'status' => strtoupper($q->status)
                    );
                    return $status;
                })
                ->addColumn('report', function($q) {
                    return $q->uuid;
                })
                ->make(true);
    
            return $result;
        }
    }
    
    public function add() : View
    {
        return view('crm.visit-schedule.add');
    }

    public static function generate_id_static() : string
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $code = 'VI';
        $month = (int) date('m');
        $year = date('y');
        
        $last_data = VisitSchedule::orderBy('created_at', 'DESC')->withTrashed()->first();
        
        if ($last_data) {
            $last_id = $last_data->id;
            $id = explode("/", $last_id);
            $number = (int) $id[0];
            $number++;
        } else {
            $number = 1;
        }

        $generate_id = sprintf("%04s", $number) . "/" . $code . "/" . $romans[$month - 1] . "/" . $year;
        
        return $generate_id;
    }

    public function generate_id() : JsonResponse
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $code = 'VI';
        $month = (int) date('m');
        $year = date('y');
        
        $last_data = VisitSchedule::orderBy('created_at', 'DESC')->withTrashed()->first();
        
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

    public function company() : JsonResponse
    {
        if(auth()->user()->hasRole('superadmin')) {
            $company = Customer::all();
        } else {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $company = Customer::where('sales_id', $sales->id)
                ->get();
        }
        $result = array();

        foreach ($company as $item) {
            $result[] = array(
                'company' => ucwords($item->company),
                'uuid' => $item->uuid,
            );
        }

        return response()->json($result);
    }

    public function company_detail($id) : JsonResponse
    {
        $company = Customer::where('uuid', $id)->first();

        $result = array(
            'company_phone' => $company->company_phone,
            'customer' => strtoupper($company->name),
            'customer_phone' => $company->phone,
            'customer_email' => $company->email,
        );  

        return response()->json($result);
    }

    public function store(AddVisitScheduleRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();
    
            $visit = new VisitSchedule();
            $visit->id = $request->id;
            $visit->customer_id = Customer::where('uuid', $request->company)->first()->id;
            $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $visit->visit_by = $request->visit_by;
            $visit->devision = $request->devision;
            $visit->date = $request->date;
            $visit->time = $request->time != null ? $request->time : Carbon::createFromTime(9, 0, 0);
            $visit->schedule = $request->schedule;
            $visit->enginer_email = json_encode($request->engineer);
            $visit->save();
    
            $usersToNotify = User::role('manager')->get();
            Notification::send($usersToNotify, new NewVisitScheduleNotification($visit));

            $dataVisit = [
                'id' => $visit->id,
                'company' => $visit->customer->company,
                'company_phone'     => $visit->customer->company_phone,
                'customer_name'     => $visit->customer->name,
                'customer_phone'     => $visit->customer->phone,
                'customer_email'     => $visit->customer->email,
                'visit_by'           => $visit->visit_by  
            ];
            $email = new VisitMail(collect($visit));
            $sendmail = 'rifan@gmail.com';
            Mail::to($sendmail)->send($email);
    
            DB::commit();
    
            return redirect()->route('crm.visit-schedule')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function status(StatusVisitScheduleRequest $request) : RedirectResponse
    {
        $visit = VisitSchedule::where('uuid', $request->uuid)->first();

        try {
            DB::beginTransaction();

            $visit->status = $request->status;
            $visit->note = $request->note;
            $visit->save();

            DB::commit();

            return redirect()->back()->with('success', Constants::CHANGE_STATUS_SUCCESS_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }

    }

    public function view($id) : View
    {
        $visit = VisitSchedule::where('uuid', $id)->first();

        return view('crm.visit-schedule.view', compact('visit'));
    }

    public function edit($id) : View
    {
        $visit = VisitSchedule::where('uuid', $id)->first();

        return view('crm.visit-schedule.edit', compact('visit'));
    }
    
    public function store_edit(EditVisitScheduleRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();
    
            $visit = VisitSchedule::where('uuid', $request->uuid)->first();
            $visit->customer_id = Customer::where('uuid', $request->company)->first()->id;
            $visit->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $visit->visit_by = $request->visit_by;
            $visit->devision = $request->devision;
            $visit->date = $request->date;
            $visit->time = $request->time;
            $visit->schedule = $request->schedule;
            $visit->enginer_email = json_encode($request->engineer);
            $visit->save();
    
            DB::commit();
    
            return redirect()->route('crm.visit-schedule')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id) : RedirectResponse
    {
        try {
            $visit = VisitSchedule::where('uuid', $id)->first();

            DB::beginTransaction();

            $visit->delete();

            DB::commit();
    
            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function search_enginer(Request $request) : JsonResponse
    {
        if($request->q) {
            $data = Enginer::where('name', 'LIKE', "%{$request->q}%")->limit(10)->get(['email']);

            return response()->json($data);
        }else {
            $data = Enginer::limit(10)->get(['email']);

            return response()->json($data);
        }
    }
}
