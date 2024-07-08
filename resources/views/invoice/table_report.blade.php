
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
        <td> {{$r->uuid}} </td>
        <td> {{$r->costumer_name}} </td>
        <td> {{$r->invoice_id}} </td>
        <td> {{number_format($r->total_tagihan)}} </td>
        <td> {{$r->invoice_date}} </td>
        <td> {{$r->due_date}} </td>
        <td>
            @if($r->status == 'Create') <span class="badge badge-secondary">{{$r->status}}</span>
            @elseif($r->status == 'Review') <span class="badge badge-warning">{{$r->status}}</span>
            @elseif($r->status == 'Approved') <span class="badge badge-primary">{{$r->status}}</span>
            @elseif($r->status == 'Sending') <span class="badge badge-info">{{$r->status}}</span>
            @else <span class="badge badge-success">{{$r->status}}</span> @endif
        </td>
    </tr>
    @endforeach

    <tr>
        <td colspan="8">
            {{$result->links()}}
        </td>
    </tr>
@endif