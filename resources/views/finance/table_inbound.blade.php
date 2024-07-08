
@if(count($result) == 0)
    <tr>
        <td colspan="7">
            <i>
                <strong>
                    Tidak ada data ditemukan...
                </strong>
            </i>
        </td>
    </tr>
@else
    @foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>

            <a href="/inventory/{{$r->id}}/inbound">
                {{$r->do}}
            </a>
            
        </td>
        <td>{{$r->tanggal}}</td>
        <td>{{$r->supplier_name}}</td>
        <td>
            @if($r->tag_approved == 0)
            <span class="badge badge-warning">Unapproved</span>
            @else
            <span class="badge badge-success">Approved</span>
            @endif
        </td>
        <td>
            {{number_format($r->total_jumlah)}}
        </td>
        <td>
            @if($r->status_payment == 'Unpaid')
                @if($r->tag_approved == 0)
                    <button type="button" class="btn btn-danger btn-xs" onclick="modalInbound({{$r->id}})" disabled><i class="bi bi-cash-coin"></i> {{$r->status_payment}}</button>
                @else 
                    <button type="button" class="btn btn-danger btn-xs" onclick="modalInbound({{$r->id}})"><i class="bi bi-cash-coin"></i> {{$r->status_payment}}</button>
                @endif
            @else 
            <button type="button" class="btn btn-success btn-xs" disabled><i class="bi bi-cash-coin"></i> {{$r->status_payment}}</button>
            @endif
        </td>
        <td>
            {{$r->branch_name}}
        </td>
    </tr>
    @endforeach
{{-- <tr>
    <td colspan="7">
        {{$result->links()}}
    </td>
</tr> --}}

@endif