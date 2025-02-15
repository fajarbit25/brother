<div class="col-sm-12">
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    List Tools
                    </h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" wire:click="modalFilter()">
                        <i class="bi bi-funnel-fill"></i>
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
                <div class="card-body">
                    <div class="col-sm-12">
                        <table class="table" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Referensi</th>
                                    <th>Method</th>
                                    <th>Tipe</th>
                                    <th>Amount</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($items)
                                @foreach ($items as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$item->tanggal}} </td>
                                    <td> {{$item->segment}} </td>
                                    <td> {{$item->referensi_id}} </td>
                                    <td> {{$item->payment_method}} </td>
                                    <td> {{$item->tipe}} </td>
                                    <td> Rp.{{number_format($item->amount)}},- </td>
                                    <td>
                                        @if ($item->approval == 'new')
                                        <button type="button" class="btn btn-primary btn-xs" wire:click="modalApproval({{$item->id}})"> <i class="bi bi-asterisk"></i> {{$item->approval}} </button>
                                        @endif

                                        @if ($item->approval == 'rejected')
                                        <button type="button" class="btn btn-danger btn-xs" wire:click="modalApproval({{$item->id}})"> <i class="bi bi-ban"></i>  {{$item->approval}} </button>
                                        @endif

                                        @if ($item->approval == 'approved')
                                        <button type="button" class="btn btn-success btn-xs" wire:click="modalApproval({{$item->id}})"> <i class="bi bi-check-circle-fill"></i> {{$item->approval}} </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else 
                                <tr>
                                    <td colspan="8">Belum ada data!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                   @if ($items)
                        {{$items->links()}}
                   @endif
                </div>
            </div>
        </div>

    </div>


    <!-- Modal Filter -->
    <div class="modal fade" id="modalFilter" wire:ignore.self>
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Filter Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idorder-payment" id="idorder-payment">
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" style="width: 100%;" wire:model="status">
              <optgroup label="Pilih Status">
                <option value="all">All</option>
                <option value="new">New</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="start">Mulai</label>
            <input type="date" class="form-control" wire:model="start">
        </div>

        <div class="form-group">
            <label for="end">Sampai</label>
            <input type="date" class="form-control" wire:model="end">
        </div>
        
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" id="btn-proses-payment" wire:click="reloadItems()"> Tampilkan </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- Modal Filter -->
    <div class="modal fade" id="modalApproval" wire:ignore.self>
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Approval [{{$statusApproval}}]</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="statusApproval">Status </label>
                <select class="form-control @error('statusApproval') is-invalid @enderror" 
                style="width: 100%;" wire:model="statusApproval">
                <optgroup label="Pilih Status">
                    <option value="">--Pilih Status--</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </optgroup>
                </select>
                @error('statusApproval') <span class="text-danger fw-bold"> Status wajib diisi! </span> @enderror
            </div>

            <div class="form-group">
                <label for="idreferensi">Id Referensi</label>
                <input type="text" class="form-control @error('idreferensi') is-invalid @enderror" wire:model="idreferensi" placeholder="Masukan ref id untuk melakukan approval">
            </div>

            @if (session('warning'))
            <div class="alert alert-warning">
                <span class="fst-italic"> {{session('warning')}} </span>
            </div>
            @endif
            
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" wire:click="submitApproval()"> Submit </button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  @push('scripts')
      <script>
        document.addEventListener('livewire:load', function () {

            Livewire.on('modalFilter',function () {
               $("#modalFilter").modal('show');
            });

            Livewire.on('modalApproval', function () {
                $("#modalApproval").modal('show')
            });

            Livewire.on('closeModal', function () {
                $("#modalFilter").modal('hide');
                $("#modalApproval").modal('hide')
            });
        });
      </script>
  @endpush

</div>