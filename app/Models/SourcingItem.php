<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcingItem extends Model
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

    public function inquiry_product()
    {
        return $this->belongsTo(InquiryProduct::class, 'inquiry_product_id');
    }

    public function sourcing_supplier()
    {
        return $this->belongsTo(SourcingSupplier::class, 'sourcing_supplier_id');
    }
}
