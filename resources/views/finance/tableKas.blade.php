@if(count($result) == 0)
    <tr>
        <td colspan="8">
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
            <td>{{$r->txid}}</td>
            <td>{{$r->created_at}}</td>
            <td>{{$r->tipe}}</td>
            <td>{{number_format($r->amount)}}</td>
            <td>{{number_format($r->saldo)}}</td>
            <td>
                <span class="badge badge-success">{{$r->status}}</span>
            </td> 
            <td>{{$r->keterangan}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8">
            {{$result->links()}}
        </td>
    </tr>

@endif