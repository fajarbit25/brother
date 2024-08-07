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
            <td> <a href="/order/{{$r->uuid}}/show"> {{$r->uuid}} </a> </td>
            <td> {{$r->costumer_name}} </td>
            <td> {{number_format($r->total_price)}} </td>
            <td> {{number_format($r->ppn)}} </td>
            <td> {{$r->name}} </td>
            <td> {{$r->jadwal}} </td>
            <td> {{$r->progres}}</td>
            <td> {{$r->payment}} </td>
            <td> {{$r->status_invoice}}</td>
        </tr>
    @endforeach
        <tr>
            <td colspan="10">
                {{$result->links()}}
            </td>
        </tr>
@endif