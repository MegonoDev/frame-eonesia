@extends('layouts.backend.master-backend')
@section('title')
Edit Frame
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <form action="{{ route('frame.update',$frame->link_frame) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-7 col-sm-12 col-lg-7">
                    <div class="card">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="card-header">
                            <h4>Edit Frame</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="frame">Frame</label>
                                    <div class="col-md-12">
                                        <div class="file-upload text-center">
                                            <div id="frame_show" class="file-upload-content">
                                                <img class="img-fluid mb-2" id="frame_thumb" src="" alt="Foto" />
                                            </div>
                                            <div id="frame_wrap">
                                                <input name="frame" id="frame" type="file" accept="image/*" style="display:none;" />
                                                <img src="{{ asset('img/frame/thumb_'.$frame->path_frame) }}">
                                            </div>
                                            <div class="text-center mt-2 mb-0">
                                                <span id="image-title_frame"></span>
                                            </div>
                                            <button class="btn btn-secondary btn-block mt-2" id="button_frame" type="button" onclick="$('#frame').trigger( 'click' )">Change Frame</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 col-sm-12 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Frame Detail</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="type_frame">Frame Type</label>
                                    <div class="form-inline">
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" class="custom-control-input" id="type_frame_square" name="type_frame" value="square" {{ ($frame->type_frame === 'square') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_frame_square">Square</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" class="custom-control-input" id="type_frame_portrait" name="type_frame" value="portrait" {{ ($frame->type_frame === 'portrait') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_frame_portrait">Portrait</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" class="custom-control-input" id="type_frame_landscape" name="type_frame" value="landscape" {{ ($frame->type_frame === 'landscape') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_frame_landscape">Landscape</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" class="custom-control-input" id="type_frame_story" name="type_frame" value="story" {{ ($frame->type_frame === 'story') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_frame_story">Story Instagram</label>
                                        </div>
                                    </div>
                                    {!! $errors->first('type_frame', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="id_bg">Background</label>
                                    {{
                                    Form::select('id_bg', 
                                    [   ''             => '-- Choose Background --',]+
                                        $backgrounds->toArray(),
                                     $frame->id_bg,
                                     [
                                        'class' => "form-control $errors->has('id_bg') ? 'is-invalid' : '')",
                                        'id'    => 'id_bg'
                                        ]
                                        )
                                }}
                                    {!! $errors->first('id_bg', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="nama_frame">Name or Title</label>
                                    <input name="nama_frame" class="form-control {{ $errors->has('nama_frame') ? 'is-invalid' : '' }}" id="nama_frame" type="text" placeholder="Frame Name" value="{{ $frame->nama_frame }}">
                                    {!! $errors->first('nama_frame', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="link_frame">Custom Slug</label>
                                    <input name="link_frame" class="form-control {{ $errors->has('link_frame') ? 'is-invalid' : '' }}" id="link_frame" type="text" placeholder="Custom Slug" value="{{ $frame->link_frame }}">
                                    <p class="help-block">this will create url {{ env('APP_URL') }}/frame/<span class="text-danger">[your-custom-slug]</span></p>
                                    {!! $errors->first('link_frame', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('frame.index') }}" class="btn mx-2 btn-outline-dark">
                                        <i class="c-icon cil-chevron-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn  btn-primary">
                                        <i class="c-icon cil-check"></i> Save
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/lib/croppie/croppie.css') }}">
<style>
    .file-upload {
        background-color: #ffffff;
        margin: 0 auto;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .upload-hidden {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 2em;
        border: 1px dashed rgb(38, 155, 209);
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        /* background-color: rgb(194, 236, 255); */
        border: 1px dashed #000;
        /* color: rgb(255, 255, 255); */
    }

    .image-upload-wrap h3 {
        font-weight: 100;
        text-align: center;
        text-transform: uppercase;
        color: rgb(15, 117, 235);
        padding-top: 0.5em;
        padding-left: 3em;
        padding-right: 3em;
        padding-bottom: 0.5em;
    }


    .file-upload-image {
        max-height: 230px;
        max-width: 230px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        /* border-radius: 4px; */
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/lib/croppie/exif.js') }}"></script>
<script src="{{ asset('assets/lib/croppie/croppie.js') }}"></script>

<script>
    $(document).ready(function() {

        $('#frame').change(function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#frame_wrap').hide();
                $('#button_frame').html('Change Frame');
                $('#button_frame').attr('class', 'mt-2 btn btn-outline-dark btn-block');
                $('#frame_thumb').attr('src', e.target.result);
                $('#frame_show').fadeIn(200);
                $('#image-title_frame').html('file : ' + file.name);
            };
            reader.readAsDataURL(file);
        });

    });
</script>
@endpush