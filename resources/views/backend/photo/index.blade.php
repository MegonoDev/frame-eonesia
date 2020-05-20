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
                    del(id);
                }
            })
        })

        function del(id) {
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
                            'Photo deleted',
                            'success'
                        )
                        backTo(response.url);
                    } else {
                        Swal.fire(
                            'Error!',
                            'Can\'t delete photo',
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

    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('assets/lib/sweetalert2/dist/sweetalert2.min.css') }}">

@endpush