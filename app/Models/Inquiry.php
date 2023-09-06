<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;
    
    public $incrementing = false;

    protected $primaryKey = 'id';

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

    public function visit()
    {
        return $this->belongsTo(VisitSchedule::class, 'visit_schedule_id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function products()
    {
        return $this->hasMany(InquiryProduct::class, 'inquiry_id');
    }

    public function sales_order()
    {
        return $this->hasOne(SalesOrder::class, 'inquiry_id');
    }
}
