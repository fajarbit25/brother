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
            <li class="breadcrumb-item"><a href="{{url('/inventory/inbound')}}">Inventory</a></li>
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

        <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              Delivery Order membutuhkan approval Owner...
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="bi bi-app"></i> Brother Tech Indonesia
                    <small class="float-right">Date: {{$inbound->tanggal}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{$inbound->supplier_name}}</strong><br>
                    {{$inbound->supplier_address}}
                    <br/>
                    Phone: {{$inbound->supplier_phone}}<br>
                    Email: {{$inbound->supplier_email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>CV. Brother Tech Indonesia</strong><br>
                    Jl. Rappokalling Raya 1 
                    No. 8 Makassar, Sulawesi Selatan <br/>
                    Phone: 0811-1266-639<br>
                    Email: Brothertechindonesia@gmail.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Delivery Order : {{$inbound->do}}</b><br>
                  <br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($result as $r)
                      <tr>
                        <td>{{number_format($r->qty)}}</td>
                        <td>{{$r->product_name}}</td>
                        <td>{{number_format($r->price)}}</td>
                        <td>{{number_format($r->jumlah)}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Catatan.</p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Setelah di Approve Stock Akan masuk ke Inventory.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{number_format($total)}}</td>
                      </tr>
                      <tr>
                        <th>Tax (0%)</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>{{number_format($total)}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <input type="hidden" name="idinbound" id="idinbound" value="{{$inbound->id}}">
                  <a href="/inventory/inbound" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali </a>
                  @if(Auth::user()->privilege == 1 || Auth::user()->privilege == 2)
                  <button type="button" id="btn-approve" class="btn btn-success float-right"><i class="bi bi-check-circle"></i>
                    Approve
                  </button>
                  <button type="button" class="btn btn-danger float-right" id="btn-cancel" style="margin-right: 5px;">
                    <i class="bi bi-x-circle"></i> Cancel
                  </button>
                  @elseif(Auth::user()->privilege == 2 || Auth::user()->privilege == 3)
                  <button type="button" class="btn btn-danger float-right" id="btn-cancel" style="margin-right: 5px;">
                    <i class="bi bi-x-circle"></i> Cancel
                  </button>
                  @endif
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->

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
