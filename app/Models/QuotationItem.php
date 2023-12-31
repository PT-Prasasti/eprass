<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationItem extends Model
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

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'id', 'quotation_id');
    }

    public function inquiry_product()
    {
        return $this->belongsTo(InquiryProduct::class, 'inquiry_product_id', 'uuid');
    }
}
