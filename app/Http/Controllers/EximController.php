<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\DataMaster\Customer\AddCustomerRequest;
use App\Http\Requests\DataMaster\Forwarder\AddForwarderRequest;
use App\Models\Forwarder;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EximController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View 
    {
        return view('data-master.forwarder.index');
    }

    public function  data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            // if(auth()->user()->hasRole('superadmin')){
            //     $data = Customer::all();
            // } else {
            //     $sales = Sales::where('username', auth()->user()->username)->first();
            //     $data = Customer::where('sales_id', $sales->id)
            //         ->get();
            // }

            $data = Forwarder::all();

    
            $result = DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('customer', function($q) {
                //     return strtoupper($q->name.' - '.$q->company);
                // })
                // ->addColumn('email', function($q) {
                //     return $q->email;
                // })
                // ->addColumn('phone', function($q) {
                //     return $q->phone;
                // })
                // ->addColumn('telp', function($q) {
                //     return $q->company_phone;
                // })
                ->make(true);
    
            return $result;
        }
    }

    public function add() : View 
    {
        return view('data-master.forwarder.add');
    }

    public function store(AddForwarderRequest $request) : RedirectResponse
    {
        try {
            $forwarder = new Forwarder();
            $forwarder->forwarder_name = $request->forwarder_name;
            $forwarder->forwarder_telephone = $request->forwarder_telephone;
            $forwarder->pic_name = $request->pic_name;
            $forwarder->pic_phone = $request->pic_phone;
            $forwarder->forwarder_address = $request->forwarder_address;
            $forwarder->bank_name = $request->bank_name;
            $forwarder->swift_code = $request->swift_code;
            $forwarder->bank_account = $request->bank_account;
            $forwarder->bank_number = $request->bank_number;
            $forwarder->bank_address = $request->bank_address;
            $forwarder->bank_name_1 =  $request->bank_name_1;
            $forwarder->swift_code_1 = $request->swift_code_1;
            $forwarder->bank_account_1 = $request->bank_account_1;
            $forwarder->bank_number_1 = $request->bank_number_1;
            $forwarder->bank_address_1 = $request->bank_address_1;
            $forwarder->save();
            DB::commit();
            return redirect()->route('data-master.exim')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
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
