<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InquiryProduct extends Model
{
    use HasFactory, SoftDeletes;

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $appends = [
        'quantity'
    ];

    public function getQuantityAttribute(): int
    {
        $totalQty = 0;
        $this->sourcing_items->map(function ($item) use ($totalQty) {
            $supplier = SourcingSupplier::where('id', $item->sourcing_supplier_id)->first();

            if ($supplier) {
                return $totalQty += $supplier->qty;
            };
        });

        return $totalQty;
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    public function sourcing_items()
    {
        return $this->hasMany(SourcingItem::class, 'inquiry_product_id');
    }
}
