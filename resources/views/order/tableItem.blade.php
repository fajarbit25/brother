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
            <td>{{$r->item_name}}</td>
            <td>
                <button class="btn btn-danger btn-xs" id="btn-delete-item-{{$r->iditem}}" onclick="deleteItem({{$r->iditem}})"><i class="bi bi-trash3"></i></button>
            </td>
        </tr>
    @endforeach
@endif