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
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
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

        @if(session('alert'))
          <div class="alert alert-success col-md-12" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="btn btn-success float-right" id="close-alert"><i class="bi bi-x-lg"></i></button>
          </div>
        @endif

        @if (session('error'))
        <div class="col-sm-12 alert alert-danger">
            <span class="fw-bold"> {{session('error')}} </span>
        </div>
        @endif

        @if (session('success'))
        <div class="col-sm-12 alert alert-success">
            <span class="fw-bold"> {{session('success')}} </span>
        </div>
        @endif

        <div class="col-md-12">

                  <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Projects Detail</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Costumer</span>
                      <span class="info-box-number text-center text-muted mb-0"> {{$costumer->costumer_name}} </span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Status Order</span>
                        <span class="info-box-number text-center text-muted mb-0"> {{$order->progres}} </span>
                      </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Teknisi</span>
                        <span class="info-box-number text-center text-muted mb-0">
                          @if(empty($teknisi->name))
                            None
                         @else
                          {{$teknisi->name}}
                         @endif
                        </span>
                      </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Harga</span>
                      <span class="info-box-number text-center text-muted mb-0">Rp.{{number_format($order->total_price)}}</span>
                    </div>
                </div>
              </div>
              </div>

              <div class="col-12">
                <h4>Detail Orders</h4>
                <table class="table table-hover table-bordered text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tipe Order</th>
                      <th>Merk</th>
                      <th>Qty</th>
                      <th>Paard Kracht</th>
                      <th>Lokasi</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($order_item as $item)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$item->item_name}}</td>
                      <td>{{$item->merk}}</td>
                      <td>{{$item->qty}}</td>
                      <td>{{$item->pk}}</td>
                      <td>Lantai {{$item->lantai}}, Ruangan {{$item->ruangan}}</td>
                      <td>Rp.{{number_format($item->price)}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <thead>
                    <tr>
                      <th colspan="6">Sub. Total</th>
                      <th>Rp.{{number_format($order_item->sum('price'))}}</th>
                    </tr>
                  </thead>
                </table>

                  <div class="post clearfix">
                      <h4>Material</h4>
                      <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($material as $mat)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$mat->item}}</td>
                            <td>{{number_format($mat->qty)}}</td>
                            <td>{{$mat->satuan}}</td>
                            <td>Rp.{{number_format($mat->price)}}</td>
                            <td>Rp.{{number_format($mat->jumlah)}}</td>
                          </tr>
                          @endforeach
                          
                        </tbody>
                        <thead>
                          <tr>
                            <th colspan="5">Sub. Total</th>
                            <th>Rp.{{number_format($sum_mat)}}</th>
                          </tr>
                        </thead>
                      </table>
                  </div>

              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          @if(Auth::user()->privilege == 5 || Auth::user()->privilege == 1 || Auth::user()->privilege == 6)
            <a href="/order/{{$order->uuid}}/edit" class="btn btn-sm btn-danger">Edit Order</a>
          @endif
            <a href="/order" class="btn btn-sm btn-secondary float-right">Kembali ke Order</a>
        </div>
      </div>
      <!-- /.card -->
          
        </div>
        <!-- /.col -->

        <div class="col md-12">

        @livewire('order.form-update', ['idorder' => $order->idorder])

        </div><!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal upload -->
<div class="modal fade" id="modal-nota">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <form id="form-upload" enctype="multipart/form-data">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="bi bi-image"></i> Nota</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <img src="{{asset('/storage/nota/'.$order->nota)}}" alt="nota" style="width: 100%;">
                  
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="hidden" name="idorder" id="idorder" value="{{$order->idorder}}">
                  @if($order->progres == 'Closing')
                    <button type="button" class="btn btn-danger float-right" id="rejectNota"><i class="bi bi-x-lg"></i> Reject Nota</button>
                    <button type="button" class="btn btn-success float-right" id="approveNota"><i class="bi bi-check-circle-fill"></i> Approve Nota</button>
                  @endif
              </div>
          </form>
      </div>
  <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal upload -->


@if($order->progres == 'Complete')
<!-- Modal upload -->
<div class="modal fade" id="modalRecall">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form id="form-upload" enctype="multipart/form-data">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="bi bi-repeat"></i> Recall Order</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="alert alert-success">
                  <span class="fw-bold">Alert!</span><br/>
                  <span>- Order akan dikembalikan ke status</span> <span class="fw-bold">"Processing"</span>.<br/>
                  <span>- Pastikan teknisi sebelumnya tidak/belum memiliki order pada jadwal tersebut.</span>
                </div>
                
                  
              </div>
              <div class="modal-footer justify-content-between">
                  <input type="hidden" id="teknisi_id" value="{{$teknisi->id}}">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success float-right" id="processRecall"><i class="bi bi-check-circle-fill"></i> Proses Recall</button>
              </div>
          </form>
      </div>
  <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal upload -->
@endif



<script type="text/javascript">
  function lihatNota()
  {
    $("#modal-nota").modal('show');
  }

  $("#approveNota").click(function(){
    $(this).attr('Disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/order/approve/nota";
    var idorder = $("#idorder").val();
    $.ajax({
      url:url,
      type:'POST',
      cache:false,
      data:{
        idorder:idorder,
      },
      success:function(response){
        $(this).hide()
        /**Notifikasi */
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Congrats..',
            subtitle: 'Success...',
            body: response.success,
        })

        window.location = "/order/" + response.uuid + "/show"
      },
      error:function(){
        /**Notifikasi */
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Oopss..',
            subtitle: 'Error...',
            body: 'Proses Gagal!',
        })
      }
    });
  });

  $("#rejectNota").click(function(){
    $(this).attr('Disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/order/reject/nota";
    var idorder = $("#idorder").val();

    $.ajax({
      url:url,
      type:'POST',
      cache:false,
      data:{
        idorder:idorder,
      },
      success:function(response){
        window.location = "/order"
      },
      error:function(){
        $("#rejectNota").attr('Disabled', false)
        $("#rejectNota").html('<i class="bi bi-x-lg"></i> Reject Nota')
        /**Notifikasi */
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Oopss..',
            subtitle: 'Error...',
            body: 'Proses Gagal!',
        })
      }
    });

  });

  $("#close-alert").click(function(){
    $(".alert").hide();
  });

  function modalRecal()
  {
    $("#modalRecall").modal('show');
  }
  
  $("#processRecall").click(function() {

    $(this).attr('Disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = '/order/recall';
    var idorder = $("#idorder").val();
    var teknisi = $("#teknisi_id").val();

    $.ajax({
      url:url,
      type:'POST',
      cache:false,
      data:{
        idorder:idorder,
        teknisi:teknisi,
      },
      success:function(response){
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Congrats..',
            subtitle: 'Success...',
            body: response.success,
        })

        window.location = "/order"
      },
      error:function(){
        /**Notifikasi */
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Oopss..',
            subtitle: 'Error...',
            body: 'Proses Gagal!',
        })
      }
    });

    
  });
</script>
@endsection
