<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentRequestExim extends Model
{
    use HasFactory, SoftDeletes;


    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function payment_request_item() : HasMany
    {
        return $this->hasMany(PaymentRequestItem::class, 'payment_request_id');
    }
}
