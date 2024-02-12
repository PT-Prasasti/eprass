<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentes extends Model
{
    use HasFactory,SoftDeletes;

    public static function getDocuments($table, $id)
    {
        return Documentes::where([
            ["related_table", $table],
            ["related_id", $id],
        ])->get()->map(function($v){
            return [
                'id' => $v->id,
                'type' => $v->file_type,
                'size' => $v->file_size,
                'name' => $v->filename,
                'path' => $v->path,
                'time_ago' => $v->created_at
            ];
        });
    }
}
 