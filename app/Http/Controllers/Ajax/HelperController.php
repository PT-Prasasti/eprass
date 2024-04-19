<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Documentes;
use App\Models\PurchaseOrderCustomer;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function countNewInquiry()
    {
        $jum = 0;
        $inquiry = \App\Models\Inquiry::selectRaw("count(*) as jum")->whereRaw('id NOT IN (
            SELECT inquiry_id FROM sales_orders where deleted_at is null
        )')->first();
        if (!empty($inquiry)) {
            $jum = $inquiry->jum;
        }
        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countNewSourcingItem()
    {
        $jum = 0;
        $sourcing = \App\Models\Sourcing::selectRaw("count(*) as jum")->whereRaw("so_id IN (
            SELECT id FROM sales_orders where status = 'On Process')")->where('deleted_at', '=', NULL)->first();
        if (!empty($sourcing)) {
            $jum = $sourcing->jum;
        }

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countAppPOSupplier()
    {
        $jum = 0;
        $posupp = \App\Models\PurchaseOrderSupplier::selectRaw("count(*) as jum")->where('status', '!=', 'Approved By Manager')->where('status', '!=', 'Rejected By Manager')->where('deleted_at', '=', NULL)->first();
        if (!empty($posupp)) {
            $jum = $posupp->jum;
        }

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countAppPaymentReq()
    {
        $userRole = request()->input('userRole');
        $pendingStatusPatterns = ["Waiting For HRD Approval", "Waiting For HOD Approval", "Waiting For Manager Approval"];

        $jum = 0;

        $paymentRequests = \App\Models\PaymentRequestExim::selectRaw("count(*) as jum")
            ->whereRaw("LOWER(status) LIKE ?", ["%{$userRole}%"])
            ->whereIn('status', $pendingStatusPatterns)
            ->where('deleted_at', '=', NULL)
            ->first();

        if (!empty($paymentRequests)) {
            $jum = $paymentRequests->jum;
        }

        $notificationMessage = "You have {$jum} new payment requests pending for {$userRole} approval.";

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum,
                'userRole' => $userRole
            ],
            'notification' => $notificationMessage
        ]);
    }

    public function countSalesOrder()
    {
        $jum = SalesOrder::where('status', 'On Process')->count();

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countSelectionDoneOnSalesOrder()
    {
        $jum = SalesOrder::where('status', 'Selection Done')->count();

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countPriceListReadyOnSalesOrder()
    {
        $jum = SalesOrder::where('status', 'Price List Ready')->count();

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countQuotation()
    {
        $jum = Quotation::where('status', '!=', 'Done')->count();

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function countPOCustomer()
    {
        $jum = PurchaseOrderCustomer::where('status', 'ON PROGRESS')->count();

        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }

    public function docadd(Request $request)
    {
        $post = $request->all();
        $file_info = $request->file;

        // dd($file_info->getSize(), $file_info->getMimeType(), $file_info->getClientOriginalName(), $post);

        $path = $file_info->store("uploads/attachment/" . date("Ymd"), 'public');

        $document = new \App\Models\Documentes;
        $document->filename = $file_info->getClientOriginalName();
        $document->path = $path;
        $document->related_table = $request->related_table;
        $document->related_id = $request->related_id;
        $document->file_size = $file_info->getSize();
        $document->file_type = $file_info->getMimeType();
        $document->doc_type = "attachment";
        $document->save();

        return response()->json([
            'code' => 200,
            'data' => $document
        ]);
    }

    public function docrem(Request $request)
    {
        $doc = \App\Models\Documentes::find($request->id);
        $delete_path = __DIR__ . "/../../../../storage/app/public/" . $doc->path;
        unlink($delete_path);
        $doc->delete();

        return response()->json([
            'code' => 200,
            'data' => $doc
        ]);
    }

    public function doclist(Request $request)
    {
        $documents = \App\Models\Documentes::where([
            ["related_table", $request->related_table],
            ["related_id", $request->related_id],
        ])->get()->map(function ($r) {
            $xten = explode(".", $r->filename);
            $r->file_type = '/' . $xten[(count($xten) - 1)];
            $r->timeago = \App\Helper\Helper::timeago($r->created_at);
            return $r;
        });

        return response()->json([
            'code' => 200,
            'data' => $documents
        ]);
    }

    public function doclistother(Request $request)
    {
        $files = Quotation::where('quotations.id', $request->related_id)
            ->join('sales_orders', 'quotations.sales_order_id', '=', 'sales_orders.uuid')
            ->join('inquiries', 'sales_orders.inquiry_id', '=', 'inquiries.id')
            ->join('documentes', 'sales_orders.id', '=', 'documentes.related_id')
            ->join('visit_schedules', 'inquiries.visit_schedule_id', '=', 'visit_schedules.id')
            ->where('documentes.related_table', 'sourcings')
            ->select('*')
            ->select('documentes.*', 'inquiries.files as inquiry_files', 'inquiries.id as inquiry_id', 'sales_orders.id as sales_order_id', 'visit_schedules.uuid as visit_schedule_uuid')
            ->first();

        $inquiry_files = \json_decode($files->inquiry_files);
        foreach ($inquiry_files as $file) {
            $file->url = url('/file/show/inquiry', $files->visit_schedule_uuid) . '/' . $file->filename;
        }

        $documents = [
            'inquiry' => [
                'id' => $files->inquiry_id,
                'files' => $inquiry_files,
            ],
            'sales_orders' => [
                'id' => $files->sales_order_id,
                'files' => $inquiry_files,
            ],
            'sourcings' => [
                'id' => $files->related_id,
                'files' => Documentes::where([
                    ["related_table", $files->related_table],
                    ["related_id", $files->related_id],
                ])->get()->map(function ($r) {
                    $xten = explode(".", $r->filename);
                    $r->file_type = '/' . $xten[(count($xten) - 1)];
                    $r->timeago = \App\Helper\Helper::timeago($r->created_at);
                    return $r;
                }),
            ]
        ];

        return response()->json([
            'code' => 200,
            'data' => $documents
        ]);
    }
}
