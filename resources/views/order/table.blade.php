<table class="table m-0">
    <thead>
    <tr>
      <th>Order ID</th>
      <th>Tanggal Order</th>
      <th>Costumers</th>
      <th>Teknisi</th>
      <th>Price</th>
      <th>Discount</th>
      <th>PPN</th>
      <th>Progres</th>
      <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($result->groupBy('uuid') as $uuid => $r)
    <tr>
      <td><a href="order/{{$uuid}}/show">{{$uuid}}</a></td>
      <td>{{$r->first()->tanggal_order}}</td>
      <td>
        @if($r->first()->costumer_status == 'New') <i class="bi bi-star"></i> @endif
        @if($r->first()->costumer_status == 'Bronze') <i class="bi bi-star-half"></i> @endif
        @if($r->first()->costumer_status == 'Gold') <i class="bi bi-star-fill text-warning"></i> @endif
        {{$r->first()->costumer_name}}
      </td>
      <td>
          @if($r->first()->teknisi == NULL)
            @if($r->first()->progres == 'Cancel')
              <button class="btn btn-secondary btn-xs" disabled><i class="bi bi-exclamation-circle"></i> Cancel </button>
            @else
              <button class="btn btn-danger btn-xs" onclick="modalJadwal({{$r->first()->idorder}})"><i class="bi bi-plus"></i> Teknisi </button>
            @endif
          @else
          {{$r->first()->teknisi_name.'|'.$r->first()->helper_name}}
          @endif
      </td>
      <td>

        
        @php
        $totalPrice = $r->first()->total_price;
        $orderId = $r->first()->idorder;
        $sumJumlah = $totalMaterial->where('order_id', $orderId)->sum('jumlah');

        // Mengonversi $totalPrice dan $sumJumlah menjadi angka jika mereka bukan numerik
        $totalPrice = is_numeric($totalPrice) ? $totalPrice : 0;
        $sumJumlah = is_numeric($sumJumlah) ? $sumJumlah : 0;

        $finalPrice = $totalPrice + $sumJumlah;
    @endphp

    <div class="sparkbar" data-color="#00a65a" data-height="20">
        @if(is_numeric($finalPrice))
        {{ number_format($finalPrice) }}
    @else
        Nilai tidak valid
    @endif
    </div>
        
      </td>
      <td>
        <div class="sparkbar" data-color="#00a65a" data-height="20">
          {{number_format($r->first()->discount)}} 
        </div>
      </td>
      <td style="white-space:nowrap;">
        @if($r->first()->ppn == NULL)
        <button class="btn btn-success btn-xs" onclick="modalTAX({{$r->first()->idorder}})">
          <i class="bi bi-percent"></i>TAX
        </button>
        @else 
          <div class="sparkbar" data-color="#00a65a" data-height="20">
            {{number_format($r->first()->ppn)}} 
          </div>
        @endif
      </td>
      <td>
        <small> 
          @if($r->first()->progres == 'Delivered')<span class="badge badge-secondary">{{$r->first()->progres}}</span> 
          @elseif($r->first()->progres == 'Created')<span class="badge badge-secondary">{{$r->first()->progres}}</span>
          @elseif($r->first()->progres == 'Pickup')<span class="badge badge-info">{{$r->first()->progres}}</span> 
          @elseif($r->first()->progres == 'Processing')<span class="badge badge-info">{{$r->first()->progres}}</span> 
          @elseif($r->first()->progres == 'Pending')<span class="badge badge-warning">{{$r->first()->progres}}</span> 
          @elseif($r->first()->progres == 'Cancel')<span class="badge badge-danger">{{$r->first()->progres}}</span>
          @elseif($r->first()->progres == 'Closing')<span class="badge badge-info">{{$r->first()->progres}}</span> 
          @elseif($r->first()->progres == 'Complete')<span class="badge badge-success">{{$r->first()->progres}}</span>
          @elseif($r->first()->progres == 'Continous')<span class="badge badge-danger">{{$r->first()->progres}}</span>
          @endif
        </small>
      </td>
      <td>
        @if($r->first()->progres == 'Cancel' || $r->first()->progres == 'Pending' || $r->first()->progres == 'Continous')
          {{$r->first()->keterangan}}
        @endif
        
        @if($r->first()->progres == 'Complete')
          @if($r->first()->payment == NULL)
            <button class="btn btn-info btn-xs" onclick="paymentMethod({{$r->first()->idorder}})"><i class="bi bi-coin"></i> Payment Method</button>
          @else
            <button class="btn btn-warning btn-xs" onclick="paymentMethod({{$r->first()->idorder}})"><i class="bi bi-coin"></i> Payment {{$r->first()->payment}}</button>
          @endif
        @endif
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>