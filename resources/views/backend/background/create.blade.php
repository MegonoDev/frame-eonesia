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
                                <label for="background">Background Image</label>
                                <div class="col-md-8">
                                    <div class="file-upload">
                                        <div class="text-center mb-0">
                                            <span id="image-title_background"></span>
                                        </div>
                                        <div class="image-upload-wrap" id="background_wrap">
                                            <input name="background" id="background" class="upload-hidden" type='file' accept="image/png" />
                                            <h3>DRAG</h3>
                                            <div class="text-center">
                                                OR
                                            </div>
                                            <h3>CLICK HERE</h3>
                                        </div>
                                        <div id="background_show" class="file-upload-content">
                                            <img class="file-upload-image" id="background_thumb" src="#" alt="Foto" />
                                            <button class="btn btn-danger btn-block mt-3" id="button_ktp" type="button" style="border-radius:0;" onclick="$('#background').trigger( 'click' )">Ganti Foto</button>
                                        </div>
                                    </div>
                                    {!! $errors->first('background', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="type_bg">Background Type</label>
                                <div class="form-inline">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_bg_image" name="type_bg" value="image">
                                        <label class="custom-control-label" for="type_bg_image">Image</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_bg_solid" name="type_bg" value="solid">
                                        <label class="custom-control-label" for="type_bg_solid">Solid Color</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input" id="type_bg_gradient" name="type_bg" value="gradient">
                                        <label class="custom-control-label" for="type_bg_gradient">Gradient Color</label>
                                    </div>
                                </div>
                                {!! $errors->first('type_bg', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="nama_bg">Background Name</label>
                                <input name="nama_bg" class="form-control {{ $errors->has('nama_bg') ? 'is-invalid' : '' }}" id="nama_bg" type="text" placeholder="Background Name">
                                {!! $errors->first('nama_bg', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="color_bg">Color</label>
                                <textarea name="color_bg" data-role="tagsinput" class="form-control {{ $errors->has('color_bg') ? 'is-invalid' : '' }}" id="color_bg" type="text" placeholder="#fff,#000"></textarea>
                                <p class="help-block">separate hex color with comma</p>
                                {!! $errors->first('color_bg', '<div class="invalid-feedback">:message</div>') !!}
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

        $('#id_bg').change(function() {
            getPreviewImage();
        })

        function getPreviewImage() {
            var id = $('#id_bg').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('background.preview') }}",
                type: "POST",
                data: {
                    "id": id,
                    "_token": '{{csrf_token()}}'

                },
                success: function(data) {
                    if (data.result == 'success') {
                        var background = data.image;
                        var text = '<img src="' + data.image + '" class="img-thumbnail mb-3 img-fluid img-bg" />';

                        // $('#uploadimageModal').modal('hide');
                        $('#img-preview').html(text);
                        $('#preview').fadeIn(500);
                        $("#file-drag").show();
                        $("#catatan").hide();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
</script>
@endpush