@if(!$backgrounds->isEmpty())
<table class="table table-responsive-sm table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Background</th>
            <th>Name</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($backgrounds as $background)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td>
                <img src="{{ asset('img/bg/'.$background->path_bg_thumb) }}" alt="thumbnail" style="width:100px;height:100px">
            </td>
            <td>{{ $background->nama_bg }}</td>
            <td>{{ $background->created_at }}</td>
            <td>
                <form id="delete_{{ $background->id }}" action="{{ route('background.destroy',$background->id) }}">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                    <a href="{{ route('background.edit',$background->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"> <i class="c-icon cil-pencil"></i> </a>
                    <button type="button" value="{{ $background->id }}" class="del btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="c-icon cil-trash"></i></button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else

<div class="text-center text-muted">
    <img src="{{ asset('assets/img/no-data.png') }}" width="200" height="200" alt="data not found">
    <br>
    Background not Found<br />
    <a href="{{ route('frame.prepare') }}" class="btn btn-warning">
        <i class="c-icon cil-folder-open"></i>
        Make Folder First.
    </a>
</div>
@endif