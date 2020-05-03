<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Frame extends Model
{
    protected $table    = 'frames';
    protected $fillable = [
        'nama_frame',
        'type_frame',
        'link_frame',
        'path_frame',
        'path_frame_thumb',
        'id_bg',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function backgrounds()
    {
        return $this->belongsTo(Background::class);
    }
}
