<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcingSupplier extends Model
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

    public function selected_sourcing_suppliers()
    {
        return $this->hasMany(SelectedSourcingSupplier::class, 'sourcing_supplier_id');
    }

    public function sourcing_items()
    {
        return $this->hasMany(SourcingItem::class, 'sourcing_supplier_id');
    }

    public function sourcing_items_single()
    {
        return $this->hasOne(SourcingItem::class, 'sourcing_supplier_id');
    }

    public function inquiry_product()
    {
        return $this->belongsTo(InquiryProduct::class, 'inquiry_product_id', 'id');
    }
}
