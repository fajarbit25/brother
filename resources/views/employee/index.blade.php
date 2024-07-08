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

        <div class="col-md-12" id="formSearch">
          <div class="card">
            <div class="card-body">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" onkeyup="cari(this.value)" placeholder="Cari Karyawan..">
                <span class="input-group-append">
                  <button type="button" class="btn btn-secondary btn-flat" onclick="closeSearchForm()"><i class="bi bi-x-lg"></i></button>
                  <button type="button" class="btn btn-info btn-flat"><i class="bi bi-search"></i></button>
                </span>
              </div>
            </div>
          </div>  
        </div><!-- /.col -->

        <div class="col-md-12">
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">
                <button type="button" class="btn btn-tool" onclick="openSearchForm()">
                  <i class="bi bi-search"></i>
              </button>
              Data Karyawan
            </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="openModalCreate()">
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
              <div class="table-responsive" id="employee-table">
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
        <h4 class="modal-title">New Employee</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formEmployee">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span> </label>
                <input type="text" name="name" id="name" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-4">
              <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-4">
              <div class="form-group">
                <label>No. Handphone <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-4">
              <div class="form-group">
                <label>Role</label>
                <select class="form-control form-control-sm select2bs4" style="width: 100%;" id="role" name="role">
                  @foreach($role as $rol)
                  <option value="{{$rol->idrole}}" @if($rol->idrole <= Auth::user()->privilege) disabled @endif>{{$rol->idrole.'. '. $rol->kode_role.' '.$rol->nama_role}}</option>
                  @endforeach
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Cabang <span class="text-danger">*</span></label>
                <select class="form-control" style="width: 100%;" id="branch" name="branch">
                  @foreach($branch as $br)
                  <option value="{{$br->idbranch}}">{{$br->idbranch}}. {{$br->branch_name}}</option>
                  @endforeach
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-control" style="width: 100%;" id="gender" name="gender">
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Pendidikan <span class="text-danger">*</span></label>
                <select class="form-control" style="width: 100%;" id="pendidikan" name="pendidikan">
                  <option value="SD">1. SD</option>
                  <option value="SMP">2. SMP</option>
                  <option value="SMA">3. SMA</option>
                  <option value="SMK">4. SMK</option>
                  <option value="D3">5. D3</option>
                  <option value="S1">6. S1</option>
                  <option value="S2">7. S2</option>
                  <option value="S3">8. S3</option>
                  <option value="Non-Formal">9. Non-Formal</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>NIK<span class="text-danger">*</span></label>
                <input type="text" name="nik" id="nik" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>KK<span class="text-danger">*</span></label>
                <input type="text" name="kk" id="kk" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Kontak Darurat<span class="text-danger">*</span></label>
                <input type="text" name="telpon_darurat" id="telpon_darurat" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tempat Lahir<span class="text-danger">*</span></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tanggal Lahir<span class="text-danger">*</span></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alamat<span class="text-danger">*</span></label>
                <textarea name="alamat" id="alamat" rows="2" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submit" onclick="submitEmployee()">Submit</button>

        <button class="btn btn-primary" id="btn-loading" type="button" disabled>
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

{{-- Js --}}
<script src="{{asset('assets/js/employee.js')}}"></script>
@endsection
