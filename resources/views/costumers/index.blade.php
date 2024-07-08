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
            <li class="breadcrumb-item"><a href="#">Costumers</a></li>
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
                <input type="text" class="form-control" onkeyup="cari(this.value)" placeholder="Cari Costumer..">
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
              <h3 class="card-title">Data Pelanggan</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="formSearch()">
                  <i class="bi bi-search"></i>
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
              <div class="table-responsive" id="costumersTable">
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info float-left"  data-toggle="modal" data-target="#modal-xl">Place New Costumers</a>
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

<!-- Modal New -->
<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Costumers</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="cForm">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="costumer_name" id="costumer_name" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama PIC</label>
                  <input type="text" name="costumer_pic" id="costumer_pic" class="form-control" required autocomplete="off"/>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <div class="form-group">
                <label>Kontak PIC</label>
                <input type="text" name="costumer_phone" id="costumer_phone" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-6">
              <div class="form-group">
                <label>Alamat Email</label>
                <input type="text" name="costumer_email" id="costumer_email" class="form-control" value="-" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="costumer_address" id="costumer_address" rows="3" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn-submit-costumer" onclick="saveCostumer()" class="btn btn-primary">Save changes</button>
        <button type="button" id="btn-loading-costumer" class="btn btn-secondary" disabled>Loading...</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal Nen -->

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Costumers</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="cForm">
          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="costumer_name_edit" id="costumer_name_edit" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Status Pelanggan</label>
                <select name="costumer_status_edit" id="costumer_status_edit" class="form-control">
                  <option value="Bronze">Bronze</option>
                  <option value="Platinum">Platinum</option>
                  <option value="Gold">Gold</option>
                </select>
              </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Nama PIC</label>
                  <input type="text" name="costumer_pic_edit" id="costumer_pic_edit" class="form-control" required autocomplete="off"/>
                </div>
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Kontak PIC</label>
                <input type="text" name="costumer_phone_edit" id="costumer_phone_edit" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-4">
              <div class="form-group">
                <label>Alamat Email</label>
                <input type="text" name="costumer_email_edit" id="costumer_email_edit" class="form-control" required autocomplete="off"/>
              </div>
            </div><!-- /.col --> 
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="costumer_address_edit" id="costumer_address_edit" rows="3" class="form-control"></textarea>
              </div>
            </div><!-- /.col -->  

          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <input type="hidden" name="idcostumer_edit" id="idcostumer_edit" required/>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn-submit-edit-costumer" onclick="updateCostumer()" class="btn btn-primary">Save changes</button>
        <button type="button" id="btn-loading-edit-costumer" class="btn btn-secondary" disabled>Loading...</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal Edit -->

<!-- Modal Delete -->
<div class="modal fade" id="modal-delete">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="bi bi-exclamation-diamond"></i> Alert</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <i class="bi bi-trash3"></i> Hapus pelanggan?
      </div>
      <div class="modal-footer justify-content-between">
        <input type="hidden" name="idcostumer-delete" id="idcostumer-delete" required/>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" id="btn-submit-delete-costumer" onclick="deleteCostumer()" class="btn btn-danger">Hapus</button>
        <button type="button" id="btn-loading-delete-costumer" class="btn btn-secondary" disabled>Loading...</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal Delete -->

{{-- Js --}}
<script src="{{asset('assets/js/costumer.js')}}"></script>
@endsection
