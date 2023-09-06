<?php

namespace App\Models;

use App\Events\NotifEvent;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitReport extends Model
{
    use HasFactory, SoftDeletes;
    
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

    public function visit()
    {
        return $this->belongsTo(VisitSchedule::class, 'visit_schedule_id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
}
