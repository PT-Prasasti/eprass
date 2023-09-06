<?php

namespace App\Http\Controllers\DataMaster;

use App\Constants;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DataMaster\Supplier\AddSupplierRequest;
use App\Http\Requests\DataMaster\Supplier\EditSupplierRequest;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : View 
    {
        return view('data-master.supplier.index');
    }

    public function  data(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $data = Supplier::all();
    
            $result = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('supplier', function($q) {
                    return strtoupper($q->sales_rep.' - '.$q->company);
                })
                ->addColumn('email', function($q) {
                    return $q->company_email;
                })
                ->addColumn('phone', function($q) {
                    return $q->contact_number;
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
        return view('data-master.supplier.add');
    }

    public function store(AddSupplierRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();

            $supplier = new Supplier();
            $supplier->company = $request->company_name;
            $supplier->company_phone = $request->company_phone;
            $supplier->company_email = $request->company_email;
            $supplier->item_spesialization = $request->item_spesialization;
            $supplier->address = $request->address;
            $supplier->sales_rep = $request->sales_representative;
            $supplier->contact_number = $request->contact_number;
            $supplier->sales_email = $request->sales_email;
            $supplier->location = $request->location;
            $supplier->bank_name = $request->bank_name;
            $supplier->bank_number = $request->bank_number;
            $supplier->bank_account = $request->bank_account;
            $supplier->bank_swift = $request->bank_swift;
            $supplier->save();

            DB::commit();
            
            return redirect()->route('data-master.supplier')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
    
    public function edit($id) : View
    {
        $supplier = Supplier::where('uuid', $id)->first();
        return view('data-master.supplier.edit', compact('supplier'));
    }
    
    public function store_edit(EditSupplierRequest $request) : RedirectResponse
    {
        try {
            DB::beginTransaction();

            $supplier = Supplier::where('uuid', $request->uuid)->first();
            $supplier->company = $request->company_name;
            $supplier->company_phone = $request->company_phone;
            $supplier->company_email = $request->company_email;
            $supplier->item_spesialization = $request->item_spesialization;
            $supplier->address = $request->address;
            $supplier->sales_rep = $request->sales_representative;
            $supplier->contact_number = $request->contact_number;
            $supplier->sales_email = $request->sales_email;
            $supplier->location = $request->location;
            $supplier->bank_name = $request->bank_name;
            $supplier->bank_number = $request->bank_number;
            $supplier->bank_account = $request->bank_account;
            $supplier->bank_swift = $request->bank_swift;
            $supplier->save();
            
            DB::commit();
            
            return redirect()->route('data-master.supplier')->with('success', Constants::STORE_DATA_SUCCESS_MSG);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function delete($id) : RedirectResponse
    {
        try {
            $supplier = Supplier::where('uuid', $id)->first();
            
            DB::beginTransaction();
            
            $supplier->delete();

            DB::commit();
    
            return redirect()->back()->with('delete', Constants::STORE_DATA_DELETE_MSG);

        } catch(\Exception $e) {
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }
}
