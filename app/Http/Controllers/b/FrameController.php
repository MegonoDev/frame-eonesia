<?php

namespace App\Http\Controllers\b;

use App\Helpers\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Models\Frame;
use App\Http\Requests\FrameRequest;
use App\Http\Controllers\b\BackendController;
use App\Models\Background;
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
        $paths = [
            public_path() . '/img/bg',
            public_path() . '/img/frame',
            public_path() . '/img/photo',
            public_path() . '/img/result',
            public_path() . '/img/zip',
        ];
        
        foreach ($paths as $path) {
            if (!File::isDirectory($path)) File::makeDirectory($path, 0775, true, true);
        }

        $this->notification('success','Successful!','Preparation Completed.');

        return redirect()->back();
    }

    public function create()
    {
        $bcrum      = $this->bcrum('Create Frame', route('frame.index'), 'Frame');
        $backgrounds = Background::pluck('nama_bg', 'id');

        return view('backend.frame.create', compact('bcrum', 'backgrounds'));
    }

    public function store(FrameRequest $request)
    {
        $data = $this->handleRequest($request);
        $create = Frame::create($data);
        if ($create) {

        $this->notification('success','Successful!','Frame successfully added.');

            $redirect = ($request->has('stay')) ? 'frame.create' : 'frame.index';

            return redirect()->route($redirect);
        }
    }

    public function edit($id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $backgrounds = Background::pluck('nama_bg', 'id');

        $bcrum = $this->bcrum('Edit Frame', route('frame.index'), 'Frame');

        return view('backend.frame.edit', compact('frame', 'backgrounds', 'bcrum'));
    }

    public function update(Request $request, $id)
    {
        $frame    = Frame::where('link_frame', $id)->first();
        $oldFrame = $frame->path_frame;
        $oldType  = $frame->type_frame;
        $data     = $this->handleRequest($request);
        $frame->update($data);


        if ($oldFrame !== $frame->path_frame) $this->deleteImage($oldFrame);
        if ($oldType  !== $frame->type_frame) $this->resizeImage($frame);

        $this->notification('success','Successful!','Frame successfully edited.');

        return redirect()->route('frame.index');
    }

    public function show($id)
    {
        $frame = DB::table('frames')->where('link_frame', $id)->first();
        $size  = $this->size->getSize($frame->type_frame);
        $bcrum = $this->bcrum('Show Frame', route('frame.index'), 'Frame');
        return view('backend.frame.show', compact('size', 'frame', 'bcrum'));
    }

    public function destroy($id)
    {
        $frame = Frame::where('id', $id)->first();
        $this->deleteImage($frame->path_frame);
        $frame->delete();
        $this->notification('error','Successful!','Frame successfully deleted.');
        $result = [
            'result' => 'ok',
            'code'   => '200',
            'url'    => route('frame.index')
        ];

        return response()->json($result);
    }

    public function handleRequest($request)
    {
        $data        = $request->all();
        $size        = $this->size->getSize($request->type_frame);
        $slug        = ($request->link_frame != null) ? Str::slug($request->link_frame, '-') : Str::slug($request->nama_frame, '-');
        if ($request->has('frame')) {
            $frame       = $request->file('frame');
            $extension   = $frame->guessClientExtension();
            $fileName    = 'frame_' . $slug . '_' . date('dmy_His') . '.' . $extension;
            $thumbName   = "thumb_" . $fileName;
            $destination = public_path() . '/img/frame';

            Image::make($frame->getRealPath())
                ->resize($size['width'], $size['height'])
                ->save($destination . "/" . $fileName);

            Image::make($frame->getRealPath())
                ->resize($size['width_thumb'], $size['height_thumb'])
                ->save($destination . "/" . $thumbName);

            $data['link_frame']       = $slug;
            $data['path_frame']       = $fileName;
            $data['path_frame_thumb'] = $thumbName;
        }
        return $data;
    }

    public function resizeImage($frame)
    {
        $size           = $this->size->getSize($frame->type_frame);
        $imagePath      = public_path() . '/img/frame/' . $frame->path_frame;
        $imageThumbPath = public_path()  . '/img/frame/thumb_' . $frame->path_frame;
        $image          = Image::make($imagePath);
        $imageThumb     = Image::make($imageThumbPath);
        $result[]       = $imageThumb->resize($size['width_thumb'], $size['height_thumb'])->save($imageThumbPath);
        $result[]       = $image->resize($size['width'], $size['height'])->save($imagePath);

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
