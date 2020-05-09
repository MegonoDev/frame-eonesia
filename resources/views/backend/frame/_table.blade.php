@if(!$frames->isEmpty())
<table class="table table-responsive-sm table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Frame</th>
            <th>Background</th>
            <th>Name</th>
            <th>Type</th>
            <th>URL</th>
            <th>Photo</th>
            <th>Action</th>
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
            <td>{{ $frame->nama_frame }}</td>
            <td>{{ $frame->type_frame }}</td>
            <td><a href="{{ env('APP_URL').'/frame/'.$frame->link_frame }}">{{ env('APP_URL').'/frame/'.$frame->link_frame }}</td>
            <td><a href="{{ route('result.index',$frame->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Result"> <i class="c-icon cil-image1"></i> </td>
            <td>
                <a href="{{ route('frame.edit',$frame->link_frame) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit {{ $frame->nama_frame }}"> <i class="c-icon cil-pencil"></i> </a>

                <a href="{{ route('frame.show',$frame->link_frame) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show {{ $frame->nama_frame }}"> <i class="c-icon cil-image1"></i> </a>

        </tr>
        @endforeach
    </tbody>
</table>
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