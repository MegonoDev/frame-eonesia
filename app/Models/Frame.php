<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    protected $table    = 'frames';
    protected $fillable = [
        'nama_frame',
        'type_frame',
        'link_frame',
        'path_frame',
    ];
}
