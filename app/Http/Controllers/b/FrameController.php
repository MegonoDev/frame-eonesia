<?php

namespace App\Http\Controllers\b;

use App\Helpers\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Models\Frame;
use App\Http\Requests\FrameRequest;
use App\Http\Controllers\b\BackendController;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;

class FrameController extends BackendController
{

    public function __construct()
    {
        $this->size = new Size;
    }
    public function index()
    {
        $bcrum = $this->bcrum('Frame');

        $frames = Frame::paginate(15);
        return view('backend.frame.index', compact('bcrum', 'frames'));
    }

    public function prepare()
    {
        $paths = [public_path() . '/img/photo', public_path() . '/img/frame'];
        foreach ($paths as $path) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }

        Session::flash('flash_notification', [
            'title' => 'Successful!',
            'level' => 'success',
            'message' => 'Preparation Completed'
        ]);

        return redirect()->route('frame.index');
    }

    public function create()
    {
        $bcrum = $this->bcrum('Create Frame', route('frame.index'), 'Frame');

        return view('backend.frame.create', compact('bcrum'));
    }

    public function store(FrameRequest $request)
    {
        $data = $this->handleRequest($request);
        $create = Frame::create($data);
        if ($create) {
            $path = public_path() . '/img/result';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
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

    public function edit($id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();

        $bcrum = $this->bcrum('Edit Frame', route('frame.index'), 'Frame');

        return view('backend.frame.edit', compact('frame', 'bcrum'));
    }

    public function update(Request $request, $id)
    {
        $frame = Frame::where('link_frame', $id)->first();
        $oldFrame = $frame->path_frame;
        $oldType = $frame->type_frame;
        $data = $this->handleRequest($request);
        $frame->update($data);


        if ($oldFrame !== $frame->path_frame) {

            $this->deleteImage($oldFrame);
        }
        if ($oldType !== $frame->type_frame) {
            $this->resizeImage($frame);
        }

        Session::flash('flash_notification', [
            'title' => 'Successful!',
            'level' => 'success',
            'message' => 'Frame successfully edited.'
        ]);

        return redirect()->route('frame.index');
    }

    public function show($id)
    {

        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $size = $this->size->getSize($frame->type_frame);
        $bcrum = $this->bcrum('Show Frame', route('frame.index'), 'Frame');
        return view('backend.frame.show', compact('size', 'frame', 'bcrum'));
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
            $fileName    = 'frame_' . $slug . '_' . date('dmy_His') . '.' . $extension;
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
        }

        return $data;
    }

    public function resizeImage($frame)
    {
        if ($frame->type_frame      === 'landscape') {
            $width = 1080;  //  ratio: 1.91:1
            $height = 608;
            $width_thumb = 500;
            $height_thumb = 300;
        } elseif ($frame->type_frame === 'portrait') {
            $width = 1080;  //  ratio: 4:5
            $height = 1350;
            $width_thumb = 300;
            $height_thumb = 400;
        } elseif ($frame->type_frame === 'square') {
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
        $imagePath = public_path() . DIRECTORY_SEPARATOR . 'img/frame'
            . DIRECTORY_SEPARATOR . $frame->path_frame;

        $imageThumbPath = public_path() . DIRECTORY_SEPARATOR . 'img/frame'
            . DIRECTORY_SEPARATOR . 'thumb_' . $frame->path_frame;
        $image = Image::make($imagePath);
        $imageThumb = Image::make($imageThumbPath);
        $result[] = $imageThumb->resize($width_thumb, $height_thumb)->save($imageThumbPath);
        $result[] = $image->resize($width, $height)->save($imagePath);

        return $result;
    }
    public function deleteImage($filename)
    {
        $path = public_path() . DIRECTORY_SEPARATOR . 'img/frame'
            . DIRECTORY_SEPARATOR . $filename;
        $thumbnail = public_path() . DIRECTORY_SEPARATOR . 'img/frame'
            . DIRECTORY_SEPARATOR . 'thumb_' . $filename;

        return File::delete($path, $thumbnail);
    }
}
