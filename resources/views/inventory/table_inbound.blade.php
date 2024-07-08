
@if(count($result) == 0)
    <tr>
        <td colspan="8">
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
            <button class="btn btn-info btn-xs" onclick="modalEdit('{{$r->id}}', '{{$r->do}}')" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </button>

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
            @if($r->temp_status == 'Open')
            <span class="badge badge-primary">Nok</span>
            @else 
            <span class="badge badge-success">Done</span>
            @endif
        </td>
        <td>
            @if($r->status_payment == 'Unpaid')
            <span class="badge badge-warning">{{$r->status_payment}}</span>
            @else 
            <span class="badge badge-success">{{$r->status_payment}}</span>
            @endif
        </td>
        <td>
            {{$r->branch_name}}
        </td>
    </tr>
    @endforeach
<tr>
    <td colspan="8">
        {{$result->links()}}
    </td>
</tr>

@endif