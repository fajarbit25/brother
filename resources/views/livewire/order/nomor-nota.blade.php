<div class="col-sm-12">
    <div class="row">

        @if ($idEdit)

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-transparent">
                    <h3 class="card-title">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Edit Nota
                        </h3>
        
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
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                            <div class="col-sm-12 my-3">
                                <div class="alert alert-warning" role="alert">
                                    @foreach ($errors->all() as $error)
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <strong>Alert!</strong> {{$error}}
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <a href="javascript:void(0)" wire:click="getDataTeknisi()"><i class="bi bi-x-lg"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('nomorEdit') is-invalid @enderror" wire:model.lazy="nomorEdit" placeholder="Masukan Nomor Nota">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control @error('teknisiEdit') is-invalid @enderror" wire:model="teknisiEdit">
                                    <option value="">Pilih Teknisi--</option>
                                    @foreach ($dataTeknisi as $item)
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <select class="form-control"
                                wire:model="statusEdit">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="0">Belum Terpakai</option>
                                    <option value="1">Terpakai</option>
                                    <option value="2">Hilang</option>
                                </select>
                            </div>

                            

                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success w-100" wire:click="updateNota()">
                                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                                    Update
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-secondary w-100" wire:click="cancelEdit()">
                                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        
        @else

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-transparent">
                    <h3 class="card-title">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Input Nota
                        </h3>
        
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
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                            <div class="col-sm-12 my-3">
                                <div class="alert alert-warning" role="alert">
                                    @foreach ($errors->all() as $error)
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <strong>Alert!</strong> {{$error}}
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <a href="javascript:void(0)" wire:click="getDataTeknisi()"><i class="bi bi-x-lg"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="col-sm-5">
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror" wire:model.lazy="nomor" placeholder="Masukan Nomor Nota">
                            </div>
                            <div class="col-sm-5">
                                <select class="form-control @error('teknisi') is-invalid @enderror" wire:model="teknisi">
                                    <option value="">Pilih Teknisi--</option>
                                    @foreach ($dataTeknisi as $item)
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary w-100" wire:click="saveNota()">
                                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>

        @endif

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    List Nota
                    </h3>
                    
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
                <div class="card-body">
                    @if(session()->has('message'))
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <div class="row">
                                <div class="col-sm-10">
                                    <strong>Congrats!</strong> {{ session()->get('message') }}
                                </div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" wire:click="getDataTeknisi()"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(session()->has('alert'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            <div class="row">
                                <div class="col-sm-10">
                                    <strong>Congrats!</strong> {{ session()->get('alert') }}
                                </div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" wire:click="getDataTeknisi()"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <input type="search" 
                                class="form-control" 
                                wire:model.live="key"
                                placeholder="Cari nomor nota..."/>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control"
                                wire:model.live="filterStatus">
                                    <option value="ALL">-- Status ALL --</option>
                                    <option value="0">Belum Terpakai</option>
                                    <option value="1">Terpakai</option>
                                    <option value="2">Hilang</option>
                                </select>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Nota</th>
                                    <th>Teknisi</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($nota)
                                @foreach($nota as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> <strong>{{$item->nomor}}</strong> </td>
                                    <td> {{$item->name}} </td>
                                    <td>
                                        @if ($item->tag_usage == '0') <span class="text-success">Available</span>
                                        @elseif ($item->tag_usage == '1') Usage 
                                            @if ($item->uuid) 
                                                <a href="/order/{{$item->uuid}}/show" > {{$item->uuid}} </a>
                                            @else 
                                                *undefined
                                            @endif
                                        @elseif ($item->tag_usage == '2') <span class="text danger">Lost</span> 
                                        @else Unknows @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs" wire:click="deleteNota({{$item->id}})"><i class="bi bi-trash"></i></button>
                                        <button type="button" class="btn btn-success btn-xs" wire:click="editNota({{$item->id}})"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    {{$nota->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
