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
            <li class="breadcrumb-item active">Active Orders</li>
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
              <h3 class="card-title">Active Orders</h3>

              <div class="card-tools">
                <a href="#" class="btn btn-tool"  data-toggle="modal" data-target="#modal-create">
                  <i class="bi bi-plus-lg" id="btn-create-plus"></i>
                </a>
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
              <div class="table-responsive" id="tableOrder">
                
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
<div class="modal fade" id="modal-create">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Orders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">

            <div class="col-sm-8">
              <div class="form-group">
                  <label>Pilih Pelanggan</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="costumer_id">
                    <optgroup label="Pilih Pelanggan">
                      @foreach($costumers as $cost)
                      <option value="{{$cost->idcostumer}}"> {{$cost->costumer_name}}</option>
                      @endforeach
                    </optgroup>
                  </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label for="tanggal">Tanggal Pengerjaan</label>
                <input type="date" name="tanggal" id="tanggal" value="{{date('Y-m-d')}}" class="form-control" required/>
              </div>
            </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createOrder()">Create Order</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modalJadwal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Jadwal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formJadwal">
          <input type="hidden" name="idorder" id="idorder" required/>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                  <label>Pilih Jadwal</label>
                  <select class="form-control" style="width: 100%;" name="jadwal" id="jadwal">
                    <optgroup label="Pilih Jadwal">
                      <option value="Pagi">Pagi</option>
                      <option value="Siang">Siang</option>
                      <option value="Sore">Sore</option>
                      <option value="Malam">Malam</option>
                    </optgroup>
                  </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <div class="form-group">
                <label for="tanggal">Req Jam</label>
                <input type="text" name="jam" id="jam" class="form-control" value="--:--" required/>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                  <label>Pilih Teknisi</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="teknisi" id="teknisi">
                    <optgroup label="Pilih Teknisi">
                      @foreach($teknisi as $tk)
                      <option value="{{$tk->id}}"> {{$tk->name}}</option>
                      @endforeach
                    </optgroup>
                  </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <div class="form-group">
                  <label>Pilih Helper</label>
                  <select class="form-control select2bs4" style="width: 100%;" name="helper" id="helper">
                    <optgroup label="Pilih Helper">
                      @foreach($helper as $hp)
                      <option value="{{$hp->id}}"> {{$hp->name}}</option>
                      @endforeach
                    </optgroup>
                  </select>
              </div>
            </div><!-- /.col -->
            
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submit-jadwal" onclick="cekJadwal()">Buat Jadwal</button>
        <button class="btn btn-primary float-right" id="btn-loading-jadwal" type="button" disabled>
          <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
          <span role="status">Loading...</span>
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="payment-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Payment Method</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idorder-payment" id="idorder-payment">
        <div class="form-group">
          <label>Pilih Metode Pembayaran</label>
          <select class="form-control" style="width: 100%;" name="method" id="method">
            <optgroup label="Pilih Metode">
              <option value="Cash">Cash</option>
              <option value="BCA">BCA</option>
              <option value="Mandiri">Mandiri</option>
              <option value="BRI">BRI</option>
              <option value="Termin">Termin</option>
              <option value="Pending">Pending</option>
            </optgroup>
          </select>
      </div>
      <div class="form-group" id="form-due_date">
        <label for="due_date">Tanggal Jatuh Tempo</label>
        <input type="date" name="due_date" id="due_date" class="form-control"/>
      </div>
      <div class="alert alert-info">
        <span class="fw-bold fst-italic">
          Order dianggap close/selesai, Apabila telah ada approval oleh admin Acoounting.
        </span>
      </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-proses-payment" onclick="prosesPayment()">Proses Payment</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modal-tax">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">TAX</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="idorder-tax" id="idorder-tax">
      <div class="form-group" id="form-due_date">
        <label for="ppn">Jumlah Pajak</label>
        <input type="number" name="ppn" id="ppn" class="form-control"/>
      </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-proses-tax" onclick="prosesTax()">Proses TAX</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


{{-- JS --}}
<script src="{{asset('/assets/js/order.js')}}"></script>
@endsection
