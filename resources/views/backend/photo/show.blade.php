@extends('layouts.backend.master-backend')
@section('title')
Show Photo
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-body">

                <div class="form-group text-center">
                        <img src="{{ asset('img/result/'.$photo->path_result_thumb) }}" class="img-fluid" id="fg" style="width: {{ $size['width_thumb'] }}px;height:{{ $size['width_thumb'] }}px;" />
                        <img src="{{ asset('img/photo/'.$photo->path_photo_thumb) }}"  class="img-fluid" style="width: {{ $size['width_thumb'] }}px;height:{{ $size['width_thumb'] }}px;" />
                    </div>


                    <div class="form-group text-center">
                        <label><b>Frame</b></label>
                        <div class="controls">

                            <div class="text-center">
                                <span>{{ $photo->frame->nama_frame }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <label><b>Download</b></label>
                        <div class="controls">
                            <a href="{{ route('downloadPhoto',$photo->path_photo) }}" class="btn btn-primary mb-2" type="button">
                                <i class="c-icon mr-2 cil-image1">
                                </i><span>Download Original</span>
                            </a>
                            <a href="{{ route('download',$photo->path_result) }}" class="btn btn-success mb-2" type="button">
                            <i class="c-icon mr-2 cil-image1">
                                </i><span>Download Result</span>
                            </a>
                        </div>
                    </div>
                    

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-start">
                            <a href="{{ route('photo.index') }}" class="btn mx-2 btn-outline-dark">
                                <i class="c-icon cil-chevron-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/lib/clipboard/clipboard.min.js') }}"></script>
<script>
    var clipboard = new ClipboardJS('#copy');

    clipboard.on('success', function(e) {
        Swal.fire(
            'Yeay!',
            'URL successfully copied.',
            'success'
        );
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
</script>
@endpush
@push('css')
<link rel="stylesheet" href="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.css') }}">

@endpush