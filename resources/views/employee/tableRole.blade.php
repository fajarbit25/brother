@if(count($result) == 0)
    <tr>
        <td colspan="3">
            <strong>
                <i>
                    Tidak ada data!
                </i>
            </strong>
        </td>
    </tr>
@else 
    @foreach($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>
                @if(Auth::user()->privilege == 1)
                <button type="button" class="btn btn-success btn-xs" onclick="editRole('{{$r->idrole}}', '{{$r->kode_role}}', '{{$r->nama_role}}')"><i class="bi bi-pencil-square"></i></button>
                @endif
                {{$r->kode_role}}
            </td>
            <td>{{$r->nama_role}}</td>
        </tr>
    @endforeach
@endif