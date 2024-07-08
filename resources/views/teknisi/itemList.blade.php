<div class="card mb-3">
    <ol class="list-group list-group-numbered" id="formUnit">
        @foreach($orderitem as $itm)
        <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">{{$loop->iteration}}. {{$itm->item_name}}</div>
            {{$itm->merk}} {{$itm->pk}}
        </div>
            @if($itm->lantai != 0)<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-check-circle"></i> {{$order->progres}}</button>
            @else<button class="btn btn-success btn-sm" onclick="prosesItem({{$itm->idoi}})">Proses</button>
            @endif
        </li>
        @endforeach
    </ol>
</div>

@if($countListDone == 0)
<div class="card mb-3">
    <div class="card-header">
        Input Penggunaan Material
        <button class="btn btn-primary btn-sm float-right" id="btnModalMaterial"><i class="bi bi-plus"></i> Material</button>
    </div>
    <div class="card-body">
        <div class="col-sm-12" id="listMaterialUse"></div>
    </div>
</div>
@endif


<!-- Modal material -->
<div class="modal fade" id="modalMaterial">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="formMaterials">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="bi bi-tools"></i> Input Material</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="">
                        <div class="form-group">
                            <label>Pilih Material</label>
                            <select class="form-control select2bs4" style="width: 100%;" id="material_id">
                                <optgroup label="Pilih Material">
                                    <option value="0">--Pilih Material--</option>
                                @foreach($material as $m)
                                    <option value="{{$m->id}}">{{$m->name}}</option>
                                @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty-material">Volume Pemakaian <code>.Stock <span id="stockMaterial">: </span> <span id="satuanMaterial">-</span> </code></label>
                            <input type="number" name="qty" class="form-control form-control-border border-width-2" id="qty-material" autocomplete="off">
                        </div>
                
                    </form>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id-order" id="id-order" value="{{$order->idorder}}">
                    <input type="hidden" name="price" id="price">
                    <button class="btn btn-primary float-right" id="btn-add-material">Tambahkan</button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal material -->

<!-- Modal upload -->


<script type="text/javascript">
    $(document).ready(function(){
        loadMaterialUse()
    });

    $("#material_id").change(function(){
        var id = $(this).val();
        var url = "/teknisi/" + id + "/productJson";
        
        $.ajax({
            url:url,
            type:'GET',
            dataType:'json',
            success:function(data){
                $("#stockMaterial").html(data.stock)
                $("#satuanMaterial").html(data.satuan)
                $("#price").val(data.price)
                if(data.stock < 0){
                    $("#btn-add-material").attr('disabled', true)
                    $("#btn-add-material").addClass('btn btn-secondary float-right')
                }else if(data.stock > 0){
                    $("#btn-add-material").attr('disabled', false)
                    $("#btn-add-material").removeClass('btn btn-secondary float-right')
                    $("#btn-add-material").addClass('btn btn-primary float-right')
                }else{
                    $("#btn-add-material").attr('disabled', false)
                }
            }
        });
    });
    
    $("#btnModalMaterial").click(function(){

        $("#modalMaterial").modal('show')
        console.log('okay')

    });



    function loadMaterialUse()
    {
        var uuid = $("#uuid").val();
        var url = "/teknisi/" + uuid + "/material/use";
        $("#listMaterialUse").load(url)
        console.log(uuid)
    }

    $("#btn-add-material").click(function(){
        var idorder = $("#id-order").val();
        var qty = $("#qty-material").val();
        var price = $("#price").val();
        var idproduct = $("#material_id").val();
        var url = "/teknisi/ordermaterials";

        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                idorder:idorder,
                qty:qty,
                price:price,
                idproduct:idproduct
            },
            success:function(response){
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats..',
                    subtitle: 'Success...',
                    body: 'Material ditambahkan!',
                })
                $("#modalMaterial").modal('hide')
                loadMaterialUse()
                
                $("#qty-material").val('');
            },
            error:function(){
                console.log('error');
            }
        });

        console.log(idorder);
    });


</script>