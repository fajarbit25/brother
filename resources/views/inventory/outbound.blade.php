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
        <div class="col-md-12" id="formFilter">
          <div class="card">
            <div class="card-body">
              <div class="input-group input-group-sm">
                <input type="date" id="start" class="form-control" title="Tanggal Mulai">
                <input type="date" id="end" class="form-control" title="Sampai Tanggal">
                <span class="input-group-append">
                  <button type="button" id="btn-filter" class="btn btn-primary btn-flat"><i class="bi bi-funnel"></i> Filter</button>
                </span>
              </div>
            </div>
          </div>  
        </div><!-- /.col -->
        <div class="col-md-12">

          <!-- TABLE: LATEST INBOUND -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Products</h3>

              <div class="card-tools">
                <button type="button" id="filter" class="btn btn-tool">
                  <i class="bi bi-funnel"></i>
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
                    <th>Tanggal</th>
                    <th>Reservasi Id</th>
                    <th>Order</th>
                    <th>Teknisi</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody id="outbound-table">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              {{-- <a href="#" class="btn btn-sm btn-info float-left">Place New Inbound</a> --}}
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

{{-- Js --}}
<script src="{{asset('/assets/js/outbound.js')}}"></script>
@endsection
