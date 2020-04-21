@extends('layouts.backend.master-backend')
@section('title')
Dashboard
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
                            <h4>Frame</h4>
                        </li>
                        <li class="list-inline-item float-right">
                            <div class="d-none d-md-block">
                                <a href="{{ route('frame.create') }}" class="btn btn-sm btn-outline-primary mx-3">
                                    <i class="c-icon cil-image-plus"></i>
                                    Create Frame
                                </a>
                            </div>
                            <div class="d-md-none float-right">
                                <a href="{{ route('frame.create') }}" class="btn btn-sm btn-outline-primary mb-3">
                                    <i class="c-icon cil-image-plus"></i>

                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                    <div class="card-body">
                        @include('backend.frame._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush