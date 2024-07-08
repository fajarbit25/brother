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
            <li class="breadcrumb-item"><a href="#">Teknisi</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  {{-- Deklarasi Status Order --}}

  {{-- end Of Deklarasi Status Order --}}

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <div class="col-md-12">

            <div class="list-group mb-3">
                <div href="#" class="list-group-item list-group-item-action text-light" aria-current="true">
                  <h6>Data Return Material</h6>
                  <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: 12px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Approved</th>
                        </tr>
                      </thead>
                      @if($count == 0)
                        <tbody>
                          <tr>
                            <td colspan="4">
                              <i>Data kosong!</i>
                            </td>
                          </tr>
                        </tbody>
                      @else
                        <tbody>
                          @foreach($stocks as $stok)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$stok->name}}</td>
                            <td>{{$stok->stock}} {{$stok->satuan}}</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      @endif

                    </table>
                  </div>

                </div>
            </div>


            <div id="item-list"></div>

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Update -->
<div class="modal fade" id="modal-update">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="bi bi-plus-lg"></i> Form Pekerjaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action="" id="formItem">
          <input type="hidden" name="order_itemId" id="order-itemId" required/>
          <div class="form-group">
            <label for="tipe">Tipe Order <code>.Keluhan</code></label>
            <select name="tipe" id="tipe" class="form-control rounded-0">
            </select>
          </div>
          <div class="form-group">
              <label for="merk">Merk AC <code>.Nama/Merk AC</code></label>
              <input type="text" name="merk" class="form-control rounded-0" id="merk">
          </div>
          <div class="form-group">
              <label for="pk">PK <code>.Paard Kracht</code></label>
              <select name="pk" id="pk" class="form-control rounded-0">
                <option value="0,5 PK">0,5 PK</option>
                <option value="0,75 PK">0,75 PK</option>
                <option value="1 PK">1 PK</option>
                <option value="1,5 PK">1,5 PK</option>
                <option value="2 PK">2 PK</option>
                <option value="2,5 PK">2,5 PK</option>
                <option value="3 PK">3 PK</option>
                <option value="4 PK">4 PK</option>
                <option value="5 PK">5 PK</option>
                <option value="6 PK">6 PK</option>
              </select>
          </div>
          <div class="form-group">
              <label for="lantai">Lantai <code>.Hanya angka</code></label>
              <input type="number" name="lantai" class="form-control rounded-0" id="lantai" placeholder="Nomor lantai" autocomplete="off">
          </div>
          <div class="form-group">
              <label for="ruangan">Ruangan <code>.Nama Ruangan</code></label>
              <input type="text" name="ruangan" class="form-control rounded-0" id="ruangan" placeholder="Ruangan" autocomplete="off">
          </div>
        </form>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" id="btn-update-item" onclick="updateItem()" class="btn btn-success">Update</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal Delete -->

{{-- Js --}}
@endsection
