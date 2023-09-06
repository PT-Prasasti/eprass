<?php

namespace App\Http\Controllers\DataMaster;

use App\Constants;
use App\Models\User;
use App\Models\Sales;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DataMaster\Sales\AddSalesRequest;
use App\Http\Requests\DataMaster\Sales\EditSalesRequest;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View 
    {
        return view('data-master.sales.index');
    }

    public function  data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $data = Sales::all();
    
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sales', function($q) {
                    return strtoupper($q->name);
                })
                ->addColumn('email', function($q) {
                    return $q->email;
                })
                ->addColumn('phone', function($q) {
                    return $q->phone;
                })
                ->make(true);
    
            return $result;
        }
    }

    public function add() : View 
    {
        return view('data-master.sales.add');
    }

    public function store(AddSalesRequest $request) : RedirectResponse
    {
        try {

            if($request->hasFile('profile')){
                $path = Storage::disk('public')->putFile('profiles', $request->file('profile'));
            }
            if($request->hasFile('sign')){
                $sign = Storage::disk('public')->putFile('signs', $request->file('sign'));
            }

            DB::beginTransaction();

            $sales = new Sales();
            $sales->name = $request->sales_name;
            $sales->phone = $request->phone;
            $sales->email = $request->email;
            $sales->alternate = $request->alternate;
            if($request->hasFile('profile')){
                $sales->profile_picture = $path;
            }
            $sales->username = $request->username;
            $sales->password = $request->password;
            if($request->hasFile('sign')){
                $sales->sign = $sign;
            }
            $sales->save();

            if(isset($request->username) && isset($request->password)) {
                $user = new User();
                $user->name = $request->sales_name;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();
    
                $user->assignRole('sales');
            }

            DB::commit();

            return redirect()->route('data-master.sales')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
    
    public function edit($id) : View
    {
        $sales = Sales::where('uuid', $id)->first();
        return view('data-master.sales.edit', compact('sales'));
    }
    
    public function profile($id)
    {
        $file = Sales::where('uuid', $id)->first();
        return Response::make($file->profile_picture, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
    
    public function store_edit(EditSalesRequest $request) : RedirectResponse
    {
        try {

            if($request->hasFile('profile')){
                $path = Storage::disk('public')->putFile('profiles', $request->file('profile'));
            }
            if($request->hasFile('sign')){
                $sign = Storage::disk('public')->putFile('signs', $request->file('sign'));
            }

            DB::beginTransaction();

            $sales = Sales::where('uuid', $request->uuid)->first();
            
            $user = User::where('username', $request->username)->first();
            
            if($user) {
                if($request->username != $sales->username) {
                    $user->username = $request->username;
                    $user->save();
                }
    
                if($request->password != $sales->password) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                }     
            } else {
                $user = new User();
                $user->name = $request->sales_name;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();
                $user->assignRole('sales');
            }
            
            $sales->name = $request->sales_name;
            $sales->phone = $request->phone;
            $sales->email = $request->email;
            $sales->alternate = $request->alternate;
            if($request->hasFile('profile')){
                $sales->profile_picture = $path;
            }
            if($request->hasFile('sign')){
                $sales->sign = $sign;
            }
            $sales->username = $request->username;
            $sales->password = $request->password;
            $sales->save();
            
            DB::commit();
            
            return redirect()->route('data-master.sales')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id) : RedirectResponse
    {
        try {
            $sales = Sales::where('uuid', $id)->first();
            
            DB::beginTransaction();
            
            $sales->delete();

            DB::commit();
    
            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
