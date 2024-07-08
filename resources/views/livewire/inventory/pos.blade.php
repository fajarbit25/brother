<div class="col-sm-12">
    <div class="row">

        @if($tagTableProduct == 0 && $tagTableCostumer == 0)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Point Of Sale
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="date">Date Time</label>
                                <input type="text" class="form-control" value="{{date('Y-m-d H:i:s')}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cashier">Cashier</label>
                                <input type="text" class="form-control" value="{{Auth::user()->nik.'|'.Auth::user()->name}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4" wire:ignore>
                            <div class="form-group">
                                <label for="costumer">Costumers</label>
                                <input type="text" class="form-control @error('costumer') is-invalid @enderror" wire:model="costumerName" wire:click="showTableCostumer" placeholder="Costumer Name" readonly>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" wire:model="namaProduct" wire:click="showTableProduct()" class="form-control" placeholder="Product" readonly @if(!$costumer) disabled @endif>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" class="form-control @error('qty') is-invalid @enderror @if($alertQty == 1) is-invalid @endif" 
                                placeholder="Qty" wire:model="qty" @if(!$product) disabled @endif>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" wire:click="submitProduct()" @if(!$product) disabled @endif @if($alertQty == 1) disabled @endif>
                                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span> 
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Tabel Transaksi
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Produk</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Jumlah</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dataTransaksi)
                            @foreach($dataTransaksi as $item)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$item->product_code}} </td>
                                <td> {{$item->product_name}} </td>
                                <td> {{number_format($item->price)}} </td>
                                <td> {{number_format($item->qty)}} </td>
                                <td> {{number_format($item->total_price)}} </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" wire:click="deleteTransaksi({{$item->id}})"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <thead>
                            <tr>
                                <th colspan="5">Grand Total</th>
                                <th colspan="2">Rp.{{number_format($totalTransaksi)}},-</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer">
                    @if($dataTransaksi)
                    @if($dataTransaksi->count() != 0)
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPayment" >
                            <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span> 
                            Proses Payment
                        </button>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if($tagTableProduct == 1)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Table Product
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
                    <div class="col-sm-6 mb-3">
                        <input type="search" class="form-control" wire:model="productSearchKey" placeholder="Search..">
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Product</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataProduct as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$item->product_code}} </td>
                                    <td> {{$item->product_name}} </td>
                                    <td> {{number_format($item->price)}} </td>
                                    <td> {{$item->stock}} {{$item->satuan}} </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" wire:click="addProduct({{$item->id}})" @if($item->stock <= 0) disabled @endif> add <i class="bi bi-arrow-right"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($tagTableCostumer == 1)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Table Costumer
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
                    <div class="col-sm-6 mb-3">
                        <input type="search" class="form-control" wire:model="costumerSearchKey" placeholder="Search..">
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Costumer</th>
                                    <th>Costumer Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataCostumer as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$item->costumer_kode}} </td>
                                    <td> {{$item->costumer_name}} </td>
                                    <td> {{$item->costumer_phone}} </td>
                                    <td> {{substr($item->costumer_address, 0, 50)}}... </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" wire:click="addCostumer({{$item->id}})"> add <i class="bi bi-arrow-right"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

  
  <!-- Modal Jadwal -->
    <div class="modal fade" id="modalPayment" wire:ignore.self style="font-size: 13px;">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment {{$paymentMethod}}</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran</label>
                        <select class="form-control" wire:model="paymentMethod">
                            <option value="">-Pilih Metode Pembayaran</option>
                            <option value="Cash">Cash</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="total">Discount</label>
                        <input type="number" class="form-control" wire:model.debounce.500ms="paymentDiscount">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="total">Total Belanja</label>
                        <input type="text" class="form-control" value="{{number_format($totalTransaksi)}}" disabled>
                    </div>
                </div>
                @if($paymentMethod == "Cash")
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="total">Total Pembayaran</label>
                        <input type="number" class="form-control @if($paymentCash < $totalTransaksi) is-invalid @endif" wire:model.debounce.800ms="paymentCash">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="total">Kembali</label>
                        <input type="text" class="form-control" value="{{number_format($payment_kembali)}}" disabled>
                    </div>
                </div>
                @endif
                @if($paymentMethod == 'Termin')
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="total">Tanggal Jatuh Tempo</label>
                        <input type="date" class="form-control" wire:model="teminDate">
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-submit-jadwal" wire:click="prosesPayment()">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Proses
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</div>
