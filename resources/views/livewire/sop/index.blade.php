<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Standar Operational Procedure
                    </h3>
    
                    @if(Auth::user()->privilege != 9 || Auth::user()->privilege != 10)
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" wire:click="edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    @endif

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
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="form-group">
                            @if($tagEdit == 1)
                                <label for="sop">Edit SOP</label>
                            @else 
                                <label for="sop">SOP Brother Tech Indonesia</label>
                            @endif
                            <textarea class="form-control @error('sop') is-invalid @enderror" rows="{{$baris}}" wire:model="sop" @if($tagEdit == 0) disabled  @endif ></textarea>
                        </div>
                    </div>
                    @if($tagEdit == 1)
                    <div class="col-sm-12">
                        <label for="baris"> Tentukan Jumlah Baris Yang Ditampilkan!</label>
                        <input type="number" class="form-control @error('baris') is-invalid @enderror" wire:model="baris">
                    </div>
                    @endif
                    <div class="col-sm-12 mb-3">
                        <i class="bi bi-person-lines-fill"></i> Update By : {{$name}} <br/>
                        <i class="bi bi-calendar2-week"></i> Updated At : {{$updateAt}}
                    </div>
                </div>
                <div class="card-footer">
                    @if($tagEdit == 1)
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-success" wire:click="update">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                            Update
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>