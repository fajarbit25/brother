@if(count($result) == 0)


@else 
    @foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->product_name}}</td>
        <td>{{number_format($r->qty)}}</td>
        <td>{{number_format($r->price)}}</td>
        <td>{{number_format($r->jumlah)}}</td>
        <td>
            <button type="button" onclick="deleteItem({{$r->id}})" class="btn btn-danger btn-xs"><i class="bi bi-trash3"></i></button>
        </td>
    </tr>
    @endforeach

@endif