@extends('template.layout')
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/order">Orders</a></li>
            <li class="breadcrumb-item active">Jadwal Orders</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Active Orders</h3>

              <div class="card-tools">
                <a href="javascript:void(0)" class="btn btn-tool"  data-toggle="modal" data-target="#modal-create">
                  <i class="bi bi-plus-lg" id="btn-create-plus"></i>
                </a>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive" id="jadwal-order">
                
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal -->
<div class="modal fade" id="modalJam">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Atur Jadwal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">
            <input type="hidden" id="idorderJam">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Pilih Jadwal</label>
                    <select class="form-control" style="width: 100%;" name="jadwal" id="jadwal">
                      <optgroup label="Pilih Jadwal">
                        <option value="Pagi">Pagi</option>
                        <option value="Siang">Siang</option>
                        <option value="Sore">Sore</option>
                        <option value="Malam">Malam</option>
                      </optgroup>
                    </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="form-group">
                  <label for="tanggal">Req Jam</label>
                  <input type="text" name="jam" id="jam" class="form-control" value="--:--" required/>
                </div>
              </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="processJam()">
            <span class="spinner-border spinner-border-sm" aria-hidden="true" id="loadingAnimation1"></span>
            Buat Jadwal
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modalJadwal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Jadwal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formJadwal">
          <input type="hidden" name="idorder" id="idorder" required/>
          <input type="hidden" name="jadwalEdit" id="jadwalEdit" required/>
          <input type="hidden" name="jamEdit" id="jamEdit" required/>
          <div class="row">
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Teknisi</label>
                    <select class="form-control" style="width: 100%;" name="teknisi" id="teknisi">
                      <optgroup label="Pilih Jadwal">
                        @foreach($teknisi as $tk)
                        <option value="{{$tk->id}}">{{$tk->name}}</option>
                        @endforeach
                      </optgroup>
                    </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Helper</label>
                    <select class="form-control" style="width: 100%;" name="helper" id="helper">
                      <optgroup label="Pilih Jadwal">
                        @foreach($helper as $hp)
                        <option value="{{$hp->id}}">{{$hp->name}}</option>
                        @endforeach
                      </optgroup>
                    </select>
                </div>
            </div><!-- /.col -->
            
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submit-jadwal" onclick="cekJadwal()">
            <span class="spinner-border spinner-border-sm" aria-hidden="true" id="loadingAnimation2"></span> Buat Jadwal
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



{{-- JS --}}
<script>
    $(document).ready(function(){
        loadJadwal()
        $("#loadingAnimation1").hide()
        $("#loadingAnimation2").hide()
    });

    function loadJadwal()
    {
        var url = "/order/jadwal-order-table";
        $("#jadwal-order").load(url);
    }

    function modalJam(id)
    {
        $("#idorderJam").val(id);
        $("#modalJam").modal('show');
    }

    function processJam()
    {
        $("#loadingAnimation1").show()
        $(".btn").attr('disabled', true)

        var id = $("#idorderJam").val();
        var jadwal = $("#jadwal").val();
        var jam = $("#jam").val();
        var url = "/order/buat-jadwal";

        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                id:id,
                jadwal:jadwal,
                jam:jam,
            },
            success:function(response){
                loadJadwal()
                $("#modalJam").modal('hide');
                $("#jadwal").val("");
                $("#jam").val("--:--");

                $("#loadingAnimation1").hide()
                $(".btn").attr('disabled', false)

            },
            error:function(){
                $("#loadingAnimation1").hide()
                $(".btn").attr('disabled', false)

                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oops..',
                    subtitle: 'Alert...',
                    body: 'Terjadi Kesalahan, Periksa Koneksi Anda!'
                })
            }
        });

    }

    /**Jadwal */
    function modalJadwal(uuid, jadwal, jam)
    {
        $("#modalJadwal").modal('show');
        $("#idorder").val(uuid);
        $("#jadwalEdit").val(jadwal);
        $("#jamEdit").val(jam)
    }
    function cekJadwal()
    {
        /**Animasi */
        $("#btn-loading-jadwal").show();
        $("#btn-submit-jadwal").hide();

        var form = $("#formJadwal")[0];
        var data = new FormData(form);
        var url = "/order/cekJadwal";

        $.ajax({
            url:url,
            type:'POST',
            data:data,
            processData:false,
            contentType:false,
            success:function(response){
                if(response.success === 'false'){
                    createJadwal();
                }else{
                    /**Animasi */
                    $("#btn-loading-jadwal").hide();
                    $("#btn-submit-jadwal").show();

                    /**close Modal */
                    $("#modalJadwal").modal('hide');

                    $(document).Toasts('create', {
                        class: 'bg-warning',
                        title: 'Oops..',
                        subtitle: 'Alert...',
                        body: 'Jadwal Untuk Teknisi Tersebut Telah Terisi, Gunakan Jadwal Lain!'
                    })
                }
            },
            error:function(){
                /**Animasi */
                $("#btn-loading-jadwal").hide();
                $("#btn-submit-jadwal").show();

                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oops..',
                    subtitle: 'Alert...',
                    body: 'Terjadi Kesalahan, Periksa Koneksi Anda!'
                })
            }
        });
    }
    function createJadwal()
    {

        var form = $("#formJadwal")[0];
        var data = new FormData(form);
        var url = "/order/submit/jadwal";

        $.ajax({
            url:url,
            type:'POST',
            data:data,
            processData:false,
            contentType:false,
            success:function(response){
                /**Animasi */
                $("#btn-loading-jadwal").hide();
                $("#btn-submit-jadwal").show();

                /**reset Form dan tutup modal*/
                $("#formJadwal")[0].reset();
                $("#modalJadwal").modal('hide');

                /**load tabel */
                window.location = "/order";

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats..',
                    subtitle: 'Success...',
                    body: response.success,
                })
            },
            error:function(){
                /**Animasi */
                $("#btn-loading-jadwal").hide();
                $("#btn-submit-jadwal").show();

                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops..',
                    subtitle: 'Error...',
                    body: 'Permintaan gagal, Terjadi kesalahan!'
                })
            }
        });
    }

</script>
@endsection
