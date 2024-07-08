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

          @if($count == 0)
            <div class="list-group mb-3">
                <span class="text-bold"><i>Material kosong...</i></span>
            </div>
          @else
            @foreach($stocks as $stok)
              <div class="list-group mb-3">
                  <a href="#" class="list-group-item list-group-item-action text-light" aria-current="true">
                      <div class="row">
                        <div class="col-6">
                            {{$loop->iteration}}. {{$stok->name}}
                        </div>
                        <div class="col-3">
                            : {{number_format($stok->qty)}} {{$stok->satuan}}
                        </div>
                        <div class="col-3">
                          @if($stok->retur == NULL || $stok->retur == 0) 
                            <button class="btn btn-warning btn-xs" onclick="modalRetur({{$stok->id}})"><i class="bi bi-box-arrow-in-up"></i> Retur</button>
                          @else
                          <button class="btn btn-secondary btn-xs" disabled><i class="bi bi-lock-fill"></i> Lock</button>
                          @endif
                          </div>
                      </div>
                  </a>
              </div>
              @endforeach
            @endif


            <div id="item-list"></div>

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
<div class="modal fade" id="retur-modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Retur</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idretur" id="idretur">
            <div class="form-group">
              <label for="qty">Qty</label>
                <input type="number" class="form-control" id="qty-retur" Qtyautocomplete="off">
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-proses-return" onclick="prosesRetur()">Proses Retur</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<script src="{{asset('/assets/js/teknisiStock.js')}}"></script>
@endsection
