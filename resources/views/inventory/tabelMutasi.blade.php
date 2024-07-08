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
        <td>{{$r->tanggal_mutasi}}</td>
        <td>
            @if($r->jenis == 'Inbound')
                <span class="badge badge-success">Inbound</span>
            @elseif($r->jenis == 'Retur')
                <span class="badge badge-success">Inbound</span>
            @else 
                <span class="badge badge-warning">Outbound</span>
            @endif
        </td>
        <td>{{number_format($r->qty)}}</td>
        <td>{{number_format($r->saldo_awal)}}</td>
        <td>{{number_format($r->saldo_akhir)}}</td>
        <td>
            @if($r->jenis == 'Inbound')
                Restock
            @elseif($r->jenis == 'Retur')
                Retur
            @else 
                {{$r->order_id}}
            @endif
        </td>
        <td>{{$r->name}}</td>
    </tr>

    @endforeach

    <tr>
        <td colspan="8">
            {{$result->links()}}
        </td>
    </tr>

@endif