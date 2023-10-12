<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SourchingItems extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "sourcing_items";

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        
    }
}
