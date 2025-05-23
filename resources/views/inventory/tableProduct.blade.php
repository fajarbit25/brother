<table class="table m-0">
    <thead>
    <tr>
        <th>#</th>
        <th>Kode Produk</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($product as $p)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td><a href="/inventory/{{$p->product_code}}/mutasi">{{$p->product_code}}</a></td>
        <td>{{$p->product_name}}</td>
        <td>{{$p->category_code}}</td>
        <td>{{$p->unit_code}}</td>
        <td>
            <div class="sparkbar" data-color="#00a65a" data-height="20">{{number_format($p->harga_beli)}}</div>
        </td>
        <td>
           <span id="stok-{{$p->idproduk}}"> {{number_format($p->stock)}} </span>
        </td>
        <td>
            <button type="button" class="btn btn-success btn-xs" onclick="editProduct({{$p->idproduk}})"><i class="bi bi-pencil-square"></i></button>
            @if($p->stock == 0)
            <button type="button" class="btn btn-danger btn-xs" onclick="deleteProduct({{$p->idproduk}})"><i class="bi bi-trash3"></i></button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>

</table>
<div class="col-sm-12">
    {{$product->links()}}
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var url = "/produk/stok";
        $.ajax({
            url:url,
            type:'GET',
            dataType:'json',
            success:function(data){
                $.each(data, function(index, item) {
                    // Buat ID unik untuk setiap span, misalnya "stock-6" atau "stock-7"
                    var spanId = 'stok-' + item.id;

                    // // Set nilai span dengan ID "stock-6" atau "stock-7" dengan nilai stock dari data
                    $('#' + spanId).text(item.stock);
            })
            }
        });
    });
</script>