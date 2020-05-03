<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Frame;

class Background extends Model
{
    protected $table    = 'backgrounds';
    protected $fillable = [
        'nama_bg',
        'type_bg',
        'path_bg',
        'primary_color_bg',
        'secondary_color_bg'
    ];

    public function frames()
    {
        return $this->hasMany(Frame::class, 'id_bg');
    }
}
