<?php

namespace App\Helpers;


class Size {

    
    public function getSize($type)
    {
        if ($type      === 'landscape') {
            $width = 1080;  //  ratio: 1.91:1
            $height = 608;
            $width_thumb = 500;
            $height_thumb = 300;
        } elseif ($type === 'portrait') {
            $width = 1080;  //  ratio: 4:5
            $height = 1350;
            $width_thumb = 300;
            $height_thumb = 400;
        } elseif ($type === 'square') {
            $width = 1080;  // ratio 1:1
            $height = 1080;
            $width_thumb = 300;
            $height_thumb = 300;
        } else {
            $width = 1080;
            $height = 1920;
            $width_thumb = 360;
            $height_thumb = 640;
        }
        $result = [
            'width' => $width,
            'height' => $height,
            'width_thumb' => $width_thumb,
            'height_thumb' => $height_thumb,
        ];

        return $result;
    }
}