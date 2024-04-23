<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use HasFactory;

class BTB extends Model
{

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function purchase_order_supplier()
    {
        return $this->belongsTo(PurchaseOrderSupplier::class, 'purchase_order_supplier_id');
    }
}
