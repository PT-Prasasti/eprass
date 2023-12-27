<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Cloud;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderCustomer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Helper\FilesController;

class CloudController extends Controller
{
    protected $fileController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->fileController = new FilesController();
    }

    public function index(Request $request)
    {
        $query = Cloud::query()
            ->leftJoin('purchase_order_customers as poc', 'clouds.po_customer', '=', 'poc.id')
            ->leftJoin('quotations', 'poc.quotation_id', '=', 'quotations.id')
            ->leftJoin('sales_orders', 'quotations.sales_order_id', '=', 'sales_orders.uuid')
            ->leftJoin('inquiries', 'sales_orders.inquiry_id', '=', 'inquiries.id')
            ->leftJoin('visit_schedules', 'inquiries.visit_schedule_id', '=', 'visit_schedules.id')
            ->leftJoin('customers', 'visit_schedules.customer_id', '=', 'customers.id')
            ->leftJoin('sales', 'inquiries.sales_id', '=', 'sales.id')
            ->select([
                'clouds.id AS id',
                'clouds.uuid AS uuid',
                'clouds.po_customer AS po_customer',
                DB::raw("DATE_FORMAT(clouds.date, '%e %M %Y') AS date"),
                'clouds.qr_code_url AS qr_code',
                'purchase_order_customers.kode_khusus AS kode_khusus',
                'customers.name AS customer_name',
                'customers.company AS company_name',
                'sales.name AS sales_name',
            ])
            ->join('purchase_order_customers', 'purchase_order_customers.id', '=', 'clouds.po_customer');

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('cloud.index');
    }

    public function create()
    {
        return view('cloud.create');
    }

    public function getPoc($id)
    {
        $purchaseOrderCustomer = PurchaseOrderCustomer::with('quotation.sales_order.inquiry.products')->find($id);

        $data = $purchaseOrderCustomer->quotation->sales_order->inquiry->products->map(function ($product) {
            return [
                'uuid' => $product->uuid,
                'item_name' => $product->item_name,
                'description' => $product->description,
                'size' => $product->size,
                'qty' => $product->qty,
                'remark' => $product->remark,
            ];
        });

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $query = new Cloud();
            $query->po_customer = $request->po_customer;
            $query->date = date('Y-m-d');
            $query->document_list = $request->document_list;

            $query->save();

            $qrCodeData = json_encode([
                'po_customer' => $query->po_customer,
                'date' => $query->date,
                'document_list' => $query->document_list,
            ]);

            $qrCode = QrCode::format('png')->size(200)->generate($qrCodeData);

            $qrCodeFilename = 'qr_code_' . $query->uuid . '.png';

            Storage::put('public/cloud-storage/qr/' . $qrCodeFilename, $qrCode);

            $query->qr_code_url = $qrCodeFilename;
            $query->save();

            if ($request->document_list) {
                $files = json_decode($request->document_list, true);
                $fileDirectory = 'cloud-storage';
                foreach ($files as $item) {
                    $sourceFilePath = storage_path('app/temp/' . $fileDirectory . '/' . $item['filename']);
                    $destinationFilePath = storage_path('app/public/' . $fileDirectory . '/' . $item['filename']);

                    if (!Storage::exists('public/' . $fileDirectory)) {
                        Storage::makeDirectory('public/' . $fileDirectory);
                    }

                    if (file_exists($sourceFilePath)) {
                        rename($sourceFilePath, $destinationFilePath);
                    }
                }
            }

            DB::commit();

            return redirect()->route('cloud')->with('success', Constants::STORE_DATA_SUCCESS_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function view()
    {

    }

    public function delete($id)
    {
        try {
            $query = Cloud::find($id);

            DB::beginTransaction();

            if ($query->document_list) {
                $files = json_decode($query->document_list, true);

                foreach ($files as $item) {
                    $filePath = storage_path('app/public/cloud-storage/') . $item['filename'];

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $qrCodePath = storage_path('app/public/cloud-storage/qr/') . $query->qr_code_url;

            if (file_exists($qrCodePath)) {
                unlink($qrCodePath);
            }

            $query->delete();

            DB::commit();

            return redirect()->back()->with('success', Constants::STORE_DATA_DELETE_MSG);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', Constants::ERROR_MSG);
        }
    }

    public function print($id)
    {
        $cloud = Cloud::where('uuid', $id)->first();

        $qrCodeUrl = $cloud->qr_code_url;

        return view('cloud.print', compact('qrCodeUrl'));
    }

    public function upload_document(Request $request)
    {
        try {
            $fileDirectory = 'cloud-storage';
            $data = $request->other_files ? json_decode($request->other_files) : [];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $upload = $this->fileController->store_temp($file, $fileDirectory);
                if ($upload->original['status'] == 200) {
                    $fileUploaded = $upload->original['data'];

                    array_push($data, $fileUploaded);

                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $data,
                    ]);
                }
            } elseif ($request->method === "DELETE" && $request->file_name) {
                $fileName = $request->file_name;
                $filePath = $fileDirectory . '/' . $fileName;
                if (Storage::exists('public/' . $filePath) || Storage::exists('temp/' . $filePath)) {
                    if (Storage::exists('public/' . $filePath)) {
                        Storage::delete('public/' . $filePath);
                    } elseif (Storage::exists('temp/' . $filePath)) {
                        Storage::delete('temp/' . $filePath);
                    }

                    if ($data) {
                        foreach ($data as $key => $file) {
                            if ($file->filename === $fileName) {
                                unset($data[$key]);
                            }
                        }

                        $data = array_values($data);
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        'data' => $data,
                    ]);
                }
            }

            return response()->json([
                'status' => 409,
                'message' => 'failed',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'error',
                'data' => [],
            ]);
        }
    }
}
