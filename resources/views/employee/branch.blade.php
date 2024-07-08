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
              <h3 class="card-title">
                <button type="button" class="btn btn-tool" onclick="openSearchForm()">
                  <i class="bi bi-search"></i>
              </button>
              {{$title}}
            </h3>

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
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id</th>
                            <th>Nama Cabang</th>
                            <th>Alamat</th>
                            <td>Manage</td>
                        </tr>
                    </thead>
                    <tbody id="table-branch"></tbody>
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
<div class="modal fade" id="modal-branch">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Cabang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="">
            <input type="hidden" name="idbranch" id="idbranch">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="id_office">Id Office <span class="text-danger">*</span> </label>
                <input type="text" name="id_office" id="id_office" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label for="branch_name">Nama Branch <span class="text-danger">*</span></label>
                <input type="text" name="branch_name" id="branch_name" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label for="branch_address">Alamat<span class="text-danger">*</span></label>
                <textarea name="branch_address" id="branch_address" rows="2" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btn-update-branch">Update</button>


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
