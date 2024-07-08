<div class="col-sm-12">
    @foreach($stocks as $stok)
    <strong><i class="bi bi-arrow-right-short"></i> {{$stok->name}} : </strong> {{$stok->stock.' '.$stok->satuan}} <br/>
    @endforeach
</div>