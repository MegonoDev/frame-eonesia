<?php

namespace App\Http\Controllers\f;

use App\Http\Controllers\f\FrontendController;
use App\Models\Frame;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Size;

class UploadController extends FrontendController
{

    public function __construct()
    {
        $this->size = new Size;
    }
    public function upload($id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $size = $this->size->getSize($frame->type_frame);
        return view('frontend.upload.upload',compact('size','frame'));
    }

    public function store(Request $request,$id)
    {
       
        //upload.php
        
        if(isset($_POST["image"]))
        {
         $data = $_POST["image"];
        
         $image_array_1 = explode(";", $data);
        
         $image_array_2 = explode(",", $image_array_1[1]);
        
         $data = base64_decode($image_array_2[1]);
        
         $imageName = time() . '.png';
        
         file_put_contents('upload/'.$imageName, $data);
        
         
        //proses framewa/termark
        $folder = "upload/";
        $uploadgambar=$folder.$imageName;
        $namabaru=$imageName;
        
        // Menetapkan nama thumbnail
        
        $thumbnail = $folder."event_".$namabaru;
        $actual = $folder.$namabaru;
        $namagbr="event_".$namabaru;
        
        
        $source = imagecreatefrompng($uploadgambar);
        // Memuat gambar watermark
        $watermark = imagecreatefrompng('watermark/frame-final-instagram.png');
        // mendapatkan lebar dan tinggi dari gambar watermark
        $water_width = imagesx($watermark);
        $water_height = imagesy($watermark);
        
        // mendapatkan lebar dan tinggi dari gambar utama
        $main_width = imagesx($source);
        $main_height = imagesy($source);
        
        // Menetapkan posisi gambar watermark
        $dime_x = 0;
        $dime_y = 0;
        
        // menyalin kedua gambar
        imagecopy($source, $watermark, $dime_x, $dime_y, 0, 0, $water_width, $water_height);
        
        // pemrosesan akhir, Membuat gambar baru dengan nama file baru
        imagejpeg($source, $thumbnail, 300);
        echo '<a href="download.php?file='.'event_'.$imageName.'"><img src="'.$thumbnail.'" class="img-thumbnail" /></a><div> <a href="download.php?file='.'event_'.$imageName.'"><span class="btn btn-warning">Download</span></a> <a href="index.html"><span class="btn btn-danger">Replay</span></a></div>'; 
        
         
        }        
    }

}
