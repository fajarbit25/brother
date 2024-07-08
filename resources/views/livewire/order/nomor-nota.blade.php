<div class="col-sm-12">
    <div class="row">
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
                                    <td> Active </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs" wire:click="deleteNota({{$item->id}})"><i class="bi bi-trash"></i></button>
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
