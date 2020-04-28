<?php

namespace App\Helpers;


class Size
{


    public function getSize($type, $bg = false)
    {
        switch ($type) {
            case 'landscape':
                $width = 1080;  //  ratio: 1.91:1
                $height = 608;
                $width_thumb = 500;
                $height_thumb = 300;
                break;
            case 'portrait':
                $width = 1080;  //  ratio: 4:5
                $height = 1350;
                $width_thumb = 300;
                $height_thumb = 400;
                break;
            case 'square':
                $width = 1080;  // ratio 1:1
                $height = 1080;
                $width_thumb = 300;
                $height_thumb = 300;
                break;

            default:
                $width = 1080;
                $height = 1920;
                $width_thumb = 300;
                $height_thumb = 546;
                break;
        }
        $result = [
            'width' => $width,
            'height' => $height,
            'width_thumb' => $width_thumb,
            'height_thumb' => $height_thumb,
        ];
        if ($bg) {
            $result['bg'] = 'assets/img/default-' . $type . '.png';
        }

        return $result;
    }
}
