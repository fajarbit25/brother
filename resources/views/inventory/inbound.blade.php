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

          <!-- TABLE: LATEST INBOUND -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Products</h3>

              <div class="card-tools">
                  @if($cekInbound != 0)
                  <a href="/inventory/inbound/new" class="btn btn-sm btn-info float-left">Place New Inbound</a>
                  @else 
                  <a href="#" class="btn btn-sm btn-info float-left" id="btn-inbound">Place New Inbound</a>
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
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Delivery Order</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Approved</th>
                    <th>Processing</th>
                    <th>Payment Status</th>
                    <th>Branch</th>
                  </tr>
                  </thead>
                  <tbody id="table-inbound">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              

              <a href="/inventory/inbound/report" class="btn btn-success btn-sm float-right"><i class="bi bi-flag"></i> Laporan Inbound</a>
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
<div class="modal fade" id="modal-inbound">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Inbound</h4>
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
                <label>Supplier</label>
                <select class="form-control select2bs4" style="width: 100%;" name="supplier" id="supplier">
                  <option>Pilih Supplier</option>
                  @foreach($supplier as $sup)
                  <option value="{{$sup->idsupplier}}">{{$sup->supplier_name}}</option>
                  @endforeach

                </select>
              </div>
            </div><!-- /.col -->
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btn-create">Buat Pesanan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Delivery Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="">
          <input type="hidden" name="inbound_id" id="inbound_id">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label for="do">Delivery Order</label>
                <input type="text" name="do" id="do" class="form-control">
              </div>
            </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="updateDo()" id="btn-update">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- Js --}}
<script src="{{asset('/assets/js/inbound.js?v='.time())}}"></script>
@endsection

