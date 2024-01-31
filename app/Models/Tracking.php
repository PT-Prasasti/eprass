<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Tracking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }


    public function forwarder_item()
    {
        return $this->hasMany(ForwarderItem::class);
    }
    
    public function purchase_order_suppliers()
    {
        return $this->belongsTo(PurchaseOrderSupplier::class, 'po_suplier_id',);
    }
}
