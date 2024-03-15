<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class SelectedSourcingSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function sourcing()
    {
        return $this->belongsTo(Sourcing::class, 'sourcing_id', 'id');
    }

    public function sourcing_supplier()
    {
        return $this->belongsTo(SourcingSupplier::class, 'sourcing_supplier_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchase_order_supplier_item()
    {
        return $this->hasOne(PurchaseOrderSupplierItem::class, 'selected_sourcing_supplier_id', 'uuid');
    }

    public function delivery_schedule_item()
    {
        return $this->hasOne(DeliverySchedule::class, 'selected_sourcing_supplier_id', 'uuid');
    }
}
