<?php

namespace App\Http\Controllers\b;

use App\Helpers\Size;
use App\Http\Controllers\b\BackendController;
use App\Models\Photo;
use Illuminate\Http\Request;
use File;

class PhotoController extends BackendController
{
    public function __construct()
    {
        $this->size = new Size;
    }
    /**
     * Display a listing of the resource.\
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->paginate($this->limit);

        $bcrum  = $this->bcrum('Photo');
        return view('backend.photo.index',compact('photos','bcrum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = Photo::findOrFail($id);
        $bcrum = $this->bcrum('Photo Detail',route('photo.index'),'Photo');
        $size  = $this->size->getSize($photo->frame->type_frame);

        return view('backend.photo.show',compact('photo','bcrum','size'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::where('id', $id)->first();
        $this->deletePhoto($photo->path_photo,'img/photo');
        $this->deletePhoto($photo->path_result,'img/result');
        $photo->delete();
        $this->notification('error','Successful!','Image successfully deleted.');
        $result = [
            'result' => 'ok',
            'code'   => '200',
            'url'    => route('photo.index')
        ];

        return response()->json($result);
    }

    public function downloadPhoto($id)
    {
        $file = public_path() . '/img/photo/' . $id;
        $headers = array('Content-Type: image/png',);
        return response()->download($file, 'original_' . $id, $headers);
    }
    public function deletePhoto($filename,$folder)
    {
        $path = public_path() . DIRECTORY_SEPARATOR . $folder
            . DIRECTORY_SEPARATOR . $filename;
        $thumbnail = public_path() . DIRECTORY_SEPARATOR . $folder
            . DIRECTORY_SEPARATOR . 'thumb_' . $filename;

        return File::delete($path, $thumbnail);
    }
    
}
