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
            <li class="breadcrumb-item"><a href="#">Finance</a></li>
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
        <div class="col md 12">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-wallet2"></i></span>
    
                <div class="info-box-content">
                  <span class="info-box-text">Kas Perusahaan</span>
                  <span class="info-box-number">
                    
                     {{number_format($kas)}}
    
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{$title}}</h3>

              <div class="card-tools">
                <button type="button" id="btn-modal" class="btn btn-tool">
                  <i class="bi bi-plus-lg"></i>
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
                    <th>TXID</th>
                    <th>Date Time</th>
                    <th>Tipe</th>
                    <th>Amount</th>
                    <th>Saldo</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody id="table-kas">
                  </tbody>
                </table>
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
<div class="modal fade" id="modal-kas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Orders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="form-kas">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="tipe">Type Transaksi</label>
                <select class="form-control" style="width: 100%;" name="tipe" id="tipe">
                  <option value="IN">IN - Uang Masuk</option>
                  <option value="OUT">OUT - Uang Keluar</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-12">
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="2" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="{{asset('/assets/js/kas.js')}}"></script>
@endsection
