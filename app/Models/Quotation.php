<?php

namespace App\Models;

use App\Constants\PaymentTermConstant;
use App\Constants\VatTypeConstant;
use DateTime;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $appends = [
        'is_warning',
        'can_be_recreated',
        'vat_string',
        'payment_term_string',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getIsWarningAttribute(): bool
    {
        if ($this->status != 'Waiting for Approval') {
            return false;
        }

        $dueDate = new DateTime($this->due_date);
        $today = new DateTime(date('Y-m-d'));
        $diff = $today->diff($dueDate);

        if ($diff->d < 7) {
            return true;
        }

        return false;
    }

    public function getCanBeRecreatedAttribute(): bool
    {
        $lastQuotation = Quotation::query()->whereSalesOrderId($this->sales_order_id)->latest('created_at')->first();
        if ($lastQuotation->id === $this->id) {
            if ($this->status === 'Done' || $this->status === 'Waiting for Approval' || $this->status === 'Revision') {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    public function getVatStringAttribute(): string
    {
        $constant = VatTypeConstant::texts();
        return @$constant[$this->vat] ?? '';
    }

    public function getPaymentTermStringAttribute(): string
    {
        $constant = PaymentTermConstant::texts();
        return @$constant[$this->payment_term] ?? '';
    }

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'uuid');
    }

    public function quotation_items()
    {
        return $this->hasMany(QuotationItem::class);
    }


    public function purchase_order_customer()
    {
        return $this->hasOne(PurchaseOrderCustomer::class);
    }
}
