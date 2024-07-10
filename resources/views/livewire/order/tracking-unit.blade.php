<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Tracking Unit
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
                    <div class="col-sm-12">
                      <div class="input-group mb-3">
                          <input type="search" class="form-control @error('kode') is-invalid @enderror" wire:model="kode"
                          placeholder="Masukkan kode unit" aria-label="Masukkan kode unit" aria-describedby="button-addon2">
                          <button class="btn btn-primary" type="button" id="button-addon2" wire:click="prosesCekUnit">
                              <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                              Tracking
                          </button>  
                      </div>
                    </div>
                    @if($history)
                    <div class="col-sm-12 mt-3">
                      <div class="row">
                      <div class="col-sm-12 my-3">
                        <h3 class="card-title"> Tracking On {{$kode}} </h3>
                      </div>

                      @if($history->count() == 0)
                      <div class="col-sm-12">
                        <ol class="list-group list-group-numbered">
                          <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold text-danger">Oops!</div>
                              Data <span class="text-primary">{{$kode}}</span> Tidak Ditemukan!
                            </div>
                            <span class="badge text-bg-primary rounded-pill">0000-00-00</span>
                          </li>
                        </ol>
                      </div>
                      @else 
                      <div class="col-sm-12">
                        <ol class="list-group list-group-numbered">
                          @foreach($history as $item)
                          <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold"><i class="bi bi-check2"></i>Order Id : <span class="text-primary">{{$item->order_id}}</span> </div>
                              <i class="bi bi-check2"></i>Pengerjaan : <span class="text-success">{{$item->item_name}}</span><br/>
                              <i class="bi bi-check2"></i>Teknisi : <span>{{$item->name}}</span>
                            </div>
                            <span class="badge text-bg-primary rounded-pill">{{$item->created_at}}</span>
                          </li>
                          @endforeach
                        </ol>
                      </div>
                      @endif
                      </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</div>