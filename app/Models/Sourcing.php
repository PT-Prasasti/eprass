<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sourcing extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function sourcing_supplier()
    {
        return $this->hasMany(SourcingSupplier::class, 'sourcing_id');
    }

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'so_id', 'id');
    }
}
