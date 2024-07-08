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

        <div class="col-sm-12" id="filter">
          <div class="card">
            <div class="card-header border-transparent">
              <div class="card-body">
                <p>Filter <code>.Karyawan .Periode</code></p>
                <div class="input-group">
                  <select name="karyawan" id="karyawan" class="form-control select2bs4">
                    <optgroup label="Pilih Karyawan">
                      @foreach($user as $u)
                      <option value="{{$u->id}}">{{$u->name}} | {{$u->nama_role}}</option>
                      @endforeach
                    </optgroup>
                  </select>
                  <select name="bulan" id="bulan" class="form-control">
                    <optgroup label="Pilih Bulan">
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </optgroup>
                  </select>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" onclick="filterProses()">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Catatan Bon Karyawan</h3>

              <div class="card-tools">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left"  data-toggle="modal" data-target="#modal-xl">Place New Transactions</a>
                <button type="button" class="btn btn-tool" onclick="filter()">
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
                    <th>Karyawan</th>
                    <th>Level</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Amount</th>
                    <th>Pelunasan</th>
                    <th>Status</th>
                    <th>Alasan</th>
                    <th>Delete</th>

                  </tr>
                  </thead>
                  <tbody id="table-cashbon">
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
        <h4 class="modal-title">Bon Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                  <label for="user_id">Karyawan</label>
                  <select name="user_id" id="user_id" class="form-control select2bs4">
                    @foreach($user as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
                    @endforeach
                  </select>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" id="amount" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label for="alasan_cashbon">Alasan Cashbon</label>
                <input type="text" name="alasan_cashbon" id="alasan_cashbon" class="form-control" required/>
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

<script src="{{asset('/assets/js/cashbon.js')}}"></script>
@endsection
