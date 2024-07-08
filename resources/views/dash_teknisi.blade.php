@extends('template.layout_teknisi')
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
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="bi bi-cart4"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Orders</span>
              <span class="info-box-number">
                {{$order}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-wallet2"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Cashbon</span>
              <span class="info-box-number">{{number_format($cashbon)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="bi bi-calendar-week"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Absen</span>
              <span class="info-box-number">{{$absen}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="bi bi-exclamation-octagon"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Komplain</span>
              <span class="info-box-number">{{$komplain}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <div class="col-md-12"> 
          {{-- Nofitiation --}}
          @if($notif_order != 0)
          <a href="{{url('/teknisi/order')}}">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><i class="bi bi-cart4"></i> Halo {{Auth::user()->name}}!</strong> {{$notif_order}} Order perlu di Pickup...<br/>
            </div>
          </a>
          @endif

          @if($notif_inbound != 0)
          <a href="{{url('/teknisi/material')}}">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong><i class="bi bi-tools"></i> Halo {{Auth::user()->name}}!</strong> {{$notif_inbound}} Material perlu di Approve...<br/>
            </div>
          </a>
          @endif

          @if($notif_cashbon != 0)
          <a href="{{url('/teknisi/cashbon')}}">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong><i class="bi bi-wallet2"></i> Halo {{Auth::user()->name}}!</strong> {{$notif_cashbon}} Cashbon perlu di Approve...<br/>
            </div>
          </a>
          @endif

          {{-- End Nofitiation --}}
        </div>
        <!-- /.col -->

        <div class="col-md-12 mb-5">
          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Active Orders</h3>

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
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($result as $r)
                <li class="item">
                  <div class="product-img">
                    <img src="{{asset('/storage/logo/logo-bti.jpg')}}" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{$r->uuid}}
                      {{-- <span class="badge badge-warning float-right">$1800</span> --}}
                      @if($r->progres == 'Delivered')<span class="badge badge-secondary float-right">{{$r->progres}}</span> 
                      @elseif($r->progres == 'Created')<span class="badge badge-secondary float-right">{{$r->progres}}</span>
                      @elseif($r->progres == 'Pickup')<span class="badge badge-info float-right">{{$r->progres}}</span> 
                      @elseif($r->progres == 'Processing')<span class="badge badge-info float-right">{{$r->progres}}</span> 
                      @elseif($r->progres == 'Pending')<span class="badge badge-warning float-right">{{$r->progres}}</span> 
                      @elseif($r->progres == 'Cancel')<span class="badge badge-danger float-right">{{$r->progres}}</span>
                      @elseif($r->progres == 'Closing')<span class="badge badge-info float-right">{{$r->progres}}</span> 
                      @elseif($r->progres == 'Complete')<span class="badge badge-success float-right">{{$r->progres}}</span>
                      @endif
                    </a>
                    <span class="product-description">
                      <strong>{{$r->costumer_name}}</strong> {{$r->costumer_address}}
                    </span>
                  </div>
                </li>
                @endforeach
                
                
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>


      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
