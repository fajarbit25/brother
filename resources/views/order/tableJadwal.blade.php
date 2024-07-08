<table class="table m-0">
    <thead>
    <tr>
      <th>#</th>
      <th>Teknisi</th>
      <th>Jam</th>
      <th>Pelanggan</th>
      <th>Alamat</th>
      <th>Item</th>
      <th>Status</th>
    </tr>
    </thead>
    <tbody>
      @foreach($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>
              @if($r->count == 1)<i class="bi bi-circle-fill text-success"></i> <i class="bi bi-circle"></i> <i class="bi bi-circle"></i>@endif
              @if($r->count == 2)<i class="bi bi-circle-fill text-success"></i> <i class="bi bi-circle-fill text-success"></i> <i class="bi bi-circle"></i>@endif
              @if($r->count == 3)<i class="bi bi-circle-fill text-success"></i> <i class="bi bi-circle-fill text-success"></i> <i class="bi bi-circle-fill text-success"></i>@endif
              {{$r->teknisi_name.'|'.$r->helper_name}}
            </td>
            <td>{{$r->jadwal}}</td>
            <td>{{$r->costumer_name}}</td>
            <td>{{$r->costumer_address}}</td>
            <td>{{$r->item_name}}</td>
            <td>{{$r->progres}}</td>
        </tr>
        @endforeach
    </tbody>
  </table>