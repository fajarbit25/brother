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
            <li class="breadcrumb-item"><a href="{{url('/inventory/outbound')}}">Inventory</a></li>
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
              <h3 class="card-title">Detail Reservasi</h3>

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
                  <tbody>
                  <tr>
                    <td><strong class="float-right">Tanggal</strong></td>
                    <td>: {{$item->reservasi_date}} </td>
                    <td><strong class="float-right">Reservasi Id</strong></td>
                    <td>: {{$item->reservasi_id}}</td>
                  </tr>
                  <tr>
                    <td><strong class="float-right">Order Id</strong></td>
                    <td>: {{$item->uuid}}</td>
                    <td><strong class="float-right">Costumers</strong></td>
                    <td>: {{$item->costumer_name}}</td>
                  </tr>
                  <tr>
                    <td><strong class="float-right">Teknisi</strong></td>
                    <td>: {{$item->name}}</td>
                    <td><strong class="float-right">Status Approved</strong></td>
                    <td>: 

                      @if($item->reservasi_approved == 0) <span class="badge badge-warning">Pending</span>  
                      @else <span class="badge badge-success">Approved</span>
                      @endif
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              {{-- <a href="#" class="btn btn-sm btn-info float-left">Place New Inbound</a> --}}
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-12">

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">List Reservasi Material</h3>
  
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
                      <th>Penerima</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($result as $r)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td> {{$r->product_code}} </td>
                      <td> {{$r->product_name}} </td>
                      <td>{{number_format($r->qty)}}</td>
                      <td> {{$r->name}} </td>
                    </tr>
                    @endforeach
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
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
