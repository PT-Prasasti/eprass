<?php

namespace App\Models;

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
        'is_warning'
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


    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'uuid');
    }

    public function quotation_items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
