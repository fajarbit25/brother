@if(count($result) == 0)
    <td>
        <td colspan="7">
            <strong>
                <i>
                    Tidak ada data!
                </i>
            </strong>
        </td>
    </td>
@else 
    @foreach($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$r->tanggal}}</td>
            <td>{{$r->referensi}}</td>
            <td>{{$r->branch_name}}</td>
            <td>{{$r->product_name}}</td>
            <td>{{$r->qty}}</td>
            <td>
                @if($r->tag_approve == 0)
                    <span class="badge badge-warning">Unapproved</span>
                @else 
                    <span class="badge badge-success">Approved</span>
                @endif
            </td>
            <td>
                <button type="button" class="btn btn-success btn-xs" id="btn-approve-branch-{{$r->id}}" onclick="approvedBranch({{$r->id}})">
                    <i class="bi bi-check-circle"></i> Approved
                </button>
            </td>
        </tr>
    @endforeach
@endif