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

        $('.del').click(function() {

            var id = $(this).val();
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
                    delete_bg(id);
                }
            })
        })

        function delete_bg(id) {
            var url = $('#delete_' + id).attr('action');
            var data = $('#delete_' + id).serialize();
            var method = "POST";

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    if (response.code == "200") {
                        Swal.fire(
                            'Success!',
                            'Background deleted',
                            'success'
                        )
                        backTo(response.url);
                    } else {
                        Swal.fire(
                            'Error!',
                            'Can\'t delete background',
                            'warning'
                        )
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Warning!",
                        text: xhr.errors,
                        icon: "warning",
                        button: "OK!",
                        closeOnClickOutside: false
                    });
                }
            })
        }

        function backTo(url) {
            window.location.href = url;
        }
    })
</script>

@endpush
@push('css')
<link rel="stylesheet" href="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.css') }}">

@endpush