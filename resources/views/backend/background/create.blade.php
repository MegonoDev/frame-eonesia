@extends('layouts.backend.master-backend')
@section('title')
Create Background
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
                <form action="{{ route('background.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Create Background</h4>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="nama_bg">Background Name</label>
                                <input name="nama_bg" class="form-control {{ $errors->has('nama_bg') ? 'is-invalid' : '' }}" id="nama_bg" type="text" placeholder="Background Name">
                                {!! $errors->first('nama_bg', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="background">Background Image</label>
                                <small class="help-block">(.png file extension)</small>
                                <div class="col-md-8">
                                    <div class="file-upload">
                                        <div class="text-center mb-0">
                                            <span id="image-title_background"></span>
                                        </div>
                                        <div class="image-upload-wrap" id="background_wrap">
                                            <input name="background" id="background" class="upload-hidden" type='file' accept="image/*" />
                                            <h3>DRAG</h3>
                                            <div class="text-center">
                                                OR
                                            </div>
                                            <h3>CLICK HERE</h3>
                                        </div>
                                        <div id="background_show" class="file-upload-content">
                                            <img class="file-upload-image" id="background_thumb" src="#" alt="Foto" />
                                            <button class="btn btn-danger btn-block mt-3" id="button_bg" type="button" style="border-radius:0;" onclick="$('#background').trigger( 'click' )">Ganti Foto</button>
                                        </div>
                                    </div>
                                    {!! $errors->first('background', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn  btn-outline-primary">
                                    <i class="c-icon cil-check"></i> Save
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
<link rel="stylesheet" href="{{ asset('assets/css/upload.css') }}">
@endpush

@push('scripts')

<script>
    $(document).ready(function() {

        $('#background').change(function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#background_wrap').hide();
                $('#button_bg').html('Change background');
                $('#button_bg').attr('class', 'btn btn-block btn-danger');
                $('#background_thumb').attr('src', e.target.result);
                $('#background_show').fadeIn(200);
                $('#image-title_background').html('file : ' + file.name);
            };
            reader.readAsDataURL(file);
        });

    });
</script>
@endpush