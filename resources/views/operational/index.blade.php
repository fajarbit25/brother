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
            <li class="breadcrumb-item"><a href="#">Operational</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
            <li class="breadcrumb-item active">Pemasukan</li>
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
          <div class="row">
            
          <div class="col-2 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Tunai</span>
                <span class="info-box-number">
                   <p id="saldoTunai"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <div class="col-2 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">BCA</span>
                <span class="info-box-number">
                  
                   <p id="saldoBCA"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <div class="col-2 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Mandiri</span>
                <span class="info-box-number">
                  
                   <p id="saldoMandiri"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-2 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">BRI</span>
                <span class="info-box-number">
                  
                   <p id="saldoBRI"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          </div> <!-- /.row -->
        </div>

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Catatan Pemasukan Bulan Ini</h3>

              <div class="card-tools">
                <a href="javascript:void(0)" class="btn btn-sm btn-info"  data-toggle="modal" data-target="#modal-xl">Place New Transactions</a>
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
                <table class="table m-0" style="font-size: 12px;">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>TXID</th>
                    <th>Date Time</th>
                    <th>Status</th>
                    <th>Jenis Transaksi</th>
                    <th>Nomor Nota</th>
                    <th>Amount</th>
                    <th>Creator</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody id="table-ops">
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
<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formOps">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipe</label>
                <select name="tipe" id="tipe" class="form-control" readonly>
                    <option value="IN" selected>Pemasukan</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Jenis Transaksi</label>
                  <select name="jenis" id="jenis" class="form-control">
                    @foreach ($opsitem as $item)
                    <option value="{{$item->id}}"> {{$item->item}} </option>
                    @endforeach
                  </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Metode Transaksi</label>
                  <select name="metode" id="metode" class="form-control">
                    <option value="Cash"> Cash </option>
                    <option value="BCA"> BCA</option>
                    <option value="Mandiri"> Mandiri</option>
                    <option value="BRI"> BRI</option>
                  </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nomor_nota">Nomor Nota</label>
                <input type="text" name="nomor_nota" id="nomor_nota" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
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

<!-- Modal -->
<div class="modal fade" id="modalDeleteMutasi">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="idMutasiDelete"/>
          <span class="fw-bold">Yakin ingin menghapus mutasi?</span>
        <button type="button" class="btn btn-default btn-sm float-right" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-danger btn-sm float-right" onclick="deleteMutasi()" id="btnDeleteMutasi">Hapus</button>
      </div>
      <div class="modal-footer justify-content-between">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script src="{{asset('/assets/js/ops.js?v1'.time())}}"></script>
@endsection
