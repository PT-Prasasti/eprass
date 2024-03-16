<?php

namespace App\Models;

use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderSupplier extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'document_list' => 'array'
    ];

    protected $appends = [
        'vat_to_text',
        'payment_term_to_text',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getVatToTextAttribute(): string
    {
        $constant = VatTypeConstant::texts();
        return @$constant[$this->vat] ?? '';
    }

    public function getPaymentTermToTextAttribute(): string
    {
        $constant = PaymentTermConstant::texts();
        return @$constant[$this->payment_term] ?? '';
    }

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'id');
    }
    

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'uuid');
    }

    public function purchase_order_supplier_items()
    {
        return $this->hasMany(PurchaseOrderSupplierItem::class);
    }
    
    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }

    public function delivery_schedule()
    {
        return $this->belongsTo(DeliverySchedule::class);
    }
    
}
