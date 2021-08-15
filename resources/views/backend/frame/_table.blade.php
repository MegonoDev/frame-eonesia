@if(!$frames->isEmpty())
<table class="table table-responsive-sm table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Frame</th>
            <th>Background</th>
            <th class="text-center">Name</th>
            <th class="text-center">Type</th>
            <th class="text-center">URL</th>
            <th>Photo</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($frames as $frame)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td width="5%">
                <img src="{{ asset('img/frame/'.$frame->path_frame_thumb) }}" alt="thumbnail" style="width:100px;height:100px">
            </td>
            <td width="5%">
                <img src="{{ asset(($frame->id_bg == null) ? 'assets/img/default-landscape.png' : 'img/bg/'.$frame->background->path_bg_thumb) }}" alt="thumbnail" style="width:100px;height:100px">
            </td>
            <td class="text-center">{{ $frame->nama_frame }}</td>
            <td class="text-center">{{ $frame->type_frame }}</td>
            <td class="text-center"><a class="font-weight-bold" target="_blank" href="{{ route('upload',$frame->link_frame) }}">{{ route('upload',$frame->link_frame) }}</td>
            <td class="text-center"><a href="{{ route('result.index',$frame->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Result"> <i class="c-icon cil-image1"></i> </td>
            <td class="text-center">
                <form id="delete_{{ $frame->id }}" action="{{ route('frame.destroy',$frame->id) }}">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                    <a href="{{ route('frame.edit',$frame->link_frame) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit {{ $frame->nama_frame }}"> <i class="c-icon cil-pencil"></i> </a>

                    <a href="{{ route('frame.show',$frame->link_frame) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show {{ $frame->nama_frame }}"> <i class="c-icon cil-image1"></i> </a>
                    <button type="button" value="{{ $frame->id }}" class="del btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="c-icon cil-trash"></i></button>
                </form>

        </tr>
        @endforeach
    </tbody>
</table>
{!! $frames->links() !!}
@else

<div class="text-center text-muted">
    <img src="{{ asset('assets/img/no-data.png') }}" width="200" height="200" alt="data not found">
    <br>
    Frame not Found<br />
    <a href="{{ route('frame.prepare') }}" class="btn btn-warning">
        <i class="c-icon cil-folder-open"></i>
        Make Folder First.
    </a>
</div>
@endif