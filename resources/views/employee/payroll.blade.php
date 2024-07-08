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
              <h3 class="card-title">Payroll Karyawan</h3>

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
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th>Pokok</th>
                        <th>Makan</th>
                        <th>Tunjangan</th>
                        <th>BPJS</th>
                        <th>Nilai Lembur / H</th>
                        <th>Pot. Kehadiran / H</th>
                        <th>Status</th>
                        <th>
                          Manage 
                          @if($cek_paid != 0)
                            <button id="btn-reset" class="btn btn-primary btn-xs" onclick="resetPaid(1)"><i class="bi bi-arrow-repeat"></i> Reset</button>
                          @endif
                        </th>
                    </tr>
                </thead>
                <tbody id="table-payroll">
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
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Data Karyawan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">
            <input type="hidden" name="id" id="id">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" name="nama" id="nama" class="form-control" disabled/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" disabled/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pokok">Gaji Pokok</label>
                <input type="text" name="pokok" id="pokok" class="form-control" required/>
              </div>
            </div><!-- /.col -->

            <div class="col-sm-6">
              <div class="form-group">
                <label for="makan">Uang Makan</label>
                <input type="text" name="makan" id="makan" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="tunjangan">Tunjangan</label>
                <input type="text" name="tunjangan" id="tunjangan" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="bpjs">Potongan BPJS</label>
                <input type="text" name="bpjs" id="bpjs" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="lembur">Nilai Lembur / H</label>
                <input type="text" name="lembur" id="lembur" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kehadiran">Pot. Kehadiaran / H</label>
                <input type="text" name="kehadiran" id="kehadiran" class="form-control" required/>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update()" id="btn-update">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="{{asset('/assets/js/payroll.js')}}"></script>
@endsection
