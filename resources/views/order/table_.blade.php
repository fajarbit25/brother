<table class="table m-0">
    <thead>
    <tr>
      <th>Order ID</th>
      <th>Tanggal Order</th>
      <th>Costumers</th>
      <th>Price</th>
      <th>Discount</th>
      <th>PPN</th>
      <th>Progres</th>
      <th>Jadwal</th>
      <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($result as $r)
    <tr>
      <td><a href="order/{{$r->uuid}}/show">{{$r->uuid}}</a></td>
      <td>{{$r->tanggal_order}}</td>
      <td>
        @if($r->costumer_status == 'New') <i class="bi bi-star"></i> @endif
        @if($r->costumer_status == 'Bronze') <i class="bi bi-star-half"></i> @endif
        @if($r->costumer_status == 'Gold') <i class="bi bi-star-fill text-warning"></i> @endif
        {{$r->costumer_name}}
      </td>
      <td>
        <div class="sparkbar" data-color="#00a65a" data-height="20">
          {{number_format($r->total_price)}} 
        </div>
      </td>
      <td>
        <div class="sparkbar" data-color="#00a65a" data-height="20">
          {{number_format($r->discount)}} 
        </div>
      </td>
      <td>
        @if($r->ppn == NULL)
        <button class="btn btn-success btn-xs" onclick="modalTAX({{$r->idorder}})"><i class="bi bi-percent"></i>TAX</button>
        @else 
          <div class="sparkbar" data-color="#00a65a" data-height="20">
            {{number_format($r->ppn)}} 
          </div>
        @endif
      </td>
      <td>
        <small> 
          @if($r->progres == 'Delivered')<span class="badge badge-secondary">{{$r->progres}}</span> 
          @elseif($r->progres == 'Created')<span class="badge badge-secondary">{{$r->progres}}</span>
          @elseif($r->progres == 'Pickup')<span class="badge badge-info">{{$r->progres}}</span> 
          @elseif($r->progres == 'Processing')<span class="badge badge-info">{{$r->progres}}</span> 
          @elseif($r->progres == 'Pending')<span class="badge badge-warning">{{$r->progres}}</span> 
          @elseif($r->progres == 'Cancel')<span class="badge badge-danger">{{$r->progres}}</span>
          @elseif($r->progres == 'Closing')<span class="badge badge-info">{{$r->progres}}</span> 
          @elseif($r->progres == 'Complete')<span class="badge badge-success">{{$r->progres}}</span>
          @endif
        </small>
      </td>
      <td>
          @if($r->teknisi == NULL)
            @if($r->progres == 'Cancel')
              <button class="btn btn-secondary btn-xs" disabled><i class="bi bi-calendar-x"></i> </button>
            @else
            <button class="btn btn-danger btn-xs" onclick="modalJadwal({{$r->idorder}})"><i class="bi bi-calendar-x"></i> </button>
            @endif
          @else
          <button class="btn btn-success btn-xs"><i class="bi bi-calendar-check"></i> </button>
          @endif
      </td>
      <td>
        @if($r->progres == 'Cancel' || $r->progres == 'Order Pending')
          {{$r->keterangan}}
        @else
          @if($r->progres != 'Complete')
            <a href="/order/{{$r->uuid}}/edit" class="btn btn-primary btn-xs"><i class="bi bi-pencil-square"></i></a>
          @endif
        @endif
        
        @if($r->progres == 'Complete')
          @if($r->payment == NULL)
            <button class="btn btn-info btn-xs" onclick="paymentMethod({{$r->idorder}})"><i class="bi bi-coin"></i> Payment Method</button>
          @else
            <button class="btn btn-warning btn-xs" onclick="paymentMethod({{$r->idorder}})"><i class="bi bi-coin"></i> Payment {{$r->payment}}</button>
          @endif
        @endif
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>