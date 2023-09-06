<?php

namespace App\Http\Controllers\Helper;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all_notification() : View
    {
        $notifications = auth()->user()->notifications;

        return view('notification.index', compact('notifications'));
    }
    
    public function mark_as_read() : RedirectResponse
    {
        $notifikasi = auth()->user()->unreadNotifications;
        $notifikasi->markAsRead();

        return redirect()->back();
    }
    
    public function read_notification($id) : RedirectResponse
    {
        $notification = DB::table('notifications')
                        ->find($id);
        
        if(empty($notification->read_at)) {
            $update = DB::table('notifications')
                            ->where('id', $id)
                            ->update(['read_at' => now()]);
        }        

        $data = json_decode($notification->data, true);
        if(isset($data['visit_uuid'])) {
            return redirect()->route('crm.visit-schedule.view', ['id' => $data['visit_uuid']]);
        }
        if(isset($data['inquiry_uuid'])) {
            return redirect()->route('transaction.sales-order.add', ['id' => $data['inquiry_uuid']]);
        }
    }

    public function get_notification() : JsonResponse
    {
        $notificationNumber = auth()->user()->unreadnotifications->count();

        $array = array();
        
        if($notificationNumber > 0) {
            $notification = auth()->user()->notifications->take(4);
            foreach($notification as $item) {
                $notif = $item->data['message'];
                if (str_contains($notif, ":visit")) {
                    $replacement = $item->data['visit_id'];
                    $notif = str_replace(":visit", $replacement, $notif);
                }
                if (str_contains($notif, ":customer")) {
                    $customer = Customer::find($item->data['customer_id'])->name;
                    $company = Customer::find($item->data['customer_id'])->company;
                    $replacement = $customer . ' ['. $company .']';
                    $notif = str_replace(":customer", $replacement, $notif);
                }
                if (str_contains($notif, ":sales")) {
                    $sales = Sales::find($item->data['sales_id'])->name;
                    $replacement = $sales;
                    $notif = str_replace(":sales", $replacement, $notif);
                }
    
                $created = $item->created_at;
                $now = Carbon::now();
                $duration = $now->diff($created);
                $seconds = $duration->s;
                $minutes = $duration->i;
                $hours = $duration->h;
                $days = $duration->d;
    
                $time = $seconds . ' detik yang lalu';
                if($minutes >= 1) {
                    $time = $minutes . ' menit yang lalu';
                }
                if($hours >= 1) {
                    $time = $hours . ' jam yang lalu';
                }
                if($days >= 1) {
                    $time = $days . ' hari yang lalu';
                }
                if($days > 7) {
                    $time = 'on ' . Carbon::parse($created)->format('M d');
                }
    
                $array[] = array(
                    'uuid' => $item->id,
                    'message' => $notif,
                    'time' => $time,
                    'read' => $item->read_at == null ? '' : $item->read_at
                );
            }
        }

        return response()->json([
            'number_of_notifications' => $notificationNumber,
            'notification_list' => $array
        ]);
    }
}
