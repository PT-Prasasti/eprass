<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use HasFactory;

class BTB extends Model
{

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
