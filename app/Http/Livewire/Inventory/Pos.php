<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Costumer;
use App\Models\Mutation;
use App\Models\Operational;
use App\Models\Opsitem;
use App\Models\Order;
use App\Models\Ordermaterial;
use App\Models\Pos as ModelsPos;
use App\Models\Products;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public $loading = false;
    public $product;
    public $namaProduct;
    public $productSearchKey;
    public $dataProduct;
    public $qty;
    public $alertQty = 0;
    public $costumer;
    public $costumerName;
    public $dataCostumer;
    public $costumerSearchKey;

    public $tagTableProduct = 0;
    public $tagTableCostumer = 0;

    public $dataTransaksi;
    public $totalTransaksi;

    public $paymentMethod;
    public $paymentDiscount = 0;
    public $payment_kembali = 0;
    public $paymentCash = 0;
    public $teminDate;

    public function mount(){
        $this->teminDate = date('Y-m-d');
    }

    public function loadAll()
    {
        $this->getDataTransaksi();
    }
    public function render()
    {
        $this->loadAll();
        return view('livewire.inventory.pos');
    }

    public function getDataCostumer()
    {
        $data = Costumer::where('branch_id', Auth::user()->branch_id)
                ->select('idcostumer as id', 'costumer_name', 'costumer_kode', 'costumer_phone', 'costumer_address')->get();
        $this->dataCostumer = $data;
    }

    public function updatedcostumerSearchKey()
    {
        $data = Costumer::where('branch_id', Auth::user()->branch_id)
                ->where('costumer_name', 'like', '%'.$this->costumerSearchKey.'%')
                ->select('idcostumer as id', 'costumer_name', 'costumer_kode', 'costumer_phone', 'costumer_address')->get();
        $this->dataCostumer = $data;
    }

    public function getDataProduct()
    {
        $data = Products::join('units', 'units.idunit', '=', 'products.satuan')
                        ->join('stocks', 'stocks.product_id', '=', 'products.diproduct')
                        ->where('stocks.branch_id', Auth::user()->branch_id)
                        ->select('diproduct as id', 'stock', 'product_code', 'product_name', 'harga_jual as price',
                         'unit_code as satuan')->get();
        $this->dataProduct = $data;
    }

    public function updatedproductSearchKey()
    {
        $this->dataProduct = [];
        $data = Products::join('units', 'units.idunit', '=', 'products.satuan')
                        ->join('stocks', 'stocks.product_id', '=', 'products.diproduct')
                        ->where('stocks.branch_id', Auth::user()->branch_id)
                        ->where('product_name', 'like', '%'.$this->productSearchKey.'%')
                        ->select('diproduct as id', 'stock', 'product_code', 'product_name', 'harga_jual as price',
                         'unit_code as satuan')->get();
        $this->dataProduct = $data;
    }

    public function addProduct($id)
    {
        $this->product = $id;
        $data = Products::findOrFail($id);
        $this->namaProduct = $data->product_name;
        $this->tagTableProduct = 0;
        $this->getDataTransaksi();
    }


    public function showTableProduct()
    {
        $this->tagTableProduct = 1;
        $this->getDataProduct();
    }
    
    public function showTableCostumer()
    {
        $this->tagTableCostumer = 1;
        $this->getDataCostumer();
    }

    public function addCostumer($id)
    {
        $this->costumer = $id;
        $data = Costumer::findOrFail($id);
        $this->costumerName = $data->costumer_name;
        $this->tagTableCostumer = 0;
        $this->getDataTransaksi();
        $this->getTotalTransaksi();
    }

    public function submitProduct()
    {
        $this->validate([
            'product'   => 'required',
            'costumer'  => 'required',
            'qty'       => 'required',
        ]);


        $product = Products::findOrFail($this->product);

        $cekDataTransaksi = ModelsPos::where('branch_id', Auth::user()->branch_id)
                            ->where('idcostumer', $this->costumer)
                            ->where('temp_status', '1')
                            ->where('product_id', $this->product)
                            ->count();
        $countProductExisting = $cekDataTransaksi ?? 0;
        if($countProductExisting <= 0){
            ModelsPos::create([
                'branch_id'         => Auth::user()->branch_id,
                'product_id'        => $this->product,
                'qty'               => $this->qty,
                'price'             => $product->harga_jual,
                'total_price'       => $product->harga_jual*$this->qty,
                'temp_status'       => '1',
                'idcostumer'        => $this->costumer,
                'payment_status'    => 'Unpaid',
                'user_id'           => Auth::user()->id,
            ]);

        }else{
            $transaksi = ModelsPos::findOrFail($this->product);
            $newQty = $transaksi->qty+$this->qty;

            ModelsPos::where('product_id', $this->product)->update([
                'qty'               => $newQty,
                'total_price'       => $transaksi->price*$newQty, 
            ]);
        }
        

        $this->product = "";
        $this->namaProduct = "";
        $this->qty = "";
        $this->getDataTransaksi();
        $this->getTotalTransaksi();

    }

    public function getDataTransaksi()
    {
        $data = ModelsPos::join('products', 'products.diproduct', '=', 'pos.product_id')
                        ->join('units', 'units.idunit', '=', 'products.satuan')
                        ->where('branch_id', Auth::user()->branch_id)->where('idcostumer', $this->costumer)
                        ->where('temp_status', '1')
                        ->select('pos.id', 'product_code', 'product_name', 'price',
                        'unit_code as satuan', 'total_price', 'pos.qty')
                        ->get();
        $this->dataTransaksi = $data;
    }

    public function deleteTransaksi($id)
    {
        $transaksi = ModelsPos::findOrFail($id);
        $transaksi->delete();
        $this->getDataTransaksi();
        $this->getTotalTransaksi();
    }

    public function getTotalTransaksi()
    {
        $data = ModelsPos::where('branch_id', Auth::user()->branch_id)->where('idcostumer', $this->costumer)
                            ->where('temp_status', '1')->sum('total_price');
        $this->totalTransaksi = $data ?? 0;
    }

    public function openModalPayment()
    {
        $this->emit('openModalPayment');
    }

    public function prosesPayment()
    {
        $this->validate([
            'paymentCash' => 'required|integer',
        ]);

        if($this->paymentMethod == 'Pending'){
            $status_trx = "Unpaid";
            $orderStatus = 'Open';
            $tagInvoice = 0;
        }else{
            $status_trx = "Paid";
            $orderStatus = 'Close';
            $tagInvoice = 1;
        }

        $idTrx = 'POS'.time();

        $createOrder = Order::create([
            'uuid'              => $idTrx,
            'tanggal_order'     => date('Y-m-d'),
            'costumer_id'       => $this->costumer,
            'total_unit'        => 1,
            'progres'           => 'Complete',
            'status'            => $orderStatus,
            'invoice_id'        => time(),
            'status_invoice'    => $status_trx,
            'tag_invoice'       => $tagInvoice,
            'total_price'       => $this->totalTransaksi,
            'discount'          => $this->paymentDiscount,
            'nomor_nota'        => '0000',
            'nota'              => '-',
            'teknisi'           => Auth::user()->id,
            'helper'            => Auth::user()->id,
            'jadwal'            => '-',
            'request_jam'       => '--:--',
            'branch_id'         => Auth::user()->branch_id,
            'payment'           => $this->paymentMethod,
            'due_date'          => $this->teminDate,
        ]);

        $transaksi = ModelsPos::where('branch_id', Auth::user()->branch_id)->where('idcostumer', $this->costumer)
                        ->where('temp_status', '1')->get();
        foreach($transaksi as $items){

            $stok = Stock::where('product_id', $items->product_id)->where('branch_id', Auth::user()->branch_id)->first();
            $replaceStock = Stock::findOrFail($stok->idstock);
            $replaceStock->update([
                'stock'             => $stok->stock-$items->qty,
            ]);

            
            $mutasi = Mutation::where('product_id', $items->product_id)->orderBy('idmutasi', 'DESC')->first();
            Mutation::create([
                'product_id'        => $items->product_id,
                'tanggal_mutasi'    => date('Y-m-d'),
                'jenis'             => 'Outbound',
                'order_id'          => $idTrx,
                'reservasi_id'      => time(),
                'penerima'          => Auth::user()->id,
                'qty'               => $items->qty,
                'saldo_awal'        => $mutasi->saldo_akhir,
                'saldo_akhir'       => $mutasi->saldo_akhir-$items->qty,
                'branch_id'         => Auth::user()->branch_id,
            ]);

            Ordermaterial::create([
                'order_id'      => $createOrder->id,
                'product_id'    => $items->product_id,
                'teknisi_id'    => Auth::user()->id,
                'qty'           => $items->qty,
                'price'         => $items->price,
                'jumlah'        => $items->qty*$items->price,
            ]);
        }

        if($this->paymentMethod != 'Pending'){
            $opsItem = Opsitem::where('item', 'Penjualan Item')->first();
            $ops = Operational::where('branch_id', Auth::user()->branch_id)
                        ->where('metode', $this->paymentMethod)->orderBy('id', 'DESC')->first();
            $saldoAwalOps = $ops->saldo ?? 0;
            Operational::create([
                'trx_id'        => time(),
                'metode'        => $this->paymentMethod,
                'tipe'          => "IN",
                'jenis'         => $opsItem->id,
                'branch_id'     => Auth::user()->branch_id,
                'approved'      => 1,
                'keterangan'    => 'Pembelian Item Oleh '.$this->costumerName,
                'status'        => 'Success',
                'pesan'         => '-',
                'user_id'       => Auth::user()->id,
                'amount'        => $this->totalTransaksi,
                'saldo'         => $saldoAwalOps+$this->totalTransaksi,
                'bukti_transaksi'   => 'no-evidence.png',
                'nomor_nota'    => '-',
            ]);
        }

        $updateStatusTransaksi = ModelsPos::where('branch_id', Auth::user()->branch_id)->where('idcostumer', $this->costumer)
                        ->where('temp_status', '1')
                        ->update([
                            'id_transaksi'      => $idTrx,
                            'payment_status'    => $status_trx,
                            'temp_status'       => '0',
                        ]);

        return redirect('/inventory/pos-report');
    }

    public function updatedpaymentDiscount()
    {
        if(!$this->paymentDiscount){
            $this->paymentDiscount = 0;
        }
        $this->getTotalTransaksi();
        $this->totalTransaksi = $this->totalTransaksi-$this->paymentDiscount;
    }

    public function updatedpaymentMethod()
    {
        $this->teminDate = date('Y-m-d');
        $this->paymentDiscount = 0;
        $this->getTotalTransaksi();
    }

    public function updatedpaymentCash()
    {
        if(!$this->paymentCash){
            $this->paymentCash = 0;
        }
        $this->payment_kembali = $this->paymentCash-$this->totalTransaksi;
    }

    public function updatedqty()
    {
        $cek = Stock::where('product_id', $this->product)->where('branch_id', Auth::user()->branch_id)->first();
        $cekTransaksi = ModelsPos::where('branch_id', Auth::user()->branch_id)
                            ->where('product_id', $this->product)
                            ->where('temp_status', '1')->sum('qty');
        $qtyInTransaksi = $cekTransaksi ?? 0;
        $cekStock = $cek->stock-$qtyInTransaksi;

        if($cekStock < $this->qty){
            $this->alertQty = 1;
        }else{
            $this->alertQty = 0;
        }
    }


}
