@extends('layouts.backend.master-backend')
@section('title')
List Background
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
                                <h4>Background Image</h4>
                            </li>
                            <li class="list-inline-item float-right">
                                <div class="d-none d-md-block">
                                    <a href="{{ route('background.create') }}" class="btn btn-sm btn-outline-primary mx-3">
                                        <i class="c-icon cil-image-plus"></i>
                                        Upload Background Image
                                    </a>
                                </div>
                                <div class="d-md-none float-right">
                                    <a href="{{ route('background.create') }}" class="btn btn-sm btn-outline-primary mb-3">
                                        <i class="c-icon cil-image-plus"></i>

                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @include('backend.background._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script src="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.delete').click(function() {

            var id = $(this).data(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    
                }
            })
        })
    })
</script>

@endpush
@push('css')
<link rel="stylesheet" href="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.css') }}">

@endpush