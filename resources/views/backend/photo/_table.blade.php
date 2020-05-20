@if(!$photos->isEmpty())
<table class="table table-responsive-sm table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Result</th>
            <th>Frame</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($photos as $photo)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td>
                <img src="{{ asset('img/photo/'.$photo->path_photo_thumb) }}" alt="thumbnail" style="width:100px;height:100px">
            </td>
            <td>
                <img src="{{ asset('img/result/'.$photo->path_result_thumb) }}" alt="thumbnail" style="width:100px;height:100px">
            </td>
            <td>
                {{ $photo->frame->nama_frame }}
            </td>
            <td>
                <form id="delete_{{ $photo->id }}" action="{{ route('photo.destroy',$photo->id) }}">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                <a href="{{ route('photo.show',$photo->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"> <i class="c-icon cil-image1"></i> </a>
                <button type="button" value="{{ $photo->id }}" class="del btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="c-icon cil-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    {{ $photos->links() }}
</table>
@else

<div class="text-center text-muted">
    <img src="{{ asset('assets/img/no-data.png') }}" width="200" height="200" alt="data not found">
    <br>
    Photo not Found
</div>
@endif