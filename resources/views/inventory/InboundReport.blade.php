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
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
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
        <div class="col-md-12">

          <!-- TABLE: LATEST INBOUND -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Report Inbound</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" id="filter">
                    <i class="bi bi-funnel-fill"></i>
                  </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Delivery Order</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Product</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
                    <th>Jumlah</th>
                    <th>Cabang</th>
                  </tr>
                  </thead>
                  <tbody id="table-report">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

              <a href="" id="btn-excel" class="btn btn-danger btn-sm float-right"><i class="bi bi-file-earmark-spreadsheet"></i> Export Excel</a>
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
<div class="modal fade" id="modal-tanggal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cek laporan pertanggal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="">
          <div class="row">

            <div class="col-md-12 mb-3">
              <div class="form-group">
                <label for="start"><i class="bi bi-calendar2-week"></i> Start</label>
                <input type="date" name="start" id="start" class="form-control">
              </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                  <label for="end"><i class="bi bi-calendar2-week"></i> End</label>
                  <input type="date" name="end" id="end" class="form-control">
                </div>
              </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success"  id="btn-report">Lihat</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- Js --}}
<script src="{{asset('/assets/js/inbound.js')}}"></script>
@endsection

