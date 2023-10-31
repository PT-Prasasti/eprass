<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Inquiry;
use App\Models\PurchaseOrderCustomer;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    protected $hosting;

    public function __construct()
    {
        $this->middleware('auth');

        if (env('HOSTING')) {
            $this->hosting = env('HOSTING');
        } else {
            $this->hosting = false;
        }
    }

    public function dashboard(): View
    {
        $redis = Redis::keys('*');
        foreach ($redis as $item) {
            if (str_contains($item, auth()->user()->uuid)) {
                if ($this->hosting == false) {
                    $item = explode('database_', $item);
                    $item = $item[1];
                }
                Redis::del($item);
            }
        }

        $quotation = Quotation::query();
        $purchaseOrderCustomer = PurchaseOrderCustomer::query();
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)
                ->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->count();
            $inquiry = Inquiry::where('sales_id', $sales->id)
                ->count();
            $quotation = $quotation->whereHas('sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
            $purchaseOrderCustomer = $purchaseOrderCustomer->whereHas('quotation.sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
        } else {
            $visit = VisitSchedule::count();
            $inquiry = Inquiry::count();
            $sales = SalesOrder::count();
        }

        $quotationCount = $quotation->count();
        $purchaseOrderCustomerCount = $purchaseOrderCustomer->count();

        return view('dashboard', compact('visit', 'inquiry', 'sales', 'quotationCount', 'purchaseOrderCustomerCount'));
    }

    public function event(): JsonResponse
    {
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)->get();
        } else {
            $visit = VisitSchedule::all();
        }

        $data = array();

        foreach ($visit as $item) {
            $dateTimeString = Carbon::parse($item->date . ' ' . $item->time)->format('Y-m-d\TH:i:s');

            $data[] = array(
                'title' => $item->customer->company,
                'uuid' => $item->uuid,
                'start' => $dateTimeString,
                'color' => '#3D7FB5',
            );
        }

        return response()->json($data);
    }

    public function data(Request $request): JsonResponse
    {
        $data = $this->event();

        if ($request->visit == 'month') {
            $visit = $this->visit_month();
        } else {
            $visit = $this->visit_year();
        }

        if ($request->crm == 'month') {
            $crm = $this->crm_month();
        } else {
            $crm = $this->crm_year();
        }

        return response()->json(array(
            'event' => $data->original,
            'visit' => $visit->original,
            'crm' => $crm->original,
        ));
    }

    public function visit_month(): JsonResponse
    {
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
        } else {
            $visit = VisitSchedule::whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
        }

        foreach ($visit as $item) {

            $createdAtMonth = (int) Carbon::parse($item->created_at)->format('m');

            if (!isset($groupedData[$createdAtMonth])) {
                $groupedData[$createdAtMonth] = [
                    'phone' => 0,
                    'email' => 0,
                    'onsite' => 0,
                ];
            }

            if (strtolower($item->visit_by) == 'phone') {
                $groupedData[$createdAtMonth]['phone']++;
            }

            if (strtolower($item->visit_by) == 'email') {
                $groupedData[$createdAtMonth]['email']++;
            }

            if (strtolower($item->visit_by) == 'onsite') {
                $groupedData[$createdAtMonth]['onsite']++;
            }
        }

        $visitData = array();

        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) {
                $month = Carbon::parse('01-0' . $i . '-' . Carbon::now()->year())->format('M');
            } else {
                $month = Carbon::parse('01-' . $i . '-' . Carbon::now()->year())->format('M');
            }

            if (isset($groupedData[$i])) {
                $visitData[] = array(
                    'month' => $month,
                    'phone' => $groupedData[$i]['phone'],
                    'email' => $groupedData[$i]['email'],
                    'onsite' => $groupedData[$i]['onsite'],
                );
            }
        }

        $visitSchedule = array(
            'total' => $visit->count(),
            'data' => $visitData
        );

        return response()->json($visitSchedule);
    }

    public function visit_year(): JsonResponse
    {
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
        } else {
            $visit = VisitSchedule::whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
        }

        foreach ($visit as $item) {

            $createdAtMonth = (int) Carbon::parse($item->created_at)->format('m');

            if (!isset($groupedData[$createdAtMonth])) {
                $groupedData[$createdAtMonth] = [
                    'phone' => 0,
                    'email' => 0,
                    'onsite' => 0,
                ];
            }

            if (strtolower($item->visit_by) == 'phone') {
                $groupedData[$createdAtMonth]['phone']++;
            }

            if (strtolower($item->visit_by) == 'email') {
                $groupedData[$createdAtMonth]['email']++;
            }

            if (strtolower($item->visit_by) == 'onsite') {
                $groupedData[$createdAtMonth]['onsite']++;
            }
        }

        $visitData = array();

        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) {
                $month = Carbon::parse('01-0' . $i . '-' . Carbon::now()->year())->format('M');
            } else {
                $month = Carbon::parse('01-' . $i . '-' . Carbon::now()->year())->format('M');
            }

            if (isset($groupedData[$i])) {
                $visitData[] = array(
                    'month' => $month,
                    'phone' => $groupedData[$i]['phone'],
                    'email' => $groupedData[$i]['email'],
                    'onsite' => $groupedData[$i]['onsite'],
                );
            } else {
                $visitData[] = array(
                    'month' => $month,
                    'phone' => 0,
                    'email' => 0,
                    'onsite' => 0,
                );
            }
        }

        $visitSchedule = array(
            'total' => $visit->count(),
            'data' => $visitData
        );

        return response()->json($visitSchedule);
    }

    public function crm_month(): JsonResponse
    {
        $quotation = Quotation::query();
        $purchaseOrderCustomer = PurchaseOrderCustomer::query();
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->get();
            $inquiry = Inquiry::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->get();
            $quotation = $quotation->whereHas('sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
            $purchaseOrderCustomer = $purchaseOrderCustomer->whereHas('quotation.sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
        } else {
            $visit = VisitSchedule::whereYear('created_at', Carbon::now()->format('Y'))
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->get();
            $inquiry = Inquiry::whereYear('created_at', Carbon::now()->format('Y'))
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->get();
        }

        $quotation = $quotation->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->get();
        $purchaseOrderCustomer = $purchaseOrderCustomer->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->get();

        $data = array(array(
            'month' => Carbon::now()->format('M'),
            'visit' => $visit->count(),
            'inquiry' => $inquiry->count(),
            'quotation' => $quotation->count(),
            'purchase_order_customer' => $purchaseOrderCustomer->count(),
        ));

        return response()->json($data);
    }

    public function crm_year(): JsonResponse
    {
        $quotation = Quotation::query();
        $purchaseOrderCustomer = PurchaseOrderCustomer::query();
        if (auth()->user()->hasRole('sales')) {
            $sales = Sales::where('username', auth()->user()->username)->first();
            $visit = VisitSchedule::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
            $inquiry = Inquiry::where('sales_id', $sales->id)
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
            $quotation = $quotation->whereHas('sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
            $purchaseOrderCustomer = $purchaseOrderCustomer->whereHas('quotation.sales_order.inquiry', function ($query) use ($sales) {
                $query->where('sales_id', $sales->id);
            });
        } else {
            $visit = VisitSchedule::whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
            $inquiry = Inquiry::whereYear('created_at', Carbon::now()->format('Y'))
                ->get();
        }

        $quotation = $quotation->get();
        $purchaseOrderCustomer = $purchaseOrderCustomer->get();

        $data = array();

        for ($i = 1; $i <= 12; $i++) {
            $monthFormatted = str_pad($i, 2, '0', STR_PAD_LEFT);
            $startOfMonth = Carbon::now()->year . '-' . $monthFormatted . '-01';
            $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth();

            $visitsCount = $visit->whereBetween('created_at', [$startOfMonth, Carbon::parse($startOfMonth)->endOfMonth()])->count();
            $inquiriesCount = $inquiry->whereBetween('created_at', [$startOfMonth, Carbon::parse($startOfMonth)->endOfMonth()])->count();
            $quotationsCount = $quotation->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $purchaseOrderCustomersCount = $purchaseOrderCustomer->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data[] = array(
                'month' => Carbon::parse($startOfMonth)->format('M'),
                'visit' => $visitsCount,
                'inquiry' => $inquiriesCount,
                'quotation' => $quotationsCount,
                'purchase_order_customer' => $purchaseOrderCustomersCount,
            );
        }

        return response()->json($data);
    }

    public function data_admin_sales(Request $request): JsonResponse
    {
        $event = $this->event_admin_sales();

        if ($request->pipeline == 'month') {
            $pipeline = $this->pipeline_month_admin_sales();
        } else {
            $pipeline = $this->pipeline_year_admin_sales();
        }

        return response()->json(array(
            'event' => $event->original,
            'pipeline' => $pipeline->original
        ));
    }

    public function event_admin_sales(): JsonResponse
    {
        $so = SalesOrder::all();

        $data = array();

        foreach ($so as $item) {
            $data[] = array(
                'title' => $item->id,
                'uuid' => $item->uuid,
                'start' => $item->inquiry->due_date,
                'color' => '#3D7FB5',
            );
        }

        return response()->json($data);
    }

    public function pipeline_month_admin_sales(): JsonResponse
    {
        $inquiry = Inquiry::whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->get();
        $so = SalesOrder::whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->get();

        $data = array(array(
            'month' => Carbon::now()->format('M'),
            'inquiry' => $inquiry->count(),
            'so' => $so->count(),
        ));

        return response()->json($data);
    }

    public function pipeline_year_admin_sales(): JsonResponse
    {
        $inquiry = Inquiry::whereYear('created_at', Carbon::now()->format('Y'))
            ->get();
        $so = SalesOrder::whereYear('created_at', Carbon::now()->format('Y'))
            ->get();

        $data = array();

        for ($i = 1; $i <= 12; $i++) {
            $monthFormatted = str_pad($i, 2, '0', STR_PAD_LEFT);
            $startOfMonth = Carbon::now()->year . '-' . $monthFormatted . '-01';
            $inquiriesCount = $inquiry->whereBetween('created_at', [$startOfMonth, Carbon::parse($startOfMonth)->endOfMonth()])->count();
            $soCount = $so->whereBetween('created_at', [$startOfMonth, Carbon::parse($startOfMonth)->endOfMonth()])->count();
            $data[] = array(
                'month' => Carbon::parse($startOfMonth)->format('M'),
                'inquiry' => $inquiriesCount,
                'so' => $soCount,
            );
        }

        return response()->json($data);
    }
}
