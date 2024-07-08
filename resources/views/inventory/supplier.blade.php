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

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Data Supplier</h3>

              <div class="card-tools">
                <a href="javascript:void(0)" onclick="modalSupplier()" class="btn btn-sm btn-info float-left">Place New Supplier</a>
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
              <div class="table-responsive" id="table-supplier">
                
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

{{-- Modal --}}
<!-- Modal -->
<div class="modal fade" id="modal-supplier">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="supplierForm">
            <input type="hidden" name="idsupplier" id="idsupplier">
            <div class="row">
  
                <div class="col-sm-4">
                    <div class="form-group">
                      <label for="supplier_code">Kode Supplier <span class="text-info">(Max 5 Huruf)</span> </label>
                      <input type="text" name="supplier_code" id="supplier_code"  class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="supplier_name">Nama Supplier</label>
                        <input type="text" name="supplier_name" id="supplier_name" class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="supplier_phone">Telephone</label>
                        <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="supplier_email">Email Address</label>
                        <input type="text" name="supplier_email" id="supplier_email" class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="supplier_description">Description</label>
                        <input type="text" name="supplier_description" id="supplier_description" class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="supplier_address">Address</label>
                        <textarea name="supplier_address" id="supplier_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
              
            </div><!-- /. row -->
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-submit" onclick="createSupplier()">Create Supplier</button>
          <button type="button" class="btn btn-success" id="btn-update" onclick="updateSupplier()">Update Supplier</button>
          <button class="btn btn-primary float-right" id="btn-loading" type="button" disabled>
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

<!-- Modal Edit -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="bi bi-trash3"></i> Hapus Supplier?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-footer justify-content-between">
          <input type="hidden" name="delete_id" id="delete_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
          <button type="button" class="btn btn-danger" id="btn-delete" onclick="deleteSupplier()">Hapus</button>
          <button class="btn btn-danger float-right" id="btn-loading-delete" type="button" disabled>
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


{{-- js --}}
<script src="{{asset('/assets/js/supplier.js')}}"></script>
@endsection
