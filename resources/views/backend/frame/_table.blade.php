<table class="table table-responsive-sm table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th>Name</th>
            <th>Type</th>
            <th>URL</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($frames as $frame)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td width="5%">
                <img src="{{ asset('img/frame/thumb_'.$frame->path_frame) }}" alt="thumbnail" style="width:100px;height:100px"> 
            </td>
            <td>{{ $frame->nama_frame }}</td>
            <td>{{ $frame->type_frame }}</td>
            <td><a href="{{ env('APP_URL').'/frame/'.$frame->link_frame }}">{{ env('APP_URL').'/frame/'.$frame->link_frame }}</td>
            <td>
                <a href="{{ route('frame.edit',$frame->link_frame) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit {{ $frame->nama_frame }}"> <i class="c-icon cil-pencil"></i> </a>
        {{-- 
                <a href="{{ route('frame.show',$frame->link_frame) }}" class="btn btn-sm btn-warning"> <i class="c-icon cil-image1"></i> </a>
                --}}
            </tr>
        @endforeach
    </tbody>
</table>