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

        <div class="col-md-12" id="formSearch">
          <div class="card">
            <div class="card-body">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" onkeyup="cari(this.value)" placeholder="Cari Product..">
                <span class="input-group-append">
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
                <button type="button" class="btn btn-tool" onclick="formSearch()">
                  <i class="bi bi-search"></i>
                </button>
                Products
              </h3>

              <div class="card-tools">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left" onclick="modalProduct()">Place New Product</a>
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
              <div class="table-responsive" id="table-product">
                
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
<div class="modal fade" id="modal-product">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Product</h4>
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
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name"  class="form-control" autocomplete="off" required/>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                      <label for="satuan">Satuan</label>
                      <select name="satuan" id="satuan" class="form-control">
                        @foreach($unit as $u)
                        <option value="{{$u->idunit}}">{{$u->unit_code.' - '.$u->unit_name}}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="cat">Category</label>
                    <select name="cat" id="cat" class="form-control">
                      @foreach($category as $cat)
                      <option value="{{$cat->idcat}}">{{$cat->category_code}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
              <div class="col-sm-6">
                  <div class="form-group">
                      <label for="harga_beli">Harga</label>
                      <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="0" autocomplete="off" required/>
                  </div>
              </div>
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submit" onclick="createProduct()">Create Product</button>
        <button type="button" class="btn btn-success" id="btn-update" onclick="updateProduct()">Update Product</button>
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

<!-- Modal -->
<div class="modal fade" id="modal-delete">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="bi bi-trash3"></i> Hapus Product?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer justify-content-between">
        <input type="hidden" name="delete_id" id="delete_id">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
        <button type="button" class="btn btn-danger" id="btn-delete" onclick="destroyProduct()">Hapus</button>
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
{{-- Js --}}
<script src="{{asset('/assets/js/product.js?v='.time())}}"></script>
@endsection
