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
              <h3 class="card-title">Form Absensi</h3>

              <div class="card-tools">
                @if($cek != 0)
                    <button type="button" id="btn-add" class="btn btn-tool btn-success" title="Absensi">
                        <i class="bi bi-plus-lg"></i> Add
                    </button>
                @else
                    <button type="button" id="btn-new" class="btn btn-tool" title="Buat Absensi">
                    <i class="bi bi-plus-lg"></i>
                    </button>
                @endif
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
              <div class="table-responsive" id="data-table">
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
<div class="modal fade" id="modal-new">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buat Absensi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label>Tanggal Absen</label>
                <input type="date" name="tanggal-new" id="tanggal-new" class="form-control" value="{{date('Y-m-d')}}" required readonly/>
              </div>
            </div><!-- /.col --> 

          </div><!-- /. row -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btn-create">Create</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Absensi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
  
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="karyawan">Karyawan</label>
                    <select name="karyawan" id="karyawan" class="form-control select2bs4">
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="absensi">Tanggal Absen</label>
                    <select name="absensi" id="absensi" class="form-control">
                        <option value="masuk">Masuk</option>
                        <option value="izin">Izin</option>
                        <option value="alfa">Alfa</option>
                        <option value="off">Off</option>
                    </select>
                </div>
            </div><!-- /.col --> 
  
            </div><!-- /. row -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="btn-added">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
<div class="modal fade" id="modal-lembur">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Lembur</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
            <input type="hidden" name="idabsen" id="idabsen">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="jam">Batas Jam Lembur</label>
                    <input type="time" name="jam" id="jam" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                  <label for="alasan_lembur">Alasan Lembur</label>
                  <input type="text" name="alasan_lembur" id="alasan_lembur" class="form-control" autocomplete="off">
              </div>
          </div>
  
            </div><!-- /. row -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-lembur">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  

{{-- Javascript --}}
<script src="{{asset('/assets/js/absensi.js')}}"></script>
@endsection
