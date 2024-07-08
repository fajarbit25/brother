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
            <li class="breadcrumb-item active">{{Auth::user()->nik." / ".Auth::user()->name}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  {{-- Deklarasi Status Order --}}
  <input type="hidden" id="status-order" value="{{$order->progres}}" required/>
  <input type="hidden" id="uuid" value="{{$order->uuid}}" required/>

  {{-- end Of Deklarasi Status Order --}}

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <div class="col-md-12">

            <div class="list-group mb-3">
                <div href="#" class="list-group-item list-group-item-action text-light" aria-current="true">

                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-primary">{{$order->uuid}}</h5>
                    <small> <span class="badge badge-primary">{{$order->progres}}</span> </small>
                  </div>
                  <p class="mb-3">
                    <i class="bi bi-people"></i> {{$costumer->costumer_name}} .<br/>
                    <small>
                        <i class="bi bi-geo-alt"></i> {{$costumer->costumer_address}} <br/>
                        <i class="bi bi-clock-history"></i> {{$order->jadwal}}
                    </small>
                  </p>
                  @if($inbound == 0)
                    @if($order->progres == 'Pickup' || $order->progres == 'Processing')
                    <button class="btn btn-success w-100 mb-3" id="btn-proses" onclick="proses({{$order->idorder}})"><i class="bi bi-tools"></i> Proses Pengerjaan</button>
                    <button class="btn btn-warning w-100 mb-3" id="btn-pending" onclick="modalPending()"><i class="bi bi-hourglass-split"></i> Pending Progres</button>
                    @endif
                  @else
                    <div class="alert alert-info my-3">
                        <strong><i class="bi bi-exclamation-circle"></i> Noted</strong> <br/>
                        <i>Harap approve material untuk melanjutkan proses! </i> <br/>
                        <a href="/teknisi/material" class="btn btn-primary"> Material <i class="bi bi-arrow-right"></i></a>
                    </div>
                  @endif

                </div>
            </div>


            <div id="item-list"></div>

            <div class="card" id="buttonFooter"></div>

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Update -->
<div class="modal fade" id="modal-update">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="bi bi-plus-lg"></i> Form Pekerjaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action="" id="formItem">
          <input type="hidden" name="order_itemId" id="order-itemId" required/>
          <div class="form-group">
            <label for="tipe">Tipe Order <code>.Keluhan</code></label>
            <select name="tipe" id="tipe" class="form-control rounded-0">
              @foreach($items as $item)
              <option value="{{$item->iditem}}">{{$item->iditem.'. '.$item->item_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
              <label for="merk">Merk AC <code>.Nama/Merk AC</code></label>
              <input type="text" name="merk" class="form-control rounded-0" id="merk">
          </div>
          <div class="form-group">
              <label for="pk">PK <code>.Paard Kracht</code></label>
              <select name="pk" id="pk" class="form-control rounded-0">
                <option value="0,5 PK">0,5 PK</option>
                <option value="0,75 PK">0,75 PK</option>
                <option value="1 PK">1 PK</option>
                <option value="1,5 PK">1,5 PK</option>
                <option value="2 PK">2 PK</option>
                <option value="2,5 PK">2,5 PK</option>
                <option value="3 PK">3 PK</option>
                <option value="4 PK">4 PK</option>
                <option value="5 PK">5 PK</option>
                <option value="6 PK">6 PK</option>
              </select>
          </div>
          <div class="form-group">
              <label for="lantai">Lantai <code>.Hanya angka</code></label>
              <input type="number" name="lantai" class="form-control rounded-0" id="lantai" placeholder="Nomor lantai" autocomplete="off">
          </div>
          <div class="form-group">
              <label for="ruangan">Ruangan <code>.Nama Ruangan</code></label>
              <input type="text" name="ruangan" class="form-control rounded-0" id="ruangan" placeholder="Ruangan" autocomplete="off">
          </div>
        </form>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" id="btn-update-item" onclick="updateItem()" class="btn btn-success">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal modal update -->

<!-- Modal Pending -->
<div class="modal fade" id="modal-pending">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="bi bi-plus-lg"></i> Pending Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="keterangan">Alasan Dipending</label>
          <textarea name="keterangan" id="keterangan" rows="2" class="form-control rounded-0"></textarea>
      </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn-submit-pending" onclick="pendingOrder({{$order->idorder}})" class="btn btn-warning">Pending Order</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal Pending -->

{{-- Js --}}
<script src="{{asset('/assets/js/teknisiOrder.js')}}"></script>
<script>
  $(document).ready(function(){
    var uuid = $("#uuid").val();
    var url = "/teknisi/show/" + uuid + "/buttonFooter"
    $("#buttonFooter").load(url);
  });
</script>
@endsection
