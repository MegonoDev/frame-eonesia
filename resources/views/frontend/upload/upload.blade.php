<!DOCTYPE html>

<html lang="en">

<head>
    <title> {{ $frame->nama_frame }} </title>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes">
    <meta name="description" content="{{ $frame->nama_frame }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/img/icon-new.png') }}" rel="icon">
    <link href="{{ asset('assets/img/icon-new.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('assets/coreui/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/upload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bg.css') }}">

    <style>
        .image-upload-wrap {
            border: 0;
            margin-top: 0;
        }


        .image-dropping,
        .image-upload-wrap:hover {
            border: 0;
        }

        body {
            background: url('{{ ($frame->id_bg == null) ? '' : asset("img/bg/".$frame->background->path_bg) }}');
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
        }
    </style>

</head>

<body id="body">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <strong>Upload Foto Kamu</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <label for="file-upload" id="file-drag">
                                <div id="show-form">
                                    <div id="uploaded_image" class="image-upload-wrap">
                                        <input class="upload-hidden" id="file-upload" type="file" name="fileUpload" accept="image/*," />
                                        <img src="{{ asset($size['bg']) }}" style="width: {{ $size['width_thumb'] }}px; height:{{ $size['height_thumb'] }}px" class="img-fluid">
                                        <span id="file-upload-btn" class="btn btn-block btn-dark btn-md mt-3"><i class="fa fa-camera"></i> Select a photo</span>
                                    </div>
                                </div>
                            </label>
                        </form>
                        <div class="text-center">
                            <img src="{{ asset('assets/img/loading.gif') }}" id="loading" style="display:none; width: 250px;height:250px;">
                        </div>
                        <div id="hilang" style="display:none;">
                            <form>
                                <div id="preview">
                                    <div id="start">
                                        <table border="0" align="center" width="{{ $size['width_thumb'] }}">
                                            <tr>
                                                <td>
                                                    <div id="image_demo"></div>
                                                    <div class="d-flex justify-content-start">
                                                        <img src="{{ asset('img/frame/thumb_'.$frame->path_frame) }}" id="fg" style="width: {{ $size['width_thumb'] }}px;height:{{ $size['height_thumb'] }}px;" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <button class="rotate btn btn-primary" type="button" data-deg="-90">Rotate Left</button>
                                <button class="rotate btn btn-primary" type="button" data-deg="90">Rotate Right</button>
                                <button type="button" class="btn btn-primary" id="show-frame" style="display:none;">Lihat Frame</button>
                                <button type="button" id="upload-photo" class="btn btn-success my-2 crop_image"><i class="fa fa-upload" aria-hidden="true"></i> Upload Photo</button>
                                <p id="catatan">*klik pada gambar untuk geser kanan, kiri, atas dan bawah </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

    <!-- necessary plugins-->
    <script src="{{ asset('assets/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lib/croppie/exif.js') }}"></script>
    <script src="{{ asset('assets/lib/croppie/croppie.js') }}"></script>
    <script>
        $(function() {
            $('.rotate').on('click', function(ev) {
                ev.preventDefault();
                $('#image_demo').croppie('rotate', parseInt($(this).data('deg')));
            });
        });

        $(document).ready(function() {
            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                enableOrientation: true,
                viewport: {
                    width: "{{ $size['width_thumb'] }}",
                    height: "{{ $size['height_thumb'] }}",
                    type: 'square' //circle
                },
                boundary: {
                    width: "{{ $size['width_thumb'] }}",
                    height: "{{ $size['height_thumb'] }}"
                }
            });

            $('#file-upload').on('change', function() {
                var reader = new FileReader();
                var minweight = "{{ $size['width_thumb'] }}";
                var minheight = "{{ $size['width_thumb'] }}";
                reader.onload = function(event) {
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = event.target.result;
                    image.onload = function() {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if (width < minweight) {
                            console.log('witdh', width);
                            alert("Lebar Gambar Minimal {{ $size['width_thumb'] }}px.");
                            $("#file-drag").show();
                            return false;
                        } else if (height < minheight) {
                            console.log('height', height);
                            alert("Tinggi Gambar Minimal {{ $size['height_thumb']}}px.");
                            $("#file-drag").show();
                            return false;
                        }
                        $image_crop
                            .croppie('bind', {
                                url: event.target.result
                            })
                            .then(function() {
                                console.log('NGAPAIN KEMARI...........');
                            });
                        console.log(height);
                        $("#hilang").show();
                        $("#file-drag").hide();
                    };
                }
                reader.readAsDataURL(this.files[0]);
                // $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function(event) {
                $image_crop
                    .croppie('result', {
                        type: 'canvas',
                        size: {
                            width: "{{ $size['width']}}",
                            height: "{{ $size['height']}}"
                        }
                    })

                    .then(function(response) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('upload.store',$frame->link_frame) }}",
                            type: "POST",
                            data: {
                                "image": response,
                                "frame": "{{ $frame->link_frame }}",
                                "_token": '{{csrf_token()}}'

                            },
                            success: function(data) {
                                if (data.result == 'ok') {
                                    var thispage = "{{ route('upload',$frame->link_frame) }}";
                                    var text = '<a href="' + data.download + '"><img width="{{ $size["width_thumb"] }}px" height="{{ $size["height_thumb"] }}px" src="' + data.image + '" class="img-thumbnail mb-3" /></a><div> <a href="' + data.download + '"><span class="btn btn-warning">Download</span></a> <a href="' + thispage + '"><span class="btn btn-danger">Replay</span></a></div>';

                                    // $('#uploadimageModal').modal('hide');
                                    $('#uploaded_image').html(text);
                                    $("#file-drag").show();
                                    $("#catatan").hide();
                                } else {
                                    alert("Terjadi kesalahan.");
                                    $("#file-drag").show();
                                }
                            }
                        });
                    })
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#fg").click(function() {
                $(this).hide();
            });
            $("#fg").click(function() {
                $("#show-frame").show();
            });
            $("#show-frame").click(function() {
                $("#fg").show();
            });
            $("#show-frame").click(function() {
                $("#show-frame").hide();
            });

            $("#file-upload-btn").click(function() {
                $("#file-drag").hide();
            });
            $("#upload-photo").click(function() {
                $("#hilang").hide();
            });
        });

        $(document).ajaxStart(function() {
            // Show image container
            $("#loading").show();
        });
        $(document).ajaxComplete(function() {
            // Hide image container
            $("#loading").hide();
        });
    </script>
</body>

</html>