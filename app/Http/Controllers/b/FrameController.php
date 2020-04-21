<?php

namespace App\Http\Controllers\b;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Models\Frame;

use App\Http\Controllers\b\BackendController;
use Illuminate\Http\Request;

class FrameController extends BackendController
{
    public function index()
    {
        $bcrum = $this->bcrum('Frame');

        return view('backend.frame.index', compact('bcrum'));
    }

    public function create()
    {
        $bcrum = $this->bcrum('Create Frame', route('frame.index'), 'Frame');

        return view('backend.frame.create', compact('bcrum'));
    }

    public function store(Request $request)
    {
        $data = $this->handleRequest($request);

        $create = Frame::create($data);
        if ($create) {

            Session::flash('flash_notification', [
                'title' => 'Successful!',
                'level' => 'success',
                'message' => 'Frame successfully added.'
            ]);

            if ($request->has('stay')) {
                $redirect = 'frame.create';
            } else {
                $redirect = 'frame.index';
            }

            return redirect()->route($redirect);
        }
    }

    public function handleRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('frame')) {

            if ($request->type_frame      === 'landscape') {
                $width = 1080;  //  ratio: 1.91:1
                $height = 608;
                $width_thumb = 500;
                $height_thumb = 300;
            } elseif ($request->type_frame === 'portrait') {
                $width = 1080;  //  ratio: 4:5
                $height = 1350;
                $width_thumb = 300;
                $height_thumb = 400;
            } elseif ($request->type_frame === 'square') {
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
            if ($request->has('link_frame')) {
                $slug = Str::slug($request->link_frame, '-');
            } else {
                $slug =  Str::slug($request->nama_frame, '-');
            }
            $frame       = $request->file('frame');
            $extension   = $frame->guessClientExtension();
            $fileName    = 'frame_' . $slug . '.' . $extension;
            $destination = public_path() . '/img/frame';
            $data['link_frame'] = $slug;

            $upload = Image::make($frame->getRealPath())
                ->resize($width, $height)->save($destination . "/" . $fileName);

            if ($upload) {

                $thumbnail = "thumb_" . $fileName;
                Image::make($frame->getRealPath())
                    ->resize($width_thumb, $height_thumb)
                    ->save($destination . "/" . $thumbnail);
            }
            $data['path_frame'] = $fileName;
            return $data;
        }
    }
}
