@extends('layouts.backend.master-backend')
@section('title')
Create Frame
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
                <form action="{{ route('frame.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Create Frame</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="frame">Frame</label>
                                <div class="col-md-8">
                                    <div class="file-upload">
                                        <div class="text-center mb-0">
                                            <span id="image-title_frame"></span>
                                        </div>
                                        <div class="image-upload-wrap" id="frame_wrap">
                                            <input name="frame" id="frame" class="upload-hidden" type='file' accept="image/png" />
                                            <h3>DRAG</h3>
                                            <div class="text-center">
                                                OR
                                            </div>
                                            <h3>CLICK HERE</h3>
                                        </div>
                                        <div id="frame_show" class="file-upload-content">
                                            <img class="file-upload-image" id="frame_thumb" src="#" alt="Foto" />
                                            <button class="btn btn-danger btn-block mt-3" id="button_ktp" type="button" style="border-radius:0;" onclick="$('#frame').trigger( 'click' )">Ganti Foto</button>
                                        </div>
                                    </div>
                                    {!! $errors->first('frame', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="type_frame">Frame Type</label>
                                <div class="form-inline">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_frame_square" name="type_frame" value="square">
                                        <label class="custom-control-label" for="type_frame_square">Square</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_frame_portrait" name="type_frame" value="portrait">
                                        <label class="custom-control-label" for="type_frame_portrait">Portrait</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_frame_landscape" name="type_frame" value="landscape">
                                        <label class="custom-control-label" for="type_frame_landscape">Landscape</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_frame_story" name="type_frame" value="story">
                                        <label class="custom-control-label" for="type_frame_story">Story Instagram</label>
                                    </div>
                                </div>
                                {!! $errors->first('type_frame', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="nama_frame">Name</label>
                                <input name="nama_frame" class="form-control {{ $errors->has('nama_frame') ? 'is-invalid' : '' }}" id="nama_frame" type="text" placeholder="Frame Name">
                                {!! $errors->first('nama_frame', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="link_frame">Custom Slug</label>
                                <input name="link_frame" class="form-control {{ $errors->has('link_frame') ? 'is-invalid' : '' }}" id="link_frame" type="text" placeholder="Custom Slug">
                                <p class="help-block">this will create url {{ env('APP_URL') }}/frame/<span class="text-danger">[your-custom-slug]</span></p>
                                {!! $errors->first('link_frame', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn  btn-outline-primary">
                                    <i class="c-icon cil-check"></i> Save
                                </button>

                                <button type="submit" name="stay" class="btn btn-primary mx-3">
                                    <i class="c-icon cil-check"></i> Save and create another
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
                $('#button_ktp').html('Change Frame');
                $('#button_ktp').attr('class', 'btn btn-block btn-danger');
                $('#frame_thumb').attr('src', e.target.result);
                $('#frame_show').fadeIn(200);
                $('#image-title_frame').html('file : ' + file.name);
            };
            reader.readAsDataURL(file);
        });

    });
</script>
@endpush