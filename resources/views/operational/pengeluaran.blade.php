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
            <li class="breadcrumb-item active">Pengeluaran</li>
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
          <div class="col-4 col-sm-4 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Kas Tunai</span>
                <span class="info-box-number">
                   <p id="saldoTunai"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <div class="col-4 col-sm-4 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Kas Non Tunai</span>
                <span class="info-box-number">
                  
                   <p id="saldoNonTunai"></p>
  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <div class="col-4 col-sm-4 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="bi bi-wallet2"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Kas Non Tunai Lainnya</span>
                <span class="info-box-number">
                  
                   <p id="saldoNonTunaiLainnya"></p>
  
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
              <h3 class="card-title">Catatan Pengeluaran Bulan Ini</h3>

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
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>TXID</th>
                    <th>Date Time</th>
                    <th>Tipe</th>
                    <th>Jenis Transaksi</th>
                    <th>Amount</th>
                    <th>Saldo</th>
                    <th>Metode</th>
                    <th>Bukti Transaksi</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody id="table-ops-out">
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
        <form action="#" id="formOpsOut" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipe</label>
                <select name="tipe" id="tipe" class="form-control" readonly>
                    <option value="OUT" selected>Pengeluaran</option>
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
                    <option value="Transfer"> Transfer </option>
                    <option value="Lainnya"> Lainnya </option>
                  </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bukti_transaksi">Bukti Transaksi</label>
                    <input type="file" class="form-control" name="bukti_transaksi" id="bukti_transaksi">
                </div>
            </div>
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
        <button type="button" class="btn btn-primary" id="btn-submitOut">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-foto">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Bukti Transaksi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img  alt="Foto" id="fotoNota" style="width: 100%;"/>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="{{asset('/assets/js/ops.js')}}"></script>
@endsection
