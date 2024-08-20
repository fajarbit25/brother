<div class="col-sm-12">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->

        <div class="col-md-12">

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">
                <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                Pekerjaan Jasa
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
                <div class="col-sm-12 mb-3">
                    <div class="input-group">
                        <input type="date" class="form-control" wire:model="start">
                        <input type="date" class="form-control" wire:model="end">
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="teknisi">Teknisi Filter</label>
                        <select class="form-control" wire:model="teknisi">
                            <option value="ALL">ALL</option>
                            @foreach ($dataTeknisi as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="teknisi">Jumlah Baris</label>
                        <input type="number" class="form-control" wire:model="row">
                    </div>
                </div>
                <div class="col-sm-12">
                    <table class="table" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Order ID</th>
                                <th>Costumer</th>
                                <th>Item</th>
                                <th>Jasa</th>
                                <th>Disc</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Material</th>
                                <th>Teknisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($order)
                            @foreach ($order->groupBy('idoi') as $idoi => $items)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$items->first()->tanggal_order}} </td>
                                <td> {{$items->first()->uuid}} </td>
                                <td> {{$items->first()->costumer_name}} </td>
                                <td> {{$items->first()->item_name}} </td>
                                <td> {{number_format($items->first()->jasa)}} </td>
                                <td>{{number_format($items->first()->disc)}}</td>
                                <td>
                                    @foreach($items as $item)
                                        @if($item->product_name)
                                            -{{$item->product_name}} <br/>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($items as $item)
                                        @if($item->product_name)
                                            {{number_format($item->qty_material).' '.$item->satuan}}<br/>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($items as $item)
                                        @if($item->product_name)
                                            {{number_format($item->harga_jual)}}<br/>
                                        @endif
                                    @endforeach
                                </td>
                                <td> {{$items->first()->teknisi.'-'.$items->first()->helper}} </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="12">{{$order->links()}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        Detail
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
                            <div class="card" style="width: 20rem;">
                                <div class="card-header">
                                  Detail Order
                                </div>
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">Total Jasa</div>
                                        <div class="col-6">: Rp.{{number_format($totalJasa)}}</div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">Margin Material</div>
                                        <div class="col-6">: Rp.{{number_format($totalMaterial-$modalMaterial)}}</div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">Potongan Discount</div>
                                        <div class="col-6">: Rp.{{number_format($totalDiscount)}}</div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">Potongan Pajak</div>
                                        <div class="col-6">: Rp.{{number_format($totalPPN)}}</div>
                                    </div>
                                  </li>
                                </ul>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">Grand Total</div>
                                        <div class="col-6">: Rp.{{number_format($totalJasa+$totalMaterial-$totalDiscount-$totalPPN)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="width: 20rem;">
                                <div class="card-header">
                                  Unit
                                </div>
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">Total Unit</div>
                                        <div class="col-6">: 
                                           {{$sumUnit}}
                                        </div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">-</div>
                                        <div class="col-6">: -</div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">-</div>
                                        <div class="col-6">: -</div>
                                    </div>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-6">-</div>
                                        <div class="col-6">: -</div>
                                    </div>
                                  </li>
                                </ul>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">Grand Total</div>
                                        <div class="col-6">: 
                                            {{$sumUnit}} Unit</div>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="width: 20rem;">
                                <div class="card-header">
                                  Operational
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($dataOps->groupBy('item') as $item => $items)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-6">{{$item}}</div>
                                            <div class="col-6">: Rp.{{number_format($items->sum('amount'))}} </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">Grand Total</div>
                                        <div class="col-6">: Rp.{{number_format($dataOps->sum('amount'))}}</div>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->
</div>
