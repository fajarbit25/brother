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
                    <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalFilter">
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
                    <div class="col-sm-12 mb-3">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAssign">
                            <i class="bi bi-box-arrow-up"></i> Assign To Teknisi
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <table class="table" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Teknisi</th>
                                    <th>Tools</th>
                                    <th>Merk</th>
                                    <th>Qty</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($tools)
                                @foreach($tools as $items)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$items->name}} </td>
                                    <td> {{$items->tools_name}} </td>
                                    <td> {{$items->merk}} </td>
                                    <td> {{$items->qty}} </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="setIdRemove({{$items->id}})"> 
                                            <i class="bi bi-box-arrow-in-down"></i> 
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    @if($tools)
                    {{$tools->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAssign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Assign To Teknisi</h6>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="teknisi">Pemakai</label>
                            <select class="form-control @error('teknisi') is-invalid @enderror" wire:model="teknisi">
                                <option value="">-Pilih Teknisi....</option>
                                @foreach($dataUser as $item)
                                <option value="{{$item->id}}"> {{$item->nik.' - '.$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="item">Tools</label>
                            <select class="form-control @error('item') is-invalid @enderror" wire:model="item">
                                <option value="">-Pilih Tools....</option>
                                @foreach($toolsMaster as $item)
                                    <option value="{{$item->id}}"> {{$loop->iteration.' | '.$item->tools_name.' | '.$item->merk.' | '.$item->nomor_seri}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="qty">Jumlah</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" wire:model="qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="assign()">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Confirm!</h6>
                </div>
                <div class="modal-body">
                    @if (session()->has('warning'))
                        <div class="alert alert-danger">
                            {{ session('warning') }}
                        </div>
                    @else 
                        <strong>Stock Tools Akan Kembali Ke Office!</strong>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if($idRemove != 0)
                    <button type="button" class="btn btn-primary" wire:click="removed">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Lanjutkan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Filter!</h6>
                </div>
                <div class="modal-body">
                ....
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal',function () {
               $("#modalAssign").modal('hide');
            });
        });

    </script>
    @endpush

</div>
