<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchasing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sourcing_items';
    protected $primaryKey = 'id';

    // Atribut yang dapat diisi
    protected $guarded = [];
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

    // public function quotation()
    // {
    //     return $this->belongsTo(Quotation::class, 'quotation_id');
    // }
}
