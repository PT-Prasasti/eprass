<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrder extends Model
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

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    public function products()
    {
        return $this->hasMany(SalesOrderProduct::class, 'so_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'so_id');
    }
}
