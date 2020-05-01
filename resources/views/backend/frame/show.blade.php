@extends('layouts.backend.master-backend')
@section('title')
Show Frame
@endsection
@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="col-12 col-sm-12 col-lg-12 d-flex align-items-center justify-content-center">
            <div class="card">
                <div class="card-body">
                    <div class="form-group text-center">
                        <img src="{{ asset('img/frame/'.$frame->path_frame_thumb) }}" id="fg" style="width: {{ $size['width_thumb'] }}px;height:{{ $size['width_thumb'] }}px;" />
                    </div>


                    <div class="form-group text-center">
                        <label><b>TITLE</b></label>
                        <div class="controls">

                            <div class="text-center">
                                <span>{{ $frame->nama_frame }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <label><b>URL</b></label>
                        <div class="controls">
                            <div class="input-group">
                                <input class="form-control" id="link" type="text" value="{{ route('upload',$frame->link_frame) }}"><span class="input-group-append">
                                    <button id="copy" data-clipboard-target="#link" class="btn btn-secondary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy">
                                        <i class="c-icon cil-clipboard"></i>
                                    </button></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <label><b>SHARE</b></label>
                        <div class="controls">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('upload',$frame->link_frame) }}" class="btn btn-facebook mb-2" type="button">
                                <i class="c-icon mr-2 cib-facebook-f">
                                </i><span>Facebook</span>
                            </a>
                            <a href="http://twitter.com/share?text=Ayo Upload Foto Kamu&url={{ route('upload',$frame->link_frame) }}&hashtags=event" class="btn btn-twitter mb-2" type="button">
                                <i class="c-icon mr-2 cib-twitter">
                                </i><span>Twitter</span>
                            </a>
                            <a href="https://wa.me/?text=Ayo upload foto kamu... {{ route('upload',$frame->link_frame) }}" class="btn btn-success mb-2" type="button">
                                <i class="c-icon mr-2 cib-whatsapp">
                                </i><span>Whatsapp</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-start">
                            <a href="{{ route('frame.index') }}" class="btn mx-2 btn-outline-dark">
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