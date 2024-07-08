@foreach($result as $r)
<tr>
    <td>{{$loop->iteration}}</td>
    <td> {{$r->reservasi_date}} </td>
    <td><a href="/inventory/{{$r->reservasi_id}}/outbound">{{$r->reservasi_id}}</a></td>
    <td><a href="/order/{{$r->uuid}}/show">BRO9842</a> {{$r->costumer_name}} </td>
    <td> {{$r->teknisi_name}} | {{$r->helper_name}} </td>
    <td>
        @if($r->reservasi_approved == 0)<span class="badge badge-warning">Pending</span>
        @else <span class="badge badge-success">Approved</span>
        @endif
    </td>
</tr>
@endforeach
<tr>
    <td colspan="6" class="">
        <div class="col-sm-12">
            {{$result->links()}}
        </div>
    </td>
</tr>