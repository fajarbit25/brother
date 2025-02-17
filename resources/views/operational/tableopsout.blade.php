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
        <td> {{$loop->iteration}} </td>
        <td style="white-space:nowrap;">
            @if ($r->status_approval == 'rejected')
            <button type="button" class="btn btn-danger btn-xs" onclick="confirmDeleteMutasi({{$r->id}})">
                <i class="bi bi-trash"></i>
            </button> 
            @endif
            {{$r->trx_id}} 
        </td>
        <td> {{$r->created_at}} </td>
        <td>
            @if ($r->status_approval == 'rejected') <span class="badge badge-danger"> {{ucfirst($r->status_approval)}} </span>
            @elseif ($r->status_approval == 'approved') <span class="badge badge-success"> {{ucfirst($r->status_approval)}} </span>
            @elseif ($r->status_approval == 'pending') <span class="badge badge-warning"> {{ucfirst($r->status_approval)}} </span>
            @endif
        </td>
        <td> {{$r->item}} </td>
        
        <td> {{number_format($r->amount)}} </td>
        <td> {{$r->name}} </td>
        <td>
            {{$r->metode}}
        </td>
        <td>
            <button type="button" class="btn btn-primary btn-xs" onclick="buktiTransaksi('{{$r->bukti_transaksi}}')">
                <i class="bi bi-card-image"></i>
            </button>
        </td>
        <td> {{$r->keterangan}} </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="10">
            {{$result->links()}}
        </td>
    </tr>

@endif