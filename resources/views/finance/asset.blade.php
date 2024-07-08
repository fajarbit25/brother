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
                    <th>Kendaraan Roda</th>
                    <th>Tipe</th>
                    <th>Merk</th>
                    <th>Nomor Plat</th>
                    <th>Tahun Buatan</th>
                    <th>Kondisi</th>
                    <th>Edit</th>
                  </tr>
                  </thead>
                  <tbody id="table-asset">
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
          <h4 class="modal-title">Edit Asset</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="form-edit">
            <input type="hidden" name="idasset" id="idasset">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="rodaEdit">Kendaraan Roda</label>
                  <select class="form-control" style="width: 100%;" name="rodaEdit" id="rodaEdit">
                    <optgroup label="Pilih">
                      <option value="Roda 2">Roda 2</option>
                      <option value="Roda 4">Roda 4</option>
                    </optgroup>
                  </select>
                </div>
              </div><!-- /.col -->
              <div class="col-sm-6">
                  <div class="form-group">
                    <label for="merkEdit">Merk Kendaraan</label>
                    <input type="text" name="merkEdit" id="merkEdit" class="form-control" required/>
                  </div>
                </div><!-- /.col -->
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="tipeEdit">Tipe Kendaraan</label>
                  <input type="text" name="tipeEdit" id="tipeEdit" class="form-control" required/>
                </div>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="platEdit">Nomor Plat</label>
                  <input type="text" name="platEdit" id="platEdit" class="form-control" required/>
                </div>
              </div><!-- /.col --> 
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="tahunEdit">Tahun Pembuatan</label>
                  <input type="text" name="tahunEdit" id="tahunEdit" class="form-control" required/>
                </div>
              </div><!-- /.col --> 
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="kondisiEdit">Kondisi</label>
                  <input type="text" name="kondisiEdit" id="kondisiEdit" class="form-control" required/>
                </div>
              </div><!-- /.col --> 
               
            </div><!-- /. row -->
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-edit" onclick="editAsset()">Update Data</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-asset">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Asset</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="form-asset">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="roda">Kendaraan Roda</label>
                <select class="form-control" style="width: 100%;" name="roda" id="roda">
                  <optgroup label="Pilih">
                    <option value="Roda 2">Roda 2</option>
                    <option value="Roda 4">Roda 4</option>
                  </optgroup>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="form-group">
                  <label for="merk">Merk Kendaraan</label>
                  <input type="text" name="merk" id="merk" class="form-control" required/>
                </div>
              </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="tipe">Tipe Kendaraan</label>
                <input type="text" name="tipe" id="tipe" class="form-control" required/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="plat">Nomor Plat</label>
                <input type="text" name="plat" id="plat" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="tahun">Tahun Pembuatan</label>
                <input type="text" name="tahun" id="tahun" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kondisi">Kondisi</label>
                <input type="text" name="kondisi" id="kondisi" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
             
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-asset" onclick="simpanAsset()">Simpan Data</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- js --}}
<script src="{{asset('/assets/js/finance.js')}}"></script>
@endsection
