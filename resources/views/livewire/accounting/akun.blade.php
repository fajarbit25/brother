<div class="col-sm-12">
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    List Akun
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
                        <table class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th class="text-center bg-light">No</th>
                                    <th class="bg-light">Nama Akun</th>
                                    <th class="bg-light">Laba Rugi / Neraca</th>
                                    <th class="bg-light">Klasifikasi</th>
                                    <th class="bg-light">Kategori</th>
                                    <th class="bg-light">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($items->count() != 0)
                                @foreach ($items as $item)
                                <tr>
                                    <td class="text-center"> {{$loop->iteration}} </td>
                                    <td> {{$item->item}} </td>
                                    <td> {{$item->type}} </td>
                                    <td> {{$item->klasifikasi}} </td>
                                    <td> {{$item->category}} </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs" wire:click="editData({{$item->id}})">Edit</button>
                                        <button type="button" class="btn btn-danger btn-xs" wire:click="deleteData({{$item->id}})">Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5"> Tidak ada Data </td>
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
    <div class="modal fade" id="modalAdd" wire:ignore.self>
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="form-group">
                <label for="akun">Nama Akun <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('akun') is-invalid @enderror" wire:model="akun">
                @error('akun') <span class="text-danger fw-bold"> Nama Akun wajib diisi! </span> @enderror
            </div>

            <div class="form-group">
                <label for="type">Laba Rugi / Neraca <span class="text-danger">*</span></label>
                <select class="form-control @error('type') is-invalid @enderror" 
                style="width: 100%;" wire:model="type">
                <optgroup label="Pilih Status">
                    <option value="">--Pilih Jenis--</option>
                    <option value="LABA RUGI">LABA RUGI</option>
                    <option value="NERACA">NERACA</option>
                </optgroup>
                </select>
                @error('type') <span class="text-danger fw-bold"> Laba Rugi / Neraca wajib diisi! </span> @enderror
            </div>

            <div class="form-group">
                <label for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
                <select class="form-control @error('klasifikasi') is-invalid @enderror" 
                style="width: 100%;" wire:model="klasifikasi">
                <optgroup label="Pilih Status">
                    <option value="">--Pilih Klasifikasi--</option>
                    @if ($dataKlasifikasi)
                    @foreach ($dataKlasifikasi as $item)
                    <option value="{{$item->id}}">{{$item->klasifikasi}}</option>
                    @endforeach
                    @endif
                </optgroup>
                </select>
                @error('klasifikasi') <span class="text-danger fw-bold"> Klasifikasi wajib diisi! </span> @enderror
            </div>

            <div class="form-group">
                <label for="kategory">Kategori <span class="text-danger">*</span></label>
                <select class="form-control @error('kategory') is-invalid @enderror" 
                style="width: 100%;" wire:model="kategory">
                <optgroup label="Pilih Status">
                    <option value="">--Pilih Jenis--</option>
                    <option value="Pengeluaran">Pengeluaran</option>
                    <option value="Pemasukan">Pemasukan</option>
                </optgroup>
                </select>
                @error('kategory') <span class="text-danger fw-bold"> Kategori wajib diisi! </span> @enderror
            </div>



            @if (session('warning'))
            <div class="alert alert-warning">
                <span class="fst-italic"> {{session('warning')}} </span>
            </div>
            @endif
            
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            @if ($idEdit)
                <button type="button" class="btn btn-success" wire:click="updateData()"> Update </button>
            @else
                <button type="button" class="btn btn-primary" wire:click="submitData()"> Submit </button>
            @endif
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal Filter -->
    <div class="modal fade" id="modalDelete" wire:ignore.self>
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Confirm! </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    @if (session('error'))
                    <div class="alert alert-warning my-3">
                        <span class="fst-italic"> {{session('error')}} </span>
                    </div>
                    @endif
                </div>

                <div class="col-8">
                    <span class="fw-bold fst-italic">Yakin ingin menghapus akun?</span>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-sm btn-danger" wire:click="prosesDeleteData()"> 
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span> Hapus 
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
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

            Livewire.on('modalAdd',function () {
               $("#modalAdd").modal('show');
            });

            Livewire.on('modalDelete', function () {
                $("#modalDelete").modal('show')
            });

            Livewire.on('closeModal', function () {
                $("#modalAdd").modal('hide');
                $("#modalDelete").modal('hide')
            });
        });
      </script>
  @endpush
</div>