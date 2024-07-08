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
                <h3 class="card-title">Form</h3>
  
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
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <div class="form-group">
                      <label for="supplier_name">Supplier</label>
                      <input type="text" name="supplier_name" id="supplier_name" value="{{$inbound->supplier_name}}" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="product">Products</label>
                      <select class="form-control select2bs4" style="width: 100%;" name="product" id="product">
                        <option selected="selected">Pilih Product</option>
                        @foreach($produk as $pro)
                        <option value="{{$pro->diproduct}}">{{$pro->product_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div><!-- /.col --> 
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="qty">Qty</label>
                      <input type="text" name="qty" id="qty" class="form-control" required/>
                    </div>
                  </div><!-- /.col -->   
                </div><!-- /.row -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <input type="hidden" name="inboundID" id="inboundID" value="{{$inbound->id}}">
                <button type="button" id="btn-add-item" class="btn btn-sm btn-info float-right"><i class="bi bi-plus-lg"></i> Tambahkan </button>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div><!-- /.col -->

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">List Products</h3>

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
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga Beli</th>
                    <th>Subtotal</th>
                    <th>Delete</th>
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
              <a href="javascript:void(0)" onclick="setClose({{$inbound->id}})" id="btn-save" class="btn btn-sm btn-success float-left">Simpan Data</a>
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

{{-- Js --}}
<script src="{{asset('/assets/js/inbound.js')}}"></script>
@endsection
