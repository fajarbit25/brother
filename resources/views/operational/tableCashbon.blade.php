
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
            <td> <span class="text-info"><strong>{{$r->nik}}</strong></span> {{$r->name}}</td>
            <td>{{$r->nama_role}}</td>
            <td>{{$r->tanggal}}</td>
            <td>{{$r->jam}}</td>
            <td>{{number_format($r->amount)}}</td>
            <td>
                @if($r->status == 'Open')
                    <span class="badge badge-secondary">Unpaid</span>
                @else 
                    <span class="badge badge-success">Paid</span>
                @endif
            </td>
            <td>
                @if($r->approved == 0)
                    <span class="badge badge-warning">Pending</span>
                @else
                    <span class="badge badge-success">Success</span>
                @endif
            </td>
            <td>
                {{$r->alasan_cashbon}}
            </td>
            <td>
                @if($r->approved == 0)
                <button class="btn btn-danger btn-xs" id="btn-deletecashbon-{{$r->cid}}" onclick="deleteCashbon({{$r->cid}})"><i class="bi bi-trash"></i></button>
                @else
                <button class="btn btn-secondary btn-xs" disabled><i class="bi bi-trash"></i></button>
                @endif
            </td>
        </tr>

    @endforeach
        <tr>
            <td colspan="10">
                {{$result->links()}}
            </td>
        </tr>
@endif