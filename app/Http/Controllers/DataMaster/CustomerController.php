<?php

namespace App\Http\Controllers\DataMaster;

use App\Constants;
use App\Models\User;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DataMaster\Customer\AddCustomerRequest;
use App\Http\Requests\DataMaster\Customer\EditCustomerRequest;
use App\Models\Sales;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View 
    {
        return view('data-master.customer.index');
    }

    public function  data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            if(auth()->user()->hasRole('superadmin')){
                $data = Customer::all();
            } else {
                $sales = Sales::where('username', auth()->user()->username)->first();
                $data = Customer::where('sales_id', $sales->id)
                    ->get();
            }
    
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function($q) {
                    return strtoupper($q->name.' - '.$q->company);
                })
                ->addColumn('email', function($q) {
                    return $q->email;
                })
                ->addColumn('phone', function($q) {
                    return $q->phone;
                })
                ->addColumn('telp', function($q) {
                    return $q->company_phone;
                })
                ->make(true);
    
            return $result;
        }
    }

    public function add() : View 
    {
        return view('data-master.customer.add');
    }

    public function store(AddCustomerRequest $request) : RedirectResponse
    {
        try {
            
            if($request->hasFile('profile')){
                $path = Storage::disk('public')->putFile('profiles', $request->file('profile'));
            }

            DB::beginTransaction();
            
            $customer = new Customer();
            $customer->name = $request->customer_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->alternate = $request->alternate;
            $customer->company = $request->company_name;
            $customer->company_phone = $request->company_phone;
            $customer->company_fax = $request->company_fax;
            if($request->hasFile('profile')){
                $customer->profile_picture = $path;
            }
            $customer->username = $request->username;
            $customer->password = $request->password;
            $customer->address = $request->address;
            $customer->note = $request->note;
            $customer->sales_id = Sales::where('username', auth()->user()->username)->first()->id;
            $customer->save();

            if(isset($request->username) && isset($request->password)) {
                $user = new User();
                $user->name = $request->customer_name;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();
    
                $user->assignRole('customer');
            }

            DB::commit();

            return redirect()->route('data-master.customer')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function edit($id) : View
    {
        $customer = Customer::where('uuid', $id)->first();

        return view('data-master.customer.edit', compact('customer'));
    }
    
    public function profile($id)
    {
        $file = Customer::where('uuid', $id)->first();
        return Response::make($file->profile_picture, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
     
    public function store_edit(EditCustomerRequest $request)
    {
        if($request->hasFile('profile')){
            $path = Storage::disk('public')->putFile('profiles', $request->file('profile'));
        }

        DB::beginTransaction();

        $customer = Customer::where('uuid', $request->uuid)->first();
        
        if($request->username != null) {
            $user = User::where('username', $request->username)->first();
            
            if($user) {
                if($request->username != $customer->username) {
                    $user->username = $request->username;
                    $user->save();
                }
    
                if($request->password != $customer->password) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                }     
            } else {
                $user = new User();
                $user->name = $request->customer_name;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();
                $user->assignRole('customer');
            }
        }
        
        $customer->name = $request->customer_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->alternate = $request->alternate;
        $customer->company = $request->company_name;
        $customer->company_phone = $request->company_phone;
        $customer->company_fax = $request->company_fax;
        if($request->hasFile('profile')){
            $customer->profile_picture = $path;
        }
        $customer->username = $request->username;
        $customer->password = $request->password;
        $customer->address = $request->address;
        $customer->note = $request->note;
        $customer->save();       
        
        DB::commit();
        
        return redirect()->route('data-master.customer')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        try {
            

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
    
    public function delete($id)
    {
        try {
            $customer = Customer::where('uuid', $id)->first();

            DB::beginTransaction();

            $customer->delete();

            DB::commit();
    
            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
