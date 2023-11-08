<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderCustomer extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $appends = [
        'transaction_due_date'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function getTransactionDueDateAttribute(): string
    {
        $dueDate = '';
        if ($this->quotation && $this->quotation->quotation_items->count() > 0) {
            foreach ($this->quotation->quotation_items as $item) {
                if ($item->max_delivery_time_of_purchase_order_customer && ($dueDate === '' || $dueDate > $item->max_delivery_time_of_purchase_order_customer)) {
                    $dueDate = $item->max_delivery_time_of_purchase_order_customer;
                }
            }
        }

        return $dueDate;
    }
}
