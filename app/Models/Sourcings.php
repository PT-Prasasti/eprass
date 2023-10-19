<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Sourcings extends Model
{
    use HasFactory;

    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function selected_sourcing_suppliers()
    {
        return $this->hasMany(SelectedSourcingSupplier::class, 'sourcing_id', 'id');
    }
}
