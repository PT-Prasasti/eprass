<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwarderItem extends Model
{
    use HasFactory;


    protected $fillable = [
        'tracking_id',
        'forwarder_id',
        'price',
        'track',
        'description'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'tracking_id');
    }
}
