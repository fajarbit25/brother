<div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Request</th>
                    <th>Usage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materialRequest as $items)
                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td style="white-space:nowrap;"> {{$items->name}} </td>
                    <td> {{number_format($items->qty)}} {{$items->satuan}} </td>
                    <td>
                        <!--@foreach($stocks as $stok)-->
                        <!--    @if($stok->product_id == $items->product_id)-->
                        <!--        {{number_format($stok->stock).' '.$stok->satuan}}-->
                        <!--    @endif-->
                        <!--@endforeach-->
                        @foreach($stocks->groupBy('product_id') as $idProduk => $stok)
                            @if($idProduk == $items->product_id)
                                {{number_format($stok->sum('stock')).' '.$stok->first()->satuan}}
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    
</div>