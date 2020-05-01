@extends('layouts.backend.master-backend')
@section('title')
Result Frame
@endsection
@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <h4>Result</h4>
                            </li>
                            <li class="list-inline-item float-right">
                                <div class="d-none d-md-block">
                                    <a href="{{ route('result.download',['id' => $frame->id,'name' => $frame->link_frame]) }}" class="btn btn-sm btn-outline-primary mx-3">
                                        <i class="c-icon cil-cloud-download"></i>
                                        Download All Photo (zip)
                                    </a>
                                </div>
                                <div class="d-md-none float-right">
                                    <a href="{{ route('result.download',['id' => $frame->id,'name' => $frame->link_frame]) }}" class="btn btn-sm btn-outline-primary mx-3">
                                        <i class="c-icon cil-cloud-download"></i>

                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @include('backend.frame._table-result')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush