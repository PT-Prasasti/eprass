<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use App\Events\NotifEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitSchedule extends Model
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
        event(new NotifEvent('New data is added'));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
}
