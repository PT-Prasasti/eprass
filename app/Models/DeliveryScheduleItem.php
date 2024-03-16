<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryScheduleItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function delivery_schedule()
    {
        return $this->belongsTo(DeliverySchedule::class, 'delivery_schedule_id', 'id');
    }

    public function selected_sourcing_supplier()
    {
        return $this->belongsTo(SelectedSourcingSupplier::class, 'selected_sourcing_supplier_id', 'uuid');
    }
}
