<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliverySchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function poc()
    {
        return $this->belongsTo(PurchaseOrderCustomer::class, 'po_customer_id', 'kode_khusus');
    }

    public function delivery_schedule_items()
    {
        return $this->hasMany(DeliveryScheduleItem::class);
    }
}
