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
            <li class="breadcrumb-item"><a href="{{url('/invoice')}}">Invoice</a></li>
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
              <h3 class="card-title">Order Unpaid</h3>

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
                            <th>#</th>
                            <th>Order Id</th>
                            <th>Costumer Name</th>
                            <th>Nomor Invoice</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody id="table-order"></tbody>
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




<!-- Modal Jadwal -->
<div class="modal fade" id="edit-invoice-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="idorder-invoice-edit" id="idorder-invoice-edit">
        <div class="col-sm-12">
            <div class="alert alert-warning" id="alert-input-edit"></div>
        </div>
        <div class="form-group" id="form-due_date">
            <label for="invoice_date-edit">Tanggal Invoice</label>
            <input type="date" name="invoice_date-edit" id="invoice_date-edit" class="form-control"/>
        </div>
        <div class="form-group">
          <label for="invoice_id-edit">Masukan Nomor Invoice</label>
          <input type="text" name="invoice_id-edit" id="invoice_id-edit" class="form-control">
        </div>
        <div class="form-group">
          <label for="total-edit">Total Invoice Material & Jasa</label>
          <input type="number" name="total-edit" id="total-edit" class="form-control">
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-edit-invoice" onclick="updateInvoice()">Update Invoice</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="invoice-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="idorder-invoice" id="idorder-invoice">
        <div class="col-sm-12">
            <div class="alert alert-warning" id="alert-input"></div>
        </div>
        <div class="form-group" id="form-due_date">
            <label for="invoice_date">Tanggal Invoice</label>
            <input type="date" name="invoice_date" id="invoice_date" class="form-control"/>
        </div>
        <div class="form-group">
          <label for="invoice_id">Masukan Nomor Invoice</label>
          <input type="text" name="invoice_id" id="invoice_id" class="form-control">
        </div>
        <div class="form-group">
          <label for="total">Total Invoice Material & Jasa</label>
          <input type="number" name="total" id="total" class="form-control">
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-proses-invoice" onclick="createInvoice()">Create Invoice</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modal-upload">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Upload Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        
        <form id="uploadForm" enctype="multipart/form-data">
          <input type="hidden" name="id_invoice_upload" id="id_invoice_upload">
          <div class="custom-file mb-3">
              <input type="file" name="pdf_file"  class="custom-file-input" id="pdf_file" required>
              <label class="custom-file-label" for="pdf_file">Pilih file</label>
          </div>
        </form>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-upload-invoice" onclick="uploadInvoice()">Upload Invoice</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modal-invoice-view">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title-modal"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <iframe id="frame" width="100%" height="600px"></iframe>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <span id="title-bottom" class="badge badge-secondary"></span>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Jadwal -->
<div class="modal fade" id="modal-invoice-paid">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Upload Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        
          <input type="hidden" name="id_invoice_paid" id="id_invoice_paid">
          <div class="form-group">
            <label for="method"> Pilih Metode Pembayaran </label>
            <select class="form-control" id="method">
              <option value="">--Pilih--</option>
              <option value="Cash">Cash</option>
              <option value="BCA">BCA</option>
              <option value="BRI">BRI</option>
              <option value="Mandiri">Mandiri</option>
            </select>
          </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-invoice-paid" onclick="paidInvoiceProses()">Proses Invoice</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


{{-- JS --}}
<script src="{{asset('/assets/js/invoice.js')}}"></script>
<script>
  function paidInvoiceConfirm(id)
  {
      console.log(id)
      $("#id_invoice_paid").val(id)
      $("#modal-invoice-paid").modal('show');

  }

  function paidInvoiceProses()
  {
      $("#btn-invoice-paid").attr('disabled', true)
      $("#btn-invoice-paid").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')
      var id = $("#id_invoice_paid").val();
      var method = $("#method").val();

      var url = "/invoice/paid";

      console.log(id)
      $.ajax({
          url:url,
          type:'POST',
          cache:false,
          data:{
              id:id,
              method:method,
          },
          success:function(response){
              getOrder();

              $("#btn-invoice-paid").attr('disabled', false)
              $("#btn-invoice-paid").html('Proses Invoice')

              $("#id_invoice_upload").val("")
              $("#modal-invoice-paid").modal('hide');


              /**Notifikasi */
              $(document).Toasts('create', {
                  class: 'bg-success',
                  title: 'Congrats',
                  subtitle: 'Success',
                  body: response.message
              })
          },
          error:function(error){
              console.log(error)
              getOrder();
              
              /**Notifikasi */
              $(document).Toasts('create', {
                  class: 'bg-danger',
                  title: 'Oops',
                  subtitle: 'Error Message',
                  body: 'Terjadi kesalahan!'
              })
          }
      });
  }
</script>
@endsection
