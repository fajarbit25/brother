<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Data Master
                    </h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" wire:click="modalAdd()">
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
                <div class="card-body">
                    <div class="col-sm-12">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Nama </th>
                                    <th> Merk </th>
                                    <th> Stock </th>
                                    <th> Stock Teknisi </th>
                                    <th> Jumlah </th>
                                    <th> Manage </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collection as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$item->tools_name}} </td>
                                    <td> {{$item->merk}} </td>
                                    <td> {{$item->stock}} </td>
                                    <td> {{$item->stock_teknisi}} </td>
                                    <th> {{$item->stock+$item->stock_teknisi}} </th>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs" wire:click="modalEdit({{$item->id}})"> <i class="bi bi-pencil-square"></i> </button>
                                        <button type="button" class="btn btn-danger btn-xs" wire:click="modalDelete({{$item->id}})"> <i class="bi bi-trash"></i> </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer"> {{$collection->links()}} </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="name">Nama Tools <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                    </div>
                </div>
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="merk">Merk <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control @error('merk') is-invalid @enderror" wire:model="merk">
                    </div>
                </div>
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="stock">Stock <span class="text-danger">*</span> </label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" wire:model="stock">
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="saved">
                <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                Save changes
            </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalEdit" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="nameEdit">Nama Tools <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control @error('nameEdit') is-invalid @enderror" wire:model="nameEdit">
                    </div>
                </div>
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="merkEdit">Merk <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control @error('merkEdit') is-invalid @enderror" wire:model="merkEdit">
                    </div>
                </div>
                <div class="col-sm-12 mb-2">
                    <div class="form-group">
                        <label for="stockEdit">Stock <span class="text-danger">*</span> </label>
                        <input type="number" class="form-control @error('stockEdit') is-invalid @enderror" wire:model="stockEdit">
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="update">
                <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                Update changes
            </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalDelete" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                    Yakin ingin menghapus?
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleted">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Delete
                    </button>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
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

            Livewire.on('modalAdd', function () {
                $("#modalAdd").modal('show')
            });

            Livewire.on('modalDelete', function () {
                $("#modalDelete").modal('show')
            });

            Livewire.on('modalEdit', function () {
                $("#modalEdit").modal('show')
            });

            Livewire.on('closeModal', function () {
                $("#modalAdd").modal('hide')
                $("#modalEdit").modal('hide')
                $("#modalDelete").modal('hide')
            });
        })
    </script>
    @endpush
</div>