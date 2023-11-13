<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderSupplierItem extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function purchase_order_supplier()
    {
        return $this->belongsTo(PurchaseOrderSupplier::class);
    }

    public function selected_sourcing_supplier()
    {
        return $this->belongsTo(SelectedSourcingSupplier::class, 'selected_sourcing_supplier_id', 'uuid');
    }
}
