<table class="table table-bordered" style="font-size: 11;">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No</th>
            <th>Nama</th>
            <th>Request Jam</th>
            <th>Item</th>
            <th>Alamat</th>
            <th>Teknisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table->groupBy('tanggal_order') as $tanggal => $items)
        <tr>
            <td> {{$tanggal}} </td>
            <td colspan="6"></td>
        </tr>
        @foreach($items->groupBy('idorder') as $idOrder => $item)
        <tr>
            <td></td>
            <td> {{$loop->iteration}} </td>
            <td>
                <a href="/order/{{$item->first()->uuid}}/show">
                {{$item->first()->costumer_name}}
                </a>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="modalJam({{$idOrder}})">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                {{$item->first()->jadwal}} | {{$item->first()->request_jam}}
            </td>
            <td>
                @foreach($item as $orderItem)
                <span class="badge bg-secondary">{{$orderItem->item_name}}</span>
                @endforeach
            </td>
            <td> {{$item->first()->costumer_address}} </td>
            <td>
                @if($item->first()->jadwal != null)
                <button class="btn btn-danger btn-xs" onclick="modalJadwal('{{$idOrder}}', '{{$item->first()->jadwal}}', '{{$item->first()->request_jam}}')"><i class="bi bi-plus"></i> Teknisi </button>
                @endif
            </td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>