@extends('layouts.backend.master-backend')
@section('title')
List Photo 
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
                            <h4>Photo</h4>
                        </li>
                    </ul>
                </div>
                    <div class="card-body">
                        @include('backend.photo._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush