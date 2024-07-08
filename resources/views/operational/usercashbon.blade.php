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
            <li class="breadcrumb-item"><a href="#">Operational</a></li>
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
              <h3 class="card-title">Cashbon</h3>

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
                    <th>Date Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Approve</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($result as $r)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> {{$r->tanggal." ".$r->jam}} </td>
                        <td> {{number_format($r->amount)}} </td>
                        <td> 
                            @if($r->approved == 0)
                                <span class="badge badge-secondary">Unapproved</span>
                            @else 
                                <span class="badge badge-success">Approve</span>
                            @endif
                        </td>
                        <td> {{$r->alasan_cashbon}} </td>
                        <td>
                            <button type="button" class="btn btn-success btn-xs" onclick="modalUserCashbon({{$r->id}})">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </button>
                        </td>
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
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="modal-usercashbon">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Approve Cashbon</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formOps">
          <div class="row">
            <input type="hidden" name="idcashbon" id="idcashbon">
            <input type="hidden" name="userId" id="userId" value="{{Auth::user()->id}}">

            <div class="col-sm-12">
              <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="password" id="password" class="form-control" required/>
              </div>
            </div><!-- /.col --> 
            
          </div><!-- /. row -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-usercashbon">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="{{asset('/assets/js/ops.js')}}"></script>
@endsection
