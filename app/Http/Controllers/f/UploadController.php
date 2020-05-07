<?php

namespace App\Http\Controllers\f;

use App\Http\Controllers\f\FrontendController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Size;
use App\Models\Frame;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use App\Models\Photo;

class UploadController extends FrontendController
{

    public function __construct()
    {
        $this->size = new Size;
    }
    public function upload($id)
    {
        $frame = Frame::where('link_frame', $id)->first();
        $size = $this->size->getSize($frame->type_frame, true);
        return view('frontend.upload.upload', compact('size', 'frame'));
    }

    public function store(Request $request)
    {
        if (!$request->has('image')) return redirect()->route('welcome');
        $data = $this->handleRequest($request);
        Photo::create($data);
        $result = [
            'result'   => 'ok',
            'code'     => '200',
            'image'    => URL::asset($this->pathResult . DIRECTORY_SEPARATOR . $data['path_result']),
            'download' => route('download', $data['path_result'])
        ];

        return response()->json($result);
    }
    public function handleRequest($request)
    {
        $frame             = DB::table('frames')->where('link_frame', $request->frame)->first();
        if (!$frame) return $this->gagalInput();
        $size              = $this->size->getSize($frame->type_frame);
        $destinationResult =  public_path() . '/img/result/';
        $destinationPhoto  =  public_path() . '/img/photo/';
        $imageArray1       = explode(";", $request->image);
        $imageArray2       = explode(",", $imageArray1[1]);
        $dataImage         = base64_decode($imageArray2[1]);
        $resultName        = 'result_' . time() . '.png';
        $photoName         = 'photo_'  . time() . '.png';
        $uploadPhoto       = $destinationPhoto . $photoName;
        $uploadPhotoThumb  = $destinationPhoto . 'thumb_' . $photoName;
        $uploadResult      = $destinationResult . $resultName;
        $uploadResultThumb = $destinationResult . 'thumb_' . $resultName;
        $frameImage        = public_path() . '/img/frame/' . $frame->path_frame;
        //simpan foto asli
        Image::make($dataImage)->resize($size['width'], $size['height'])->save($uploadPhoto);
        //simpan foto asli thumb
        Image::make($dataImage)->resize($size['width_thumb'], $size['height_thumb'])->save($uploadPhotoThumb);
        //simpan hasil insert frame
        $img = Image::make($dataImage)->resize($size['width'], $size['height']);
        $img->insert($frameImage, 'center', 0, 0)->save($uploadResult);
        //simpan hasil insert frame thumb
        Image::make($uploadResult)->resize($size['width_thumb'], $size['height_thumb'])->save($uploadResultThumb);

        $data = [
            'path_photo'        => $photoName,
            'path_photo_thumb'  => 'thumb_' . $photoName,
            'path_result'       => $resultName,
            'path_result_thumb' => 'thumb_' . $resultName,
            'id_frame'          => $frame->id,
        ];
        return $data;
    }
    public function download($id)
    {
        $file = public_path() . DIRECTORY_SEPARATOR . $this->pathResult . DIRECTORY_SEPARATOR . $id;
        $headers = array('Content-Type: image/png',);
        return response()->download($file, 'event_' . $id, $headers);
    }

    public function gagalInput()
    {
        return response()->json(['result' => 'failed', 'code' => '400']);
    }
}
