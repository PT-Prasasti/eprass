<?php

namespace App\Models;

use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRequest extends Model
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
}
