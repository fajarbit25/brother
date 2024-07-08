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
            <li class="breadcrumb-item"><a href="#">Employee</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
            <li class="breadcrumb-item">{{$user->nik}}</li>
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
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-text-width"></i>
                Detail Pendapatan
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <dl class="row">

                  <dt class="col-sm-4">Nama</dt>
                  <dd class="col-sm-8">: {{$user->name}}</dd>
                  <dt class="col-sm-4">Jabatan</dt>
                  <dd class="col-sm-8">: {{$user->nama_role}}</dd>

                  <dd class="col-sm-12"><hr/></dd>
                  <dt class="col-sm-4">Penghasilan</dt><dd class="col-sm-8"><hr/></dd>
                  <dt class="col-sm-4">Pokok</dt>
                  <dd class="col-sm-8">: {{number_format($user->pokok)}}</dd>
                  <dt class="col-sm-4">Makan</dt>
                  <dd class="col-sm-8">: {{number_format($user->makan)}}</dd>
                  <dt class="col-sm-4">Tunjangan</dt>
                  <dd class="col-sm-8">: {{number_format($user->tunjangan)}}</dd>
                  <dt class="col-sm-4">Lembur</dt>
                  <dd class="col-sm-8">: {{number_format($countlembur)}} X {{number_format($payroll->lembur)}} : {{number_format($countlembur*$payroll->lembur)}}</dd>

                  <dt class="col-sm-4 text-primary">Sub Total</dt>
                  @php
                  $lembur = $countlembur*$payroll->lembur;
                  $sub_total_1 = $user->pokok+$user->makan+$user->tunjangan+$lembur
                  @endphp
                  <dd class="col-sm-8">: <span class="text-primary"> <strong>{{number_format($sub_total_1)}}</strong> </span> </dd>
                  <dd class="col-sm-12"><hr/></dd>

                         
              </dl>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- ./col -->

        <!-- Left col -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-text-width"></i>
                Detail Pemotongan
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <dl class="row">
                  <dt class="col-sm-4"> <span class="text-warning">Bon</span> Karyawan</dt>
                  <dd class="col-sm-8">: <span class="text-warning">{{number_format($cashbon)}}</span> </dd>
                  <dt class="col-sm-4"> <span class="text-warning">Potongan</span> BPJS</dt>
                  <dd class="col-sm-8">: <span class="text-warning">{{number_format($user->bpjs)}}</span> </dd>
                  <dt class="col-sm-4"> <span class="text-warning">Potongan</span> Kehadiran</dt>
                  <dd class="col-sm-8">: <span class="text-warning">{{$kehadiran}} X {{number_format($payroll->kehadiran)}} : {{number_format($kehadiran*$payroll->kehadiran)}}</span> </dd>
                  <dt class="col-sm-4"> <span class="text-warning">Sub. Total</span></dt>
                  @php
                    $pot_bon = $cashbon;
                    $pot_absen = $kehadiran*50000;
                    $pot_bpjs = $user->bpjs;
                    $sub_total_2 = $pot_absen+$pot_bpjs+$pot_bon;
                  @endphp
                  <dd class="col-sm-8">: <span class="text-warning"> <strong> {{number_format($sub_total_2)}}</strong></span> </dd>
                  
                  <div class="col-sm-12 mb-3">
                    <h1 class="text-success">Grand Total <strong class="float-right">: Rp.{{number_format($sub_total_1-$sub_total_2)}}</strong></h1> 
                  </div>
                  <div class="col-sm-12">
                    <input type="hidden" name="idkaryawan" id="idkaryawan" value="{{$idkaryawan}}">
                    <input type="hidden" name="lembur" id="lembur" value="{{$countlembur*$payroll->lembur}}">
                    <input type="hidden" name="kehadiran" id="kehadiran" value="{{$kehadiran*$payroll->kehadiran}}">

                    @if($payroll->tag_paid == 0)
                      <button class="btn btn-success btn-sm float-right" id="btn-proses"><i class="bi bi-cash-coin"></i> Proses Pembayaran Gaji</button>
                    @else 
                      <button class="btn btn-info btn-sm float-right" disabled><i class="bi bi-cash-coin"></i> Proses Selesai</button>
                    @endif

                  </div>
                  <div class="col-sm-12 alert alert-info mt-3">
                    <strong><i class="bi bi-exclamation-triangle"></i> Noted.</strong>
                    <p>
                      <i>
                        Setelah gaji dibayarkan, <strong>klik proses pembayaran gaji</strong> agar history tercatat.
                      </i>
                    </p>
                  </div>

                         
              </dl>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- ./col -->


        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{$user->nik}} {{$user->name}} | {{$user->nama_role}}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool">
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
            <div class="card-body">
              <div class="table-responsive">
                <h5>Kehadiran</h5>
                <table class="table table-hover table-bordered m-0 mb-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Masuk</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>Lembur</th>
                        <th>Off</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensi as $a)
                    <tr>
                        <td>1</td>
                        <td>{{$a->tanggal}}</td>
                        <td>{{$a->jam_masuk}}</td>
                        <td>{{$a->jam_pulang}}</td>
                        <td> @if($a->masuk == 0) - @else {{$a->masuk}} @endif </td>
                        <td> @if($a->izin == 0) - @else {{$a->izin}} @endif </td>
                        <td> @if($a->alfa == 0) - @else {{$a->alfa}} @endif </td>
                        <td> @if($a->lembur == 0) - @else {{$a->lembur}} @endif </td>
                        <td> @if($a->off == 0) - @else {{$a->off}} @endif </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th colspan="4">Jumlah</th>
                        <th>{{$masuk}}</th>
                        <th>{{$izin}}</th>
                        <th>{{$alfa}}</th>
                        <th>{{$countlembur}}</th>
                        <th>{{$off}}</th>
                    </tr>
                </thead>
                </table>

                <h5>Cashbon</h5>
                <table class="table table-hover table-bordered m-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listCashbon as $li)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$li->tanggan}}</td>
                        <td>{{$li->jam}}</td>
                        <td>Rp.{{number_format($li->amount)}}</td>
                        <td> 
                          @if($li->approved == 1)
                            <span class="badge badge-success">Sukses</span> 
                          @else 
                            <span class="badge badge-warning">Pending</span> 
                          @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th colspan="4">Jumlah</th>
                        <th colspan="2">Rp.{{number_format($cashbon)}}</th>
                    </tr>
                </thead>
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
        <h4 class="modal-title">New Orders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Costumers</label>
                <select class="form-control form-control-sm select2bs4" style="width: 100%;">
                  <option selected="selected">Pilih Costumer</option>
                  <option>Yotta Pettarani</option>
                  <option>Pegadaian Bulukumba</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Type Order</label>
                <select class="form-control" style="width: 100%;">
                  <option selected="selected">Pilih Tipe Order</option>
                  <option>Komplain</option>
                  <option>Pasang Baru</option>
                  <option value="">Bongkar Pasang</option>
                  <option value="">Cleaning</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Jumlah Unit</label>
                <input type="text" name="qty" id="qty" class="form-control" required/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>PK / Paard Kracht</label>
                <select class="form-control" style="width: 100%;">
                  <option selected="selected">Pilih PK</option>
                  <option>0,5 PK</option>
                  <option>1 PK</option>
                  <option>1,5 PK</option>
                  <option>3 PK</option>
                  <option>4 PK</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Lantai</label>
                <input type="text" name="floor" id="floor" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Ruangan</label>
                <input type="text" name="room" id="room" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Harga Jasa</label>
                <input type="text" name="price" id="price" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Teknisi</label>
                <select class="form-control select2bs4" style="width: 100%;">
                  <option selected="selected">Pilih Teknisi</option>
                  <option>Dimas</option>
                  <option>Anton</option>
                  <option>Rasdi</option>
                </select>
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
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="{{asset('/assets/js/payroll.js')}}"></script>
@endsection
