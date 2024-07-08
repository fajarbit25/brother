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
            <li class="breadcrumb-item"><a href="#">Finance</a></li>
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
              <h3 class="card-title">Invocie</h3>

              <div class="card-tools">
                <a href="/order/1/edit" class="btn btn-tool">
                  <i class="bi bi-plus-lg"></i>
                </a>
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
                    <th>#</th>
                    <th>Invoice</th>
                    <th>To</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td><a href="/finance/0020/invoice">0020/INV/BTI/XII/2023</a></td>
                    <td>Yotta Pettarani</td>
                    <td>2023-12-30</td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">500.000</div>
                    </td>
                    <td><span class="badge badge-info">Terkirim</span></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td><a href="/order/0022/show">0021/INV/BTI/XII/2023</a></td>
                    <td>Pegadaian Bulukumba</td>
                    <td>2023-12-25</td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">1.000.000</div>
                    </td>
                    <td><span class="badge badge-warning">Unpaid</span></td>
                  </tr>
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
        <h4 class="modal-title">Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Costumers</label>
                <select class="form-control form-control-sm select2bs4" style="width: 100%;">
                  <option selected="selected">Pilih Costumer</option>
                  <option>Yotta Pettarani</option>
                  <option>Pegadaian Bulukumba</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Type Order</label>
                <select class="form-control" style="width: 100%;">
                  <option selected="selected">Pilih Tipe Order</option>
                  <option>Komplain</option>
                  <option>Pasang Baru</option>
                  <option value="">Bongkar Pasang</option>
                  <option value="">Cleaning</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Jumlah Unit</label>
                <input type="text" name="qty" id="qty" class="form-control" required/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>PK / Paard Kracht</label>
                <select class="form-control" style="width: 100%;">
                  <option selected="selected">Pilih PK</option>
                  <option>0,5 PK</option>
                  <option>1 PK</option>
                  <option>1,5 PK</option>
                  <option>3 PK</option>
                  <option>4 PK</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Lantai</label>
                <input type="text" name="floor" id="floor" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Ruangan</label>
                <input type="text" name="room" id="room" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Harga Jasa</label>
                <input type="text" name="price" id="price" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Teknisi</label>
                <select class="form-control select2bs4" style="width: 100%;">
                  <option selected="selected">Pilih Teknisi</option>
                  <option>Dimas</option>
                  <option>Anton</option>
                  <option>Rasdi</option>
                </select>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="2" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection
