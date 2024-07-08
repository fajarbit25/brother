@if(count($result) == 0)

<tr>
    <td colspan="7">
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
    <td>{{$r->uuid}}</td>
    <td>{{$r->costumer_name}}</td>
    <td>
      <div class="sparkbar" data-color="#00a65a" data-height="20">{{number_format($r->total_price)}}</div>
    </td>
    <td><span class="badge badge-success">{{$r->progres}}</span></td>
    <td>{{$r->updated_at}}</td>
    <td>{{$r->name}}</td>
    <td>
      @if($r->payment == null)
      <span class="badge badge-secondary">Unpaid</span>
      @else 
      <span class="badge badge-success">{{$r->payment}}</span>
      @endif
    </td>
  </tr>
  @endforeach
  <tr>
    <td colspan="7">
        {{$result->links()}}
    </td>
  </tr>

@endif
