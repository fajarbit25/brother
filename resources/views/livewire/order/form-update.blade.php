<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">Update Pekerjaan</h3>

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
        <!-- /.tab-pane -->
        
        <div class="row">

            <div class="col-sm-12 mb-3">

                @if($progres != 'Complete')
                    @php
                        $countItems = $items->where('lantai', '0')->count();
                    @endphp
                    @if($countItems == '0' && $tagContinous != '1' && $tagPending != '1')
                        <button class="btn btn-success" wire:click="changeTagUploadNota()"> 
                            @if ($tagUploadNota == '1') <i class="bi bi-x-lg"></i> @endif
                            Close Order 
                        </button>
                    @endif
                    
                    @if ($tagUploadNota != '1' && $tagPending != '1')
                    <button class="btn btn-warning mx-2" wire:click="changeTagContinous()"> 
                        @if ($tagContinous == '1') <i class="bi bi-x-lg"></i> @endif
                        Continous 
                    </button>
                    @endif

                    @if ($tagUploadNota != '1' && $tagContinous != '1')
                    <button class="btn btn-danger" wire:click="changeTagPending()"> 
                        @if ($tagPending == '1') <i class="bi bi-x-lg"></i> @endif
                        Pending 
                    </button>
                    @endif
                @endif

            </div>

            @if ($tagUploadNota == '1')

            @if (session('error'))
                <div class="col-sm-12 alert alert-danger">
                    <span class="fw-bold"> {{session('error')}} </span>
                </div>
                @endif

                @if (session('success'))
                <div class="col-sm-12 alert alert-success">
                    <span class="fw-bold"> {{session('success')}} </span>
                </div>
                @endif

                <div class="col-sm-6 mb-3">
                    <label for="photo"> Foto Nota </label>
                    <input type="file"
                    class="form-control"
                    wire:model="photo"/>
                </div>

                <div class="col-sm-6 mb-3">
                    <label for="nomorNota"> Nomor Nota </label>
                    <input type="text"
                    class="form-control"
                    wire:model="nomorNota".>
                </div>

                <div class="col-sm-12 mb-3">
                    <button class="btn btn-danger"
                    wire:click="uploadNota()"> Upload </button>
                </div>

            @elseif ($tagContinous == '1')

                <hr>

                <div class="col-sm-12 mb-3">
                    <label for="keteranganContinous"> Masukan Alasan </label>
                    <textarea rows="4"
                    class="form-control"
                    wire:model="keteranganContinous"></textarea>
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary"
                    wire:click="continueOrder()"> Proses Continous </button>
                </div>

            @elseif ($tagPending == '1')

                <hr>

                <div class="col-sm-12 mb-3">
                    <label for="keteranganPending"> Masukan Pending </label>
                    <textarea rows="4"
                    class="form-control"
                    wire:model="keteranganPending"></textarea>
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary"
                    wire:click="pending()"> Proses Pending </button>
                </div>

            @else 

                <div class="col-sm-12 mb-3">
                    <label for="idItem"> Pilih Item Pekerjaan </label>
                    <select class="form-control"
                    wire:model="idItem">
                        <option value="">--Pilih Item Pekerjaan --</option>
                        @foreach($items as $item)
                            <option value="{{$item->idoi}}"> {{$item->item_name.' - '.$item->merk.' '.$item->pk}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3 mb-3">
                    <label for="merk"> Merk </label>
                    <select class="form-control"
                    wire:model="merk"
                    @if(!$idItem) disabled @endif>
                        <option value="">-- Pilih Merk --</option>
                        @foreach($dataMerk as $m)
                        <option value="{{$m->merk_name}}">{{$m->merk_name}}</option>
                        @endforeach
                    </select>
                    </select>
                </div>

                <div class="col-sm-3 mb-3">
                    <label for="pk"> PK </label>
                    <select class="form-control"
                    wire:model="pk"
                    @if(!$idItem) disabled @endif>
                        <option value="">-- Pilih PK --</option>
                        <option value="0,5 PK">0,5 PK</option>
                        <option value="0,75 PK">0,75 PK</option>
                        <option value="1 PK">1 PK</option>
                        <option value="1,5 PK">1,5 PK</option>
                        <option value="2 PK">2 PK</option>
                        <option value="2,5 PK">2,5 PK</option>
                        <option value="3 PK">3 PK</option>
                        <option value="3,5 PK">3,5 PK</option>
                        <option value="4 PK">4 PK</option>
                        <option value="4,5 PK">4,5 PK</option>
                        <option value="5 PK">5 PK</option>
                        <option value="6 PK">6 PK</option>
                        <option value="10 PK">10 PK</option>
                    </select>
                </div>

                <div class="col-sm-3 mb-3">
                    <label for="lantai"> Lantai </label>
                    <input type="number" class="form-control" wire:model="lantai" @if(!$idItem) disabled @endif>
                </div>

                <div class="col-sm-3 mb-3">
                    <label for="ruangan"> Nama Ruangan </label>
                    <input type="text" class="form-control" wire:model="ruangan" @if(!$idItem) disabled @endif>
                </div>

                <div class="col-sm-3 mb-3">
                    <label for="kodeUnit"> Kode Unit </label>
                    <input type="text" class="form-control" wire:model="kodeUnit" @if(!$idItem) disabled @endif>
                </div>

                <div class="col-sm-12">
                    <button class="btn btn-primary float-right" wire:click="updateItem()">Submit</button>
                </div>

            @endif

        </div>

        <!-- /.tab-pane -->
    </div><!-- /.card-body -->
    <div class="card-footer">
        @if($progres == 'Complete')
        @if(Auth::user()->privilege == '2')
            <button type="button" wireLclick="recalOrder()" class="btn btn-warning btn-sm"><i class="bi bi-repeat"></i> Recall Order</button>
        @endif
        @endif

    </div>
</div><!-- /.card -->