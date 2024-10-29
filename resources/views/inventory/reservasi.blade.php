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

            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Reservasi Material</h3>

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
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Nama Order</label>
                    <select class="form-control select2bs4" style="width: 100%;" id="orderId">
                        <option value="">--Pilih Order--</option>
                      @foreach($order as $or)
                      <option value="{{$or->idorder}}" >{{$or->uuid}} {{$or->costumer_name}} | {{$or->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- /.col -->  

                <div class="col-md-8">
                    <div class="form-group">
                    <label>Nama Barang</label>
                    <select class="form-control select2bs4" style="width: 100%;" id="product">
                        <option value="">--Pilih Material--</option>
                      @foreach($product as $p)
                        <option value="{{$p->diproduct}}">{{$p->product_code}} | {{$p->product_name}} </option>
                      @endforeach
                    </select>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="stockAkhir">Stock</label>
                    <input type="number" name="stockAkhir" id="stockAkhir" class="form-control" autocomplete="off" disabled/>
                  </div>  
                </div><!-- / .col -->

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="qty">Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control" autocomplete="off" required/>
                  </div>  
                </div><!-- / .col -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="bi bi-plus-lg"></i> Tambahkan</button>
                <button class="btn btn-primary float-right" id="btn-loading" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status">Loading...</span>
                </button>
            </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">List Product Reservasi</h3>

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
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Remove</th>
                  </tr>
                  </thead>
                  <tbody id="table-reservasi">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <div class="row">
              <div class="col-sm-12">
                  
                <!--<button  class="btn btn-success float-right" id="btn-submit">Submit Data</button>-->
                <!--<button class="btn btn-success float-right" id="btn-loading-submit" type="button" disabled>-->
                <!--  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>-->
                <!--  <span role="status">Loading...</span>-->
                <!--</button>-->
                
              </div><!-- /.col -->

              </div><!-- /.row -->
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
<script src="{{asset('/assets/js/reservasi.js?v=1.4')}}"></script>
@endsection

