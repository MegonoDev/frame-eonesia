<?php

namespace App\Http\Controllers\b;

use App\Http\Controllers\b\BackendController;
use App\Models\Photo;
use App\Models\Frame;
use Illuminate\Http\Request;
use ZipArchive;

class ResultController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $bcrum  = $this->bcrum('Result', route('frame.index'), 'Frame');
        $photos = Photo::where('id_frame', $id)->get();
        $frame  = Frame::findOrFail($id);

        return view('backend.frame.result', compact('bcrum', 'photos', 'frame'));
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
    { }

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
        //
    }

    public function download($id, $name)
    {
        $photos  = Photo::where('id_frame', $id)->get();
        $zipName = $name . '.zip';
        $path    = public_path() . DIRECTORY_SEPARATOR . 'img/result';
        $pathZip = public_path() . DIRECTORY_SEPARATOR . 'img/zip';
        $headers = ['Content-Type' => 'application/octet-stream'];

        $zip = new ZipArchive();
        $zip->open($pathZip . DIRECTORY_SEPARATOR . $zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        foreach ($photos as $photo) {
            $zip->addFile($path . DIRECTORY_SEPARATOR . $photo->path_result,$photo->path_result);
        }

        $zip->close();

        
        return response()->download($pathZip.DIRECTORY_SEPARATOR.$zipName,$zipName,$headers);
    }
}
