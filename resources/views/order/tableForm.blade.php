<table class="table table-hover text-nowrap">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Merk</th>
            <th>Paard Kracht</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Discount</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $row)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$row->item_name}}</td>
            <td>{{$row->merk}}</td>
            <td>{{$row->pk}}</td>
            <td>{{$row->qty}}</td>
            <td>Rp.{{number_format($row->price)}}</td>
            <td>Rp.{{number_format($row->disc)}}</td>
            <td>
                <button class="btn btn-danger btn-xs" onclick="itemDelete({{$row->idoi}})"><i class="bi bi-trash3"></i></button>
            </td>
        @endforeach
        </tr>
    </tbody>
    <thead>
        <tr>
            <th colspan="6"></th>
            <th>Sub. Total</th>
            <th>: Rp. {{number_format($order->total_price+$order->discount)}},- </th>
        </tr>
        <tr>
            <th colspan="6"></th>
            <th>Discount</th>
            <th>: Rp. {{number_format($order->discount)}},- </th>
        </tr>
        <tr>
            <th colspan="6"></th>
            <th>Grand Total</th>
            <th>: Rp. {{number_format($order->total_price)}},- </th>
        </tr>
    </thead>
</table>