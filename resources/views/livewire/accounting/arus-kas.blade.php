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
                            <table class="table table-borderless" style="font-size: 13px;">
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
                                        <th rowspan="4" class="bg-light align-middle text-center">No</th>
                                        <th rowspan="4" class="bg-light align-middle">Tanggal</th>
                                        <th rowspan="4" class="bg-light align-middle">Nota</th>
                                        <th rowspan="4" class="bg-light align-middle" style="white-space: nowrap;">Keterangan</th>
                                        <th rowspan="4" class="bg-light align-middle" style="white-space: nowrap;">Jenis Penjualan Unit / Jasa</th>
                                        <th rowspan="4" class="bg-light align-middle">Qty</th>
                                        <th colspan="8" class="bg-light text-center">Pembayaran</th>
                                        <th rowspan="4" class="bg-light align-middle text-center">Pengeluaran</th>
                                        <th rowspan="4" class="bg-light align-middle text-center">Petty Kas</th>
                                        <th rowspan="4" class="bg-light align-middle text-center">Saldo</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="3" class="bg-light align-middle text-center"> Cash </th>
                                        <th colspan="6" class="bg-light text-center"> Transfer </th>
                                        <th rowspan="3" class="bg-light align-middle text-center"> Belum Bayar </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="bg-light text-center"> BCA </th>
                                        <th colspan="2" class="bg-light text-center"> Mandiri </th>
                                        <th colspan="2" class="bg-light text-center"> BRI </th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light"> Debit </th>
                                        <th class="bg-light"> Credit </th>
                                        <th class="bg-light"> Debit </th>
                                        <th class="bg-light"> Credit </th>
                                        <th class="bg-light"> Debit </th>
                                        <th class="bg-light"> Credit </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($items->count() != 0)
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class="text-center"> {{$loop->iteration}} </td>
                                        <td style="white-space: nowrap;"> {{$item->tanggal}} </td>
                                        <td> {{$item->nota}} </td>
                                        <td style="white-space: nowrap;"> {{$item->costumer}} </td>
                                        <td> {{$item->items}} </td>
                                        <td> {{number_format($item->qty)}} </td>
                                        <td>
                                            @if ($item->payment_method == 'Cash' && $item->payment_type == 'debit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                       
                                        <td> 
                                            @if ($item->payment_method == 'BCA' && $item->payment_type == 'debit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                        <td>
                                            @if ($item->payment_method == 'BCA' && $item->payment_type == 'credit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>

                                        <td> 
                                            @if ($item->payment_method == 'Mandiri' && $item->payment_type == 'debit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                        <td>
                                            @if ($item->payment_method == 'Mandiri' && $item->payment_type == 'credit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>

                                        <td> 
                                            @if ($item->payment_method == 'BRI' && $item->payment_type == 'debit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                        <td>
                                            @if ($item->payment_method == 'BRI' && $item->payment_type == 'credit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                        <td> - </td>
                                        <td>
                                            @if ($item->payment_method == 'Cash' && $item->payment_type == 'credit') 
                                                Rp.{{number_format($item->amount)}},-
                                            @else - @endif
                                        </td>
                                        <td> Rp.{{number_format($item->petty_cash)}} </td>
                                        <td> Rp.{{number_format($item->saldo)}},- </td>
                                    </tr>
                                    @endforeach
                                    @else 
                                    <tr>
                                        <td colspan="17">Tidak ada data!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4 mt-3">
                            <table class="table table-bordered" style="font-size: 12px;">
                                <tr class="bg-light">
                                    <th colspan="2">RINCIAN SALDO</th>
                                </tr>
                                <tr>
                                    <th>BCA</th>
                                    <th>
                                        @php
                                            // Menghitung total debit BCA berdasarkan nota dan jumlahkan 'amount'
                                            $debitBCA = $items->where('payment_method', 'BCA')
                                                              ->where('payment_type', 'debit')
                                                              ->sum('amount') ?? 0;
                                                               // Menjumlahkan hasil grup 'nota'
                                            
                                            // Menghitung total credit BCA berdasarkan nota dan jumlahkan 'amount'
                                            $creditBCA = $items->where('payment_method', 'BCA')
                                                               ->where('payment_type', 'credit')
                                                               ->sum('amount') ?? 0;
                                
                                            // Selisih debit dan credit
                                            $totalBCA =  $debitBCA - $creditBCA;
                                        @endphp
                                
                                        Rp.{{ number_format($totalBCA ?? 0) }},-
                                    </th>
                                </tr>
                                
                                <tr>
                                    <th>MANDIRI</th>
                                    <th>
                                        @php
                                            $debitMandiri = $items->where('payment_method', 'Mandiri')->where('payment_type', 'debit')->sum('amount') ?? 0;
                                            $creditMandiri = $items->where('payment_method', 'Mandiri')->where('payment_type', 'credit')->sum('amount') ?? 0;
                                            $totalMandiri = $debitMandiri-$creditMandiri;
                                        @endphp
                                        Rp.{{number_format($totalMandiri ?? 0)}},-
                                    </th>
                                </tr>
                                <tr>
                                    <th>BRI</th>
                                    <th>
                                        @php
                                            $debitBRI = $items->where('payment_method', 'BRI')->where('payment_type', 'debit')->sum('amount') ?? 0;
                                            $creditBRI = $items->where('payment_method', 'BRI')->where('payment_type', 'credit')->sum('amount') ?? 0;
                                            $totalBRI =  $debitBRI-$creditBRI;
                                        @endphp
                                        Rp.{{number_format($totalBRI ?? 0)}},-
                                    </th>
                                </tr>
                                <tr>
                                    <th>CASH</th>
                                    <th>
                                        @php
                                            $debitCash = $items->where('payment_method', 'Cash')->where('payment_type', 'debit')->sum('amount') ?? 0;
                                            $creditCash = $items->where('payment_method', 'Cash')->where('payment_type', 'credit')->sum('amount') ?? 0;
                                            $totalCash =  $debitCash-$creditCash;
                                        @endphp
                                        Rp.{{number_format($totalCash ?? 0)}},-
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-light">GRAND TOTAL</th>
                                    <th class="bg-light">
                                        Rp. {{ number_format($totalBCA+$totalMandiri+$totalBRI+$totalCash ?? 0) }},-
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>

    </div>

</div>