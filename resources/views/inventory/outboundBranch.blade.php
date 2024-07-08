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
        <div class="col-md-12" id="formFilter">
          <div class="card">
            <div class="card-body">
              <div class="input-group input-group-sm">
                <input type="date" id="start" class="form-control" title="Tanggal Mulai">
                <input type="date" id="end" class="form-control" title="Sampai Tanggal">
                <span class="input-group-append">
                  <button type="button" id="btn-filter" class="btn btn-primary btn-flat"><i class="bi bi-funnel"></i> Filter</button>
                </span>
              </div>
            </div>
          </div>  
        </div><!-- /.col -->
        <div class="col-md-12">

          <!-- TABLE: LATEST INBOUND -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{$title}}</h3>

              <div class="card-tools">
                <button type="button" onclick="modalBranch()" class="btn btn-tool">
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
                    <th>Tanggal</th>
                    <th>No. Referense</th>
                    <th>Tujuan</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Manage</th>
                  </tr>
                  </thead>
                  <tbody id="table-branch">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <a href="/inventory/outbound/branch/received" class="btn btn-sm btn-info float-left">Terima Barang <i class="bi bi-arrow-right"></i></a>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Kirim Antar Cabang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST">
            <input type="hidden" name="inbound_id" id="inbound_id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="branch">Cabang Tujuan</label>
                        <select name="branch" id="branch" class="form-control">
                            @foreach($branch as $br)
                                <option value="{{$br->idbranch}}" @if($br->idbranch == Auth::user()->branch_id) disabled @endif>{{$br->idbranch}}. {{$br->branch_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <select name="product" id="product" class="form-control select2bs4">
                            @foreach($product as $pr)
                                <option value="{{$pr->diproduct}}">{{$pr->product_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control">
                    </div>
                </div>
              
            </div><!-- /. row -->
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-send-branch">Submit</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

{{-- Js --}}
<script src="{{asset('/assets/js/outbound.js')}}"></script>
@endsection
