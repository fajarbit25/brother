@foreach($result as $r)
<tr>
    <td>{{$loop->iteration}}</td>
    <td> {{$r->reservasi_date}} </td>
    <td><a href="/order/{{$r->uuid}}/show">BRO9842</a></td>
    <td>{{$r->costumer_name}} </td>
    <td> {{$r->product_name}} </td>
    <td> {{number_format($r->qty)}} </td>
    <td> {{number_format($r->material_price)}} </td>
    <td> {{(number_format($r->sub_total))}} </td>
    <td> {{$r->teknisi_name}} </td>
</tr>
@endforeach
<tr>
    <td colspan="9" class="">
        <div class="col-sm-12">
            {{$result->links()}}
        </div>
    </td>
</tr>
