@extends('layouts.backend.master-backend')
@section('title')
Edit Background
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <form action="{{ route('background.update',$background->id) }}" method="post" enctype="multipart/form-data">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                        <h4>Edit Background</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="background">Background</label>
                                <div class="col-md-12">
                                    <div class="file-upload text-center">
                                        <div id="background_show" class="file-upload-content">
                                            <img class="img-fluid mb-2" id="background_thumb" src="" alt="Foto" />
                                        </div>
                                        <div id="background_wrap">
                                            <input name="background" id="background" type="file" accept="image/*" style="display:none;" />
                                            <img src="{{ asset('img/bg/'.$background->path_bg_thumb) }}">
                                        </div>
                                        <div class="text-center mt-2 mb-0">
                                            <span id="image-title_background"></span>
                                        </div>
                                        <button class="btn btn-secondary btn-block mt-2" id="button_ktp" type="button" onclick="$('#background').trigger( 'click' )">Change Background</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="nama_bg">Background Name</label>
                                <input name="nama_bg" class="form-control {{ $errors->has('nama_bg') ? 'is-invalid' : '' }}" id="nama_bg" type="text" placeholder="Background Name" value="{{ $background->nama_bg }}">
                                {!! $errors->first('nama_bg', '<div class="invalid-feedback">:message</div>') !!}
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
                </div>
        </form>
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
                $('#button_ktp').html('Change background');
                $('#button_ktp').attr('class', 'btn btn-block btn-danger');
                $('#background_thumb').attr('src', e.target.result);
                $('#background_show').fadeIn(200);
                $('#image-title_background').html('file : ' + file.name);
            };
            reader.readAsDataURL(file);
        });

    });
</script>
@endpush