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
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
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
        <div class="col-md-6">

          <!-- TABLE: LATEST INBOUND -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Satuan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="modalSatuan()">
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
                    <th>Satuan Kode</th>
                    <th>Satuan Nama</th>
                    <th>Manage</th>
                  </tr>
                  </thead>
                  <tbody id="table-satuan">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>

            <div class="card-footer">

            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


        <!-- Left col -->
        <div class="col-md-6">

            <!-- TABLE: LATEST INBOUND -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Category</h3>
  
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="modalCategory()">
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
                      <th>Category Code</th>
                      <th>Category Name</th>
                      <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody id="table-category">
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              
              <div class="card-footer">

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
<div class="modal fade" id="modal-satuan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Satuan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="productForm">
          <input type="hidden" name="diproduct" id="diproduct">
          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label for="unit_code">Kode Satuan</label>
                <input type="text" name="unit_code" id="unit_code" class="form-control"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-12">
                <div class="form-group">
                  <label for="unit_name">Nama Satuan</label>
                  <input type="text" name="unit_name" id="unit_name" class="form-control"/>
                </div>
            </div><!-- /.col -->
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btn-create-satuan">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-satuan-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Satuan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="productForm">
            <input type="hidden" name="idsatuan" id="idsatuan">
            <div class="row">
  
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="unit_code_edit">Kode Satuan</label>
                  <input type="text" name="unit_code_edit" id="unit_code_edit" class="form-control"/>
                </div>
              </div><!-- /.col -->
              <div class="col-sm-12">
                  <div class="form-group">
                    <label for="unit_name_edit">Nama Satuan</label>
                    <input type="text" name="unit_name_edit" id="unit_name_edit" class="form-control"/>
                  </div>
              </div><!-- /.col -->
              
            </div><!-- /. row -->
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-update-satuan">update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-category">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label for="category_code">Kode Kategory</label>
                <input type="text" name="category_code" id="category_code" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label for="category_name">Nama Katergory</label>
                  <input type="text" name="category_name" id="category_name" class="form-control">
                </div>
              </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btn-create-category">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-category-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="">
            <input type="hidden" name="idcat" id="idcat">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="category_code_edit">Kode Kategory</label>
                  <input type="text" name="category_code_edit" id="category_code_edit" class="form-control">
                </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="category_name_edit">Nama Katergory</label>
                    <input type="text" name="category_name_edit" id="category_name_edit" class="form-control">
                  </div>
                </div>
              
            </div><!-- /. row -->
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-update-category">Update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

{{-- Js --}}
<script src="{{asset('/assets/js/inbound.js')}}"></script>
@endsection

