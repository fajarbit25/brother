@extends('template.layout_teknisi')
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
            <li class="breadcrumb-item"><a href="#">Teknisi</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  {{-- Deklarasi Status Order --}}

  {{-- end Of Deklarasi Status Order --}}

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <div class="col-md-12">

            <ol class="list-group list-group-numbered">

                @if(count($result) != 0)
                    @foreach($result as $r)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><strong>Rp.{{number_format($r->amount)}}</strong></div>
                        <i class="bi bi-calendar2-week"></i> {{$r->tanggal}} | <i class="bi bi-clock"></i> {{$r->jam}}
                    </div>
                    @if($r->approved == 0)
                    <button class="btn btn-primary" id="btn-approve-bon" onclick="approveBon('{{$r->id}}', '{{$r->user_id}}',)"><i class="bi bi-check-circle"></i> Approve</button>
                    @else
                    <button type="button" class="btn btn-success btn-sm" disabled><i class="bi bi-check-circle"></i> Complete</button>
                    @endif
                    </li>
                    @endforeach

                @else
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="fw-bold">
                            <i>Tidak ada data!</i>
                        </div>
                    </div>
                </li>
                @endif

            </ol>

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal retur -->
<div class="modal fade" id="bon-modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approve</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idretur" id="idretur">
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="user_id" id="user_id">
            <div class="form-group">
              <label for="password">Masukan Password</label>
                <input type="password" class="form-control" id="password">
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-proses" onclick="prosesBon()">Proses</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<script type="text/javascript">
    function approveBon(id, userid)
    {
        $("#id").val(id);
        $("#user_id").val(userid)
        $("#bon-modal").modal('show')
    }
    function prosesBon()
    {
        $("#btn-proses").attr('disabled', true)
        $("#btn-proses").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

        var url = "/teknisi/cashbon";
        var id = $("#id").val();
        var password = $("#password").val();
        var userid = $("#user_id").val();

        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                id:id,
                userid:userid,
                password:password,
            },
            success:function(response){
                if(response.status === 500){
                    $("#btn-proses").attr('disabled', false)
                    $("#btn-proses").html('Proses Ulang')

                    /**Notifikasi */
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Oops..',
                        subtitle: 'Error message...',
                        body: 'Terjadi kesalahan.!',
                    })
                }else{
                    window.location = "/teknisi/cashbon";
                }
            },
            error:function(){
                $("#btn-proses").attr('disabled', false)
                $("#btn-proses").html('Proses Ulang')
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops..',
                    subtitle: 'Error message...',
                    body: 'Terjadi kesalahan.!',
                })
            }
        });
    }
</script>
@endsection
