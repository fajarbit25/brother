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

        <div class="col-md-12">
          @if($count == 0)
          
            <div class="card">
              <div class="card-header">
                Inbound Material
              </div>
              <div class="card-body">
                <h5 class="card-title">No data..</h5>
              </div>
            </div>

          @else

            @foreach($result as $r)
              <div class="card">
                  <div class="card-header">
                    Reservasi Id : {{$r->reservasi_id}}
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">List Materials</h5>

                    @foreach($item as $i)

                      @if($i->outbound_id == $r->id)

                        <div class="d-flex w-100 justify-content-between">
                          <p class="mb-1"><i class="bi bi-dot"></i> {{$i->name}} </p>
                          <span>{{$i->qty}} {{$i->satuan}} </span>
                        </div>

                      @endif
                      
                      @endforeach

                      <form action="" id="formApprove">
                        <button type="button" id="btn-approved-{{$r->id}}" onclick="approveMaterial({{$r->id}})" class="btn btn-primary float-right"><i class="bi bi-check-lg"></i> Approve Material</button>
                      </form>
                    
                  </div>
              </div>
            @endforeach

          @endif

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{-- Js --}}
<script src="{{asset('/assets/js/teknisiMaterials.js')}}"></script>
@endsection