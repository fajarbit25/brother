<div class="col-sm-12">

    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                    Arus Kas
                    </h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" wire:click="modalFilter()">
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
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table" style="font-size: 13px;">
                                <tbody>
                                    <tr>
                                        <td> <input type="date" wire:model="start" class="form-control form-control-sm"> </td>
                                        <td> <input type="date" wire:model="end" class="form-control form-control-sm"> </td>
                                        <td>
                                            <select class="form-control form-control-sm" wire:model="akun">
                                                <option value="">-- Pilih Akun --</option>
                                                @if ($dataAkun)
                                                @foreach($dataAkun as $item)
                                                <option value="{{$item->id}}"> {{$item->item}} </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" wire:model="method">
                                                <option value="">-- Payment Method --</option>
                                                <option value="Cash">Cash</option>
                                                <option value="BCA">BCA</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="BRI">BRI</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" wire:model="tipe">
                                                <option value="">-- Payment Tipe --</option>
                                                <option value="Debit">Debit</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Penjualan Unit / Jasa</th>
                                        <th>Qty</th>
                                        <th>Payment Method</th>
                                        <th>Payment Type</th>
                                        <th>Amount</th>
                                        <th>Petty Kas</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($items->count() != 0)
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class="text-center"> {{$loop->iteration}} </td>
                                        <td> {{$item->tanggal}} </td>
                                        <td> {{$item->nota}} </td>
                                        <td> {{$item->costumer}} </td>
                                        <td> {{$item->items}} </td>
                                        <td> {{number_format($item->qty)}} </td>
                                        <td> {{$item->payment_method}} </td>
                                        <td> {{ucfirst($item->payment_type)}} </td>
                                        <th> Rp.{{number_format($item->amount)}},- </th>
                                        <td> Rp.{{number_format($item->petty_cash)}} </td>
                                        <td> Rp.{{number_format($item->amount)}},- </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="8">Total</th>
                                        <th colspan="3"> Rp.{{number_format($items->sum('amount'))}},- </th>
                                    </tr>
                                    @else 
                                    <tr>
                                        <td colspan="11">Tidak ada data!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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

</div>