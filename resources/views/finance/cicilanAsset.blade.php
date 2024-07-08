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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Data Asset</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="col-sm-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Nama Asset : </strong> {{$asset->merk}}
                            </li>
                            <li class="list-group-item">
                                <strong>Plat Nomor : </strong> {{$asset->plat}}
                            </li>
                            <li class="list-group-item">
                                Noted : <i>Apabila data telah disimpan, maka setiap pembayaran yang dilakukan pada modul ini akan mengurangi nilai kas perusahaan secara otomatis.</i>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer clearfix">
                </div>
            </div>
        </div>

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{$title}}</h3>

              <div class="card-tools">
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
                    <th>Jatuh Tempo</th>
                    <th>Pembiayaan</th>
                    <th>Jumlah Angsuran</th>
                    <th>Lunas</th>
                    <th>Bayar</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody id="table-form">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <input type="hidden" name="asset_id" id="asset_id" value="{{$asset_id}}">
                @if($tag_lock == 0)
                
                @else 
                    <button class="btn btn-primary" id="btn-simpan-data" onclick="simpanData({{$asset_id}})">Simpan Data</button>
                    
                @endif
                <button type="button" onclick="tambahBaris({{$asset_id}})" id="btn-tambah" class="btn btn-success btn-sm float-right">
                      <i class="bi bi-plus-lg"></i> Tambah Baris
                </button>
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



{{-- js --}}
<script src="{{asset('/assets/js/finance.js')}}"></script>
@endsection
