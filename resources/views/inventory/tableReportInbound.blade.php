@if(count($result) == 0)
    <tr>
        <td colspan="10">
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
        <td>{{$r->do}}</td>
        <td>{{$r->tanggal}}</td>
        <td>{{$r->supplier_name}}</td>
        <td>{{$r->product_name}}</td>
        <td>{{number_format($r->harga_beli)}}</td>
        <td>{{number_format($r->harga_jual)}}</td>
        <td>{{number_format($r->qty)}}</td>
        <td>{{number_format($r->jumlah)}}</td>
        <td>{{$r->branch_name}}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="10">
            {{$result->links()}}
        </td>
    </tr>
@endif