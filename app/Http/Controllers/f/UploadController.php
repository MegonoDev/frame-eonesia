<?php

namespace App\Http\Controllers\f;

use App\Http\Controllers\f\FrontendController;
use App\Models\Frame;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Size;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\File;

class UploadController extends FrontendController
{

    public function __construct()
    {
        $this->size = new Size;
        $this->pathDownload = public_path().'/img/result';
        $this->pathStream = 'img/result';
    }
    public function upload($id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $size = $this->size->getSize($frame->type_frame);
        return view('frontend.upload.upload', compact('size', 'frame'));
    }

    public function store(Request $request, $id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $saveResultPath  =  public_path() . '/img/result';
        $savePhotoPath  =  public_path() . '/img/photo';
        $size = $this->size->getSize($frame->type_frame);
        if ($request->has('image')) {
            $image_array_1 = explode(";", $request->image);
            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]); //data foto saja
            $fileName = time() . '.png';
            // $destinationPhoto = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR
            //     . $frame->link_frame . DIRECTORY_SEPARATOR . 'base';
            $destinationPhoto = $saveResultPath;
            Image::make($data)
                ->resize($size['width'], $size['height'])->save($destinationPhoto . "/" . $fileName);
            //proses framewatermark
            $uploadgambar = $destinationPhoto . DIRECTORY_SEPARATOR . $fileName; //destinationResult
            $frameImage        = public_path() . '/img/frame' . DIRECTORY_SEPARATOR . $frame->path_frame;
            // $namabaru = $fileName;

            // Menetapkan nama thumbnail

            $thumbnail = $uploadgambar;
            // $actual = $destinationResult . $namabaru;
            // $namagbr = $frame->link_frame.'_' . $namabaru;


            $source = imagecreatefrompng($uploadgambar);
            // Memuat gambar watermark
            $watermark = imagecreatefrompng($frameImage);
            // mendapatkan lebar dan tinggi dari gambar watermark
            $water_width = imagesx($watermark);
            $water_height = imagesy($watermark);

            // mendapatkan lebar dan tinggi dari gambar utama
            // $main_width = imagesx($source);
            // $main_height = imagesy($source);

            // Menetapkan posisi gambar watermark
            $dime_x = 0;
            $dime_y = 0;

            // menyalin kedua gambar
            imagecopy($source, $watermark, $dime_x, $dime_y, 0, 0, $water_width, $water_height);

            // pemrosesan akhir, Membuat gambar baru dengan nama file baru
            imagejpeg($source, $thumbnail, 300);
            $result = [
                'result'   => 'ok',
                'code'     => '200',
                'image'    => URL::asset($this->pathStream. DIRECTORY_SEPARATOR . $fileName),
                'download' => route('download', $fileName)
            ];

            return response()->json($result);
        }
    }
    public function download($id)
    {
        $file = $this->pathDownload.DIRECTORY_SEPARATOR.$id;
        $headers = array('Content-Type: image/png',);
        return response()->download($file, 'event_'.$id,$headers);
    }

}
