<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Frame;

class Photo extends Model
{
    protected $table    = 'photos';
    protected $fillable = [
        'path_photo',
        'path_photo_thumb',
        'path_result',
        'path_result_thumb',
        'id_frame',
    ];

    public function frame()
    {
       return $this->belongsTo(Frame::class,'id_frame');
    }
}
