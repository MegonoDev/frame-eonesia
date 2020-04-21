<!DOCTYPE html>

<html lang="en">

<head>
    <title>{{ $frame->nama_frame }}</title>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="upload foto kamu">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/img/icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('assets/coreui/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/upload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bg.css') }}">

    <style>
        .image-upload-wrap {
            border: 0;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            border: 0;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <label for="file-upload" id="file-drag">
                                <div id="show-form">
                                    <div id="uploaded_image" class="image-upload-wrap">
                                        <input class="upload-hidden" id="file-upload" type="file" name="fileUpload" accept="image/*," />
                                        <img src="{{ asset('assets/img/default-crop.png') }}">
                                        <span id="file-upload-btn" class="btn btn-block btn-dark btn-md mt-3"><i class="fa fa-camera"></i> Select a photo</span>
                                    </div>
                                </div>
                            </label>
                        </form>
                        <img src="{{ asset('assets/img/loading.gif') }}" id="loading" style="display:none; width: 250px;height:250px;">
                        <div id="hilang" style="display:none;">
                            <form>
                                <div id="preview">
                                    <div id="start">
                                        <table border="0" align="center" width="{{ $size['width_thumb'] }}px">
                                            <tr>
                                                <td>
                                                    <div id="image_demo"></div>
                                                    <div class="d-flex justify-content-start">
                                                        <img src="{{ asset('img/frame/thumb_'.$frame->path_frame) }}" id="fg" style="width: {{ $size['width_thumb'] }}px;height:{{ $size['width_thumb'] }}px;" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="show-frame" style="display:none;">Lihat Frame</button>
                                <button type="button" id="upload-photo" class="btn btn-success my-2 crop_image"><i class="fa fa-upload" aria-hidden="true"></i> Upload Photo</button>
                                <p id="catatan">*klik pada gambar untuk geser kanan, kiri, atas dan bawah </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- necessary plugins-->
        <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/lib/croppie/exif.js') }}"></script>
        <script src="{{ asset('assets/lib/croppie/croppie.js') }}"></script>
        <script>
            $(document).ready(function() {
                $image_crop = $('#image_demo').croppie({
                    enableExif: true,
                    viewport: {
                        width: "{{ $size['width_thumb']+100 }}",
                        height: "{{ $size['height_thumb']+100 }}",
                        type: 'square' //circle
                    },
                    boundary: {
                        width: "{{ $size['width_thumb'] }}",
                        height: "{{ $size['height_thumb'] }}"
                    }
                });

                $('#file-upload').on('change', function() {
                    var reader = new FileReader();
                    var maxwidth = "{{ $size['width']+100 }}";
                    var maxheight = "{{ $size['width']+100 }}";
                    reader.onload = function(event) {
                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = event.target.result;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (width < maxwidth) {
                                console.log('witdh', width);
                                alert("Lebar Gambar Minimal {{ $size['width'] }}px.");
                                $("#file-drag").show();
                                return false;
                            } else if (height < maxheight) {
                                console.log('height', height);
                                alert("Tinggi Gambar Minimal {{ $size['height']}}px.");
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
                    $('#uploadimageModal').modal('show');
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
                            $.ajax({
                                url: "{{ route('upload.create',$frame->link_frame) }}",
                                type: "POST",
                                data: {
                                    "image": response
                                },
                                success: function(data) {
                                    $('#uploadimageModal').modal('hide');
                                    $('#uploaded_image').html(data);
                                    $("#file-drag").show();
                                    $("#catatan").hide();
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