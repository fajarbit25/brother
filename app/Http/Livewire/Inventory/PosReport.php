<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Operational;
use App\Models\Opsitem;
use App\Models\Order;
use App\Models\Pos as ModelPos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PosReport extends Component
{

    public $loading = false;
    public $start;
    public $end;
    public $dataPenjualan;
    public $tagDetail = 0;

    public $detail;
    public $totalTransaksi;
    public $discount;
    public $cashier;
    public $costumer;
    public $paymentMethod;
    public $tableDetail;
    public $paymentMethodUpdate;
    public $dataUnpaid;

    public function mount()
    {
        $this->getDataUnpaid();
    }

    public function render()
    {
        return view('livewire.inventory.pos-report');
    }

    public function updatedstart()
    {
        $this->getDataPenjualan();
    }

    public function updatedend()
    {
        $this->getDataPenjualan();
    }

    public function getDataPenjualan()
    {
        if($this->start && $this->end){
            $data = ModelPos::join('costumers', 'costumers.idcostumer', '=', 'pos.idcostumer')
                    ->join('orders', 'orders.uuid', '=', 'pos.id_transaksi')
                    ->whereBetween('pos.created_at', [$this->start, $this->end])
                    ->select('pos.id', 'pos.created_at', 'id_transaksi', 'costumer_name as name', 'pos.total_price', 'payment_status', 'discount')
                    ->orderBy('id', 'DESC')->get();
            $this->dataPenjualan = $data;
        }
    }

    public function detailTransaksi($tx_id)
    {
        $this->tagDetail = 1;
        $data = ModelPos::join('costumers', 'costumers.idcostumer', '=', 'pos.idcostumer')
                    ->join('users', 'users.id', '=', 'pos.user_id')
                    ->where('id_transaksi', $tx_id)
                    ->select('pos.id', 'pos.created_at', 'id_transaksi', 'costumer_name as name', 'total_price', 'payment_status', 'users.name as cashier')
                    ->first();
        $this->detail = $data;
        $this->cashier = $data->cashier;
        $this->costumer = $data->name;
        $this->getTotalTransaksi($data->id_transaksi);
        $this->getTableDetail($tx_id);
        $this->getDataPenjualan();
    }

    public function getTotalTransaksi($tx_id)
    {
        $transaksi = ModelPos::where('id_transaksi', $tx_id)->sum('total_price');
        $order = Order::where('uuid', $tx_id)->select('discount', 'payment')->first();
        $this->totalTransaksi = $transaksi ?? 0;
        $this->discount = $order->discount ?? 0;
        $this->paymentMethod = $order->payment ?? "";
    }

    public function getTableDetail($tx_id)
    {
        $data = ModelPos::join('products', 'products.diproduct', '=', 'pos.product_id')
                ->join('units', 'units.idunit', '=', 'products.satuan')
                ->where('id_transaksi', $tx_id)
                ->select('unit_code', 'product_name', 'price', 'total_price', 'qty')
                ->get();
        $this->tableDetail = $data;
    }

    public function updatePayment($tx_id)
    {
        $this->validate([
            'paymentMethodUpdate'       => 'required',
        ]);

        $opsItem = Opsitem::where('item', 'Penjualan Item')->first();
        $order = Order::where('uuid', $tx_id)->first();

        $ops = Operational::where('branch_id', Auth::user()->branch_id)
                    ->where('metode', $this->paymentMethodUpdate)->orderBy('id', 'DESC')->first();
        $saldoAwalOps = $ops->saldo ?? 0;

        //masukan saldo perusahaan
        Operational::create([
            'trx_id'        => time(),
            'metode'        => $this->paymentMethodUpdate,
            'tipe'          => "IN",
            'jenis'         => $opsItem->id,
            'branch_id'     => Auth::user()->branch_id,
            'approved'      => 1,
            'keterangan'    => 'Pembelian Item Oleh '.$this->costumer,
            'status'        => 'Success',
            'pesan'         => '-',
            'user_id'       => Auth::user()->id,
            'amount'        => $this->totalTransaksi-$this->discount,
            'saldo'         => $saldoAwalOps+$this->totalTransaksi-$this->discount,
            'bukti_transaksi'   => 'no-evidence.png',
            'nomor_nota'    => '-',
        ]);

        //update status order
        Order::where('uuid', $tx_id)->update([
            'status'            => 'Close',
            'status_invoice'    => 'Paid',
            'tag_invoice'       => 1,
            'payment'           => $this->paymentMethodUpdate,
        ]);

        //update status transaksi pos
        ModelPos::where('id_transaksi', $tx_id)
        ->update([
            'payment_status'    => 'Paid',
        ]);

        return redirect('/inventory/pos-report');

    }

    public function getDataUnpaid()
    {
        $data = ModelPos::where('payment_status', 'Unpaid')->get();
        $this->dataUnpaid = $data;
    }

}
