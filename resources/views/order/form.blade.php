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
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active">Active Orders</li>
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

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Projects Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <strong>ID Order : </strong> {{$order->uuid}} <br/>
                      <strong>Costumer Name : </strong> {{$costumers->costumer_name}} <br/>
                      <strong>Costumer Address : </strong> {{$costumers->costumer_address}} <br/>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                      <strong>PIC Name : </strong> {{$costumers->costumer_pic}} <br/>
                      <strong>Costumer Contact : </strong> {{$costumers->costumer_phone}} <br/>
                      <strong>Costumer Email : </strong> {{$costumers->costumer_email}} <br/>
                    </div><!-- /.col -->
                  </div>
                    {{-- row --}}
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="#" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-xl"><i class="bi bi-plus"></i> Tambahkan Item</a>
                </div>
            </div>
            <!-- /.card -->

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Projects Result</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="tableForm">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <button onclick="modalcancel()" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Cancel Order</button>

                  @if($order->progres == 'New')
                  <button type="button" class="btn btn-success float-right" id="btn-submit" onclick="submitOrder({{$costumers->idorder}})">Submit Order</button>
                  <button class="btn btn-success float-right" id="btn-loading" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                  </button>
                  @else 
                  <a href="/order" class="btn btn-warning btn-sm float-right"><i class="bi bi-arrow-left"></i> Back to Order</a>
                  @endif
                </div>
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
<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Orders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formItem">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Type Order</label>
                <input type="hidden" name="uuid" id="uuid" value="{{$order->uuid}}">
                <select class="form-control" style="width: 100%;" name="item" id="item">
                  <optgroup label="Pilih Item">
                    @foreach($item as $itm)
                      <option value="{{$itm->iditem}}"> {{$itm->iditem.'. '.$itm->item_name}} </option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>PK / Paard Kracht</label>
                <select class="form-control" style="width: 100%;" name="pk" id="pk">
                  <option value="0,5 PK">0,5 PK</option>
                  <option value="0,75 PK">0,75 PK</option>
                  <option value="1 PK">1 PK</option>
                  <option value="1,5 PK">1,5 PK</option>
                  <option value="2 PK">2 PK</option>
                  <option value="2,5 PK">2,5 PK</option>
                  <option value="3 PK">3 PK</option>
                  <option value="3,5 PK">3,5 PK</option>
                  <option value="4 PK">4 PK</option>
                  <option value="4,5 PK">4,5 PK</option>
                  <option value="5 PK">5 PK</option>
                  <option value="6 PK">6 PK</option>
                  <option value="10 PK">10 PK</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label for="merk">Merk</label>
                <select name="merk" id="merk" class="form-control">
                  @foreach($merk as $m)
                  <option value="{{$m->merk_name}}">{{$m->merk_name}}</option>
                  @endforeach
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Jumlah Unit</label>
                <input type="number" name="qty" id="qty" class="form-control" value="1" required/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Harga Jasa</label>
                  <input type="number" name="price" id="price" class="form-control" required/>
                </div>
            </div><!-- /.col --> 
            <div class="col-sm-4">
              <div class="form-group">
                <label>Discount</label>
                <input type="number" name="disc" id="disc" class="form-control" value="0" required/>
              </div>
            </div><!-- /.col --> 
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addOrder()">Tambahkan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="modal-cancel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cancel Orders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formItem">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alasan Cancel</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="2"></textarea>
              </div>
            </div><!-- /.col -->
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="cancel()" id="btn-cancel" onclick="addOrder()">Cancel Order</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- JS --}}
<script src="{{asset('/assets/js/order.js')}}"></script>
@endsection
