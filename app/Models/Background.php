<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Frame;

class Background extends Model
{
    protected $table    = 'backgrounds';
    protected $fillable = [
        'nama_bg',
        'path_bg',
        'path_bg_thumb'
    ];

    public function frames()
    {
        return $this->hasMany(Frame::class, 'id_bg');
    }
}
