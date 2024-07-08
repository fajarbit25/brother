@if(count($result) == 0)
    <tr>
        <td>
            <strong>
                <i>
                    Tidak ada data
                </i>
            </strong>
        </td>
    </tr>
@else 
    @foreach($result as $r)
        <tr>
            <td> {{$loop->iteration}} </td>
            <td> {{$r->item}} </td>
            <td>
                <button type="button" class="btn btn-success btn-xs" onclick="modalItemEdit('{{$r->id}}', '{{$r->item}}')">
                    <i class="bi bi-pencil-square"></i>
                </button>
                @if($r->id != 9)
                <button type="button" class="btn btn-danger btn-xs" onclick="modalDeleteItem({{$r->id}})">
                    <i class="bi bi-trash3"></i>
                </button>
                @endif
            </td>
        </tr>
    @endforeach
@endif