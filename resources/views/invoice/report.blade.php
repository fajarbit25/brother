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
            <li class="breadcrumb-item"><a href="{{url('/invoice')}}">Invoice</a></li>
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

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Invoice Report</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" id="modalReport" title="Filter Data">
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
                            <th>#</th>
                            <th>Order Id</th>
                            <th>Costumer Name</th>
                            <th>Nomor Invoice</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-report"></tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="" class="btn btn-danger btn-sm float-right" id="btn-excel"><i class="bi bi-file-earmark-spreadsheet"></i> Export Excel</a>
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




<!-- Modal Jadwal -->
<div class="modal fade" id="modal-filter">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Filter</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="idorder-invoice-edit" id="idorder-invoice-edit">
        <div class="col-sm-12">
            <div class="alert alert-warning" id="alert-input-edit"></div>
        </div>
        <div class="form-group" id="form-due_date">
            <label for="start">Mulai</label>
            <input type="date" name="start" id="start" class="form-control"/>
        </div>
        <div class="form-group">
          <label for="end">Sampai</label>
          <input type="date" name="end" id="end" class="form-control">
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-report" onclick="getReport()"><i class="bi bi-filter-square"></i> Filter</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



{{-- JS --}}
<script src="{{asset('/assets/js/invoice.js')}}"></script>
@endsection
