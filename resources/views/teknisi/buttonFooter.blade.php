<div class="card-body">
        <button class="btn btn-danger btn-sm" id="btnModalContinue">Continous</button>

        @if($order->progres == 'Closing')
          <a href="/teknisi/order" class="btn btn-danger float-right" id="modalUpload">Kembali</a>
        @else
            @if($countMaterialApprove == 0)

                <button class="btn btn-success btn-sm float-right" id="modalUpload"><i class="bi bi-check-circle"></i> Closing</button>

            @endif
        @endif
    {{-- <button class="btn btn-success btn-sm float-right" id="modalUpload"><i class="bi bi-check-circle"></i> Closing</button> --}}
</div>


<!-- Modal upload -->
<div class="modal fade" id="modal-upload">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form-upload" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="bi bi-image"></i> Upload Nota</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="custom-file mb-3">
                        <input type="file" name="foto" id="foto" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Nomor Nota</label>
                        <input type="text" id="nomor" name="nomor" class="form-control" required/>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="idorderupload" id="idorderupload" value="{{$order->idorder}}" required/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="uploadGambar()" id="btn-upload" class="btn btn-success">
                    <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal upload -->

<!-- Modal Contious -->
<div class="modal fade" id="modalContinue">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="bi bi-arrow-repeat"></i> Continous Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="form-group">
            <label for="keteranganContinue">Keterangan</label>
            <textarea name="keteranganContinue" id="keteranganContinue" rows="2" class="form-control rounded-0"></textarea>
        </div>
  
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="btn-submit-pending" onclick="continueOrder({{$order->idorder}})" class="btn btn-warning">Kirim</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal Contious -->

<script>

$("#btnModalContinue").click(function(){
    $("#modalContinue").modal('show');
});

function continueOrder(id)
{
    var url ="/teknisi/continue/order";
    var keterangan = $("#keteranganContinue").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            keterangan:keterangan,
        },
        success:function(response){
                /**Notifikasi */
                $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

            $("#modalContinue").modal('hide');

            // Menunda redirect selama 2 detik
            setTimeout(function() {
                window.location = "/teknisi/order";
            }, 2000); // 2000 milidetik = 2 detik
        },
        error:function(error)
        {
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Opps..',
                subtitle: 'Error...',
                body: 'Terjadi Kesalahan',
            })
        }
    });
}

  
$("#modalUpload").click(function(){
    $("#modal-upload").modal('show');
});


function uploadGambar() {
    /**Animasi */
    $("#btn-upload").attr('Disabled', true)
    $("#btn-upload").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var formData = new FormData($('#form-upload')[0]);

    $.ajax({
        url: '{{ route("teknisi.upload") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.status === 200){
                window.location = "/teknisi/order";
            }else if(response.status === 201){
                /**Animasi */
                $("#btn-upload").attr('Disabled', false)
                $("#btn-upload").html('<i class="bi bi-upload"></i> Upload')

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oopss..',
                    subtitle: 'Error...',
                    body: response.message,
                })
            }
        },
        error: function(error) {
            /**Animasi */
            $("#btn-upload").attr('Disabled', false)
            $("#btn-upload").html('<i class="bi bi-upload"></i> Upload')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oopss..',
                subtitle: 'Error...',
                body: 'Upload Gagal!',
            })
        }
    });
}

</script>