<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Laporan Penjualan
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start">Mulai</label>
                                <input type="date" class="form-control @error('start') is-invalid @enderror" wire:model="start">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="end">Sampai</label>
                                <input type="date" class="form-control @error('end') is-invalid @enderror" wire:model="end">
                            </div>
                        </div>
                        <div class="col-sm-12 my-3">
                            @if($dataUnpaid->groupBy('id_transaksi')->count() > 0)
                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    <span class="fw-bold">Alert!</span> terdapat {{$dataUnpaid->groupBy('id_transaksi')->count()}} transaksi belum lunas.
                                </div>
                            </div>
                            @endif
                            <table class="table" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Tanggal </th>
                                        <th> Id Transaksi </th>
                                        <th> Pelanggan </th>
                                        <th> Total Transaksi </th>
                                        <th> Discount </th>
                                        <th> Grand Total </th>
                                        <th> Status Pembayaran </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($dataPenjualan)
                                    @foreach ($dataPenjualan->groupBy('id_transaksi') as $idTransaksi => $item)
                                    <tr>
                                        <td> {{$loop->iteration}} </td>
                                        <td> 
                                            <a href="javascript:void(0)" class="text-primary" wire:click="detailTransaksi('{{$idTransaksi}}')" 
                                                data-bs-toggle="modal" data-bs-target="#modalDetail">
                                            {{$idTransaksi}} 
                                            </a>
                                        </td>
                                        <td> {{substr($item->first()->created_at, 0, 10)}} </td>
                                        <td> {{$item->first()->name}} </td>
                                        <td> Rp.{{number_format($item->sum('total_price'))}},- </td>
                                        <td> Rp.{{number_format($item->first()->discount)}},- </td>
                                        <td> Rp.{{number_format($item->sum('total_price')-$item->first()->discount)}},- </td>
                                        <td>
                                            @if($item->first()->payment_status == 'Paid')
                                                <span class="fw-bold text-success">{{$item->first()->payment_status}}</span>
                                            @elseif($item->first()->payment_status == 'Unpaid')
                                                <span class="fw-bold text-danger">{{$item->first()->payment_status}}</span>
                                            @else 
                                                <span class="fw-bold">{{$item->first()->payment_status}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else 
                                    <tr>
                                        <td> <span class="fw-bold">Tidak ada data!</span> </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">        
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                </div>
                <div class="modal-body">
                @if($tagDetail == 1)
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> ID Transaksi</div> <div class="col-sm-8">: {{$detail->id_transaksi}} </div>
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> Date Time</div> <div class="col-sm-8">: {{$detail->created_at}} </div>
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> Cashier</div> <div class="col-sm-8">: {{$cashier}} </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> Costumer</div><div class="col-sm-8">: {{$costumer}} </div>
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> Payment Status</div>
                            <div class="col-sm-8">: {{$detail->payment_status}} @if($detail->payment_status == "Unpaid") <button type="button" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#modalPayment"> <i class="bi bi-check-circle"></i> Set Paid </button> @endif </div>
                            <div class="col-sm-4"><i class="bi bi-chevron-compact-right"></i> Status Method</div><div class="col-sm-8">: {{$paymentMethod}} </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-5">
                        <table class="table" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Item </th>
                                    <th> Qty </th>
                                    <th> Price </th>
                                    <th> Jumlah </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tableDetail as $item)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td> {{$item->product_name}} </td>
                                    <td> {{$item->qty.' '.$item->unit_code}} </td>
                                    <td> Rp.{{number_format($item->price)}} </td>
                                    <td> Rp.{{number_format($item->total_price)}} </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4">Total Transaksi</th>
                                    <th> Rp.{{number_format($totalTransaksi)}} </th>
                                </tr>
                                <tr>
                                    <th colspan="4">Discount</th>
                                    <th> Rp.{{number_format($discount)}} </th>
                                </tr>
                                <tr>
                                    <th colspan="4">Grand Total</th>
                                    <th> Rp.{{number_format($totalTransaksi-$discount)}} </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if($tagDetail == 1)
    <!-- Modal -->
    <div class="modal fade" id="modalPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">Payment Status Order {{$detail->id_transaksi}}</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="payment_method">Metode Pembayaran {{$paymentMethodUpdate}} <span class="text-danger">*</span> </label>
                    <select class="form-control @error('paymentMethodUpdate') is-invalid @enderror" wire:model="paymentMethodUpdate">
                        <option value="">-Pilih Metode</option>
                        <option value="Cash">Cash</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="updatePayment('{{$detail->id_transaksi}}')">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Simpan
                </button>
            </div>
        </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
