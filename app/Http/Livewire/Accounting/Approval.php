<?php

namespace App\Http\Livewire\Accounting;

use App\Models\AccountingApproval;
use App\Models\AccountingArusKhas;
use App\Models\AccountingSaldo;
use App\Models\CompanySaldo;
use App\Models\Costumer;
use App\Models\Invoice;
use App\Models\Operational;
use App\Models\Opsitem;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Ordermaterial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Approval extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    private $items;
    public $status = 'new';
    public $start;
    public $end;
    public $idApproval;
    public $idreferensi;
    public $statusApproval;
    public $dataItems;
    public $dataMaterial;

    public $nomorNota;
    public $costumerName;
    public $costumerPhone;

    public function render()
    {
        $this->getItems();
        return view('livewire.accounting.approval', [
            'items'     => $this->items,
        ]);
    }

    public function reloadItems()
    {
        $this->getItems();
        $this->emit('closeModal');
    }

    public function getItems()
    {
        $query = AccountingApproval::query();

        // Filter berdasarkan status
        if ($this->status !== 'all') {
            $query->where('approval', $this->status);
        }

        // Filter berdasarkan rentang tanggal jika start dan end diisi
        if (!empty($this->start) && !empty($this->end)) {
            $query->whereBetween('tanggal', [$this->start, $this->end]);
        }

        // Urutkan berdasarkan tanggal dan paginasi
        $this->items = $query->orderBy('tanggal', 'ASC')->paginate(10);
    }


    public function modalFilter()
    {
        $this->emit('modalFilter');
    }

    public function modalApproval($id)
    {
        $this->idApproval = $id;
        $this->emit('modalApproval');
    }

    public function submitApproval()
    {
        $this->validate([
            'idreferensi'   => 'required',
        ]);

        //cek idreferensi 
        $approvalData = AccountingApproval::find($this->idApproval);

        if ($approvalData->referensi_id == $this->idreferensi) {

            if ($approvalData->segment == 'Nota') {

                if ($this->statusApproval == 'rejected') {
                    try {

                        //update order
                        Order::where('nomor_nota', $this->idreferensi)->update([
                            'payment'       => null,
                            'due_date'      => null,
                            'status'        => 'Open',
                            'status_invoice'=> null,
                            'invoice_id'    => null,
                            'tag_invoice'   => 0,
                        ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);
                        
                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                    } catch (\Exception $e) {
                        session()->flash('warning', 'Terjadi kesalahan '.$e->getMessage());
                    }
                }

                if ($this->statusApproval == 'approved') {
                    try {

                        $data = AccountingApproval::findOrFail($approvalData->id);
                        $order = Order::where('nomor_nota', $data->referensi_id)->first();
                        $cust = Costumer::findOrFail($order->costumer_id);
                        $akun = Opsitem::findOrFail($data->akun_id);

                        $items = Orderitem::join('items', 'items.iditem', '=', 'orderitems.item_id')
                                ->where('order_id', $order->uuid)->select('items.item_name', 'orderitems.merk',
                                 'orderitems.pk', 'orderitems.qty', 'orderitems.price')
                                ->get();

                       


                        //create arus khas
                        foreach ($items as $item) {

                            $saldo = AccountingSaldo::where('branch_id', Auth::user()->branch_id)->first();

                            if ($data->tipe == 'debit') {
                                $saldoAkhir = $saldo->saldo_akhir+$item->price;
                            }
                            if ($data->tipe == 'credit') {
                                $saldoAkhir = $saldo->saldo_akhir-$item->price;
                            }
    
                            if ($data->payment_method == 'Cash' && $data->tipe == 'debit') {
                                $pettyKhas = $saldo->petty_cash+$item->price;
                            } elseif ($data->payment_method == 'Cash' && $data->tipe == 'credit') {
                                $pettyKhas = $saldo->petty_cash-$item->price;
                            } else {
                                $pettyKhas = $saldo->petty_cash;
                            }

                            AccountingArusKhas::create([
                                'branch_id'         => Auth::user()->branch_id,
                                'tanggal'           => $data->tanggal,
                                'nota'              => $data->referensi_id,
                                'costumer'          => $cust->costumer_name,
                                'items'             => $item->item_name.' '.$item->merk.' '.$item->pk,
                                'qty'               => $item->qty,
                                'payment_method'    => $data->payment_method,
                                'payment_type'      => $data->tipe,
                                'amount'            => $item->price,
                                'akun_id'           => $akun->id, //from ops item table
                                'klasifikasi'       => $akun->category,
                                'petty_cash'        => $pettyKhas,
                                'saldo'             => $saldoAkhir,
                            ]);


                            //update Saldo
                            AccountingSaldo::where('branch_id', Auth::user()->branch_id)
                            ->update([
                                'petty_cash'    => $pettyKhas,
                                'saldo_akhir'   => $saldoAkhir,
                            ]);

                        }

                        

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);

                        /**Create Operational */
                        $akun = Opsitem::where('item', 'Jasa Nota')->first();
                        $totalPrice = $order->total_price - $order->discount ?? 0;
                        $data = [
                            'trx_id'    => $order->nomor_nota,
                            'tipe'      => 'IN',
                            'metode'    => $order->payment,
                            'jenis'     => $akun->id,
                            'branch_id' => Auth::user()->branch_id,
                            'approved'  => 1,
                            'keterangan'=> 'Nota Payment '.$order->nomor_nota,
                            'status'    => 'Success',
                            'pesan'     => '-',
                            'user_id'   => Auth::user()->id,
                            'amount'    => $totalPrice,
                            'saldo'     => 0,
                            'bukti_transaksi' => '-',
                            'nomor_nota'=> '-',
                            'status_approval'   => 'approved',
                        ];
                        Operational::create($data);

                        /**Penambahan saldo */
                        $saldoData = CompanySaldo::where('tipe', $order->payment)
                                ->where('branch_id', Auth::user()->branch_id)
                                ->first();
                        $companySaldo = CompanySaldo::findOrFail($saldoData->id);
                        $companySaldo->update([
                            'saldo'     => $saldoData->saldo + $totalPrice,
                        ]);
                        /**End Of Penambahan saldo */


                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                        session()->flash('success', 'Approval berhasil!');

                    } catch (\Exception $e) {
                        session()->flash('warning', 'Terjadi kesalahan '.$e->getMessage());
                    }

                }

            }

            if ($approvalData->segment == 'Operational') {

                try {

                    if ($this->statusApproval == 'rejected') {

                        //update status operational
                        Operational::where('trx_id', $this->idreferensi)->update([
                            'status_approval'   => 'rejected',
                        ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);
                        
                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                    }

                    if ($this->statusApproval == 'approved') {

                        $data = AccountingApproval::findOrFail($approvalData->id);
                        $ops = Operational::where('trx_id', $data->referensi_id)->first();
                        $akun = Opsitem::findOrFail($data->akun_id);

                        $saldo = AccountingSaldo::where('branch_id', Auth::user()->branch_id)->first();

                        if ($data->tipe == 'debit') {
                            $saldoAkhir = $saldo->saldo_akhir+$data->amount;
                        } elseif ($data->tipe == 'credit') {
                            $saldoAkhir = $saldo->saldo_akhir-$data->amount;
                        } else {
                            session()->flash('error', 'Tampaknya Saldo bermasalah');
                        }

                        if ($data->payment_method == 'Cash' && $data->tipe == 'debit') {
                            $pettyKhas = $saldo->petty_cash+$data->amount;
                        } elseif ($data->payment_method == 'Cash' && $data->tipe == 'credit') {
                            $pettyKhas = $saldo->petty_cash-$data->amount;
                        } else {
                            $pettyKhas = $saldo->petty_cash;
                        }

                        /**Create Arus Kas */
                        AccountingArusKhas::create([
                            'branch_id'         => Auth::user()->branch_id,
                            'tanggal'           => $data->tanggal,
                            'nota'              => $data->referensi_id,
                            'costumer'          => $akun->item,
                            'items'             => $ops->keterangan,
                            'qty'               => 1,
                            'payment_method'    => $data->payment_method,
                            'payment_type'      => $data->tipe,
                            'amount'            => $data->amount,
                            'akun_id'           => $akun->id, //from ops item table
                            'klasifikasi'       => $akun->category,
                            'petty_cash'        => $pettyKhas,
                            'saldo'             => $saldoAkhir,
                        ]);

                        //update Saldo
                        AccountingSaldo::where('branch_id', Auth::user()->branch_id)
                        ->update([
                            'petty_cash'    => $pettyKhas,
                            'saldo_akhir'   => $saldoAkhir,
                        ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);

                        //update status operational
                        Operational::where('trx_id', $data->referensi_id)->update([
                            'status_approval'   => $this->statusApproval,
                        ]);

                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                        session()->flash('success', 'Approval berhasil!');

                    }
                    
                } catch (\Exception $e) {
                    session()->flash('warning', 'Terjadi kesalahan '.$e->getMessage());
                }

            }

            if ($approvalData->segment == 'Jasa Invoice') {

                try {

                    if ($this->statusApproval == 'rejected') {

                        $operationalData = Operational::where('trx_id', $this->idreferensi)->first();

                        /**Penambahan saldo */
                        $saldoData = CompanySaldo::where('tipe', $operationalData->metode)
                                ->where('branch_id', Auth::user()->branch_id)
                                ->first();
                        $companySaldo = CompanySaldo::findOrFail($saldoData->id);
                        $companySaldo->update([
                            'saldo'     => $saldoData->saldo - $operationalData->amount,
                        ]);

                        //delete status operational
                        Operational::where('trx_id', $this->idreferensi)->delete();

                        //update invoice
                        Invoice::where('nomor', $this->idreferensi)->update([
                            'status'    => 'Approved',
                        ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);
                        
                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                    }

                    if ($this->statusApproval == 'approved') {

                        $data = AccountingApproval::findOrFail($approvalData->id);
                        $ops = Operational::where('trx_id', $data->referensi_id)->first();
                        $akun = Opsitem::findOrFail($data->akun_id);

                        $saldo = AccountingSaldo::where('branch_id', Auth::user()->branch_id)->first();

                        if ($data->tipe == 'debit') {
                            $saldoAkhir = $saldo->saldo_akhir+$data->amount;
                        } elseif ($data->tipe == 'credit') {
                            $saldoAkhir = $saldo->saldo_akhir-$data->amount;
                        } else {
                            session()->flash('error', 'Tampaknya Saldo bermasalah');
                        }

                        if ($data->payment_method == 'Cash' && $data->tipe == 'debit') {
                            $pettyKhas = $saldo->petty_cash+$data->amount;
                        } elseif ($data->payment_method == 'Cash' && $data->tipe == 'credit') {
                            $pettyKhas = $saldo->petty_cash-$data->amount;
                        } else {
                            $pettyKhas = $saldo->petty_cash;
                        }

                        /**Create Arus Kas */
                        AccountingArusKhas::create([
                            'branch_id'         => Auth::user()->branch_id,
                            'tanggal'           => $data->tanggal,
                            'nota'              => $data->referensi_id,
                            'costumer'          => $akun->item,
                            'items'             => $ops->keterangan,
                            'qty'               => 1,
                            'payment_method'    => $data->payment_method,
                            'payment_type'      => $data->tipe,
                            'amount'            => $data->amount,
                            'akun_id'           => $akun->id, //from ops item table
                            'klasifikasi'       => $akun->category,
                            'petty_cash'        => $pettyKhas,
                            'saldo'             => $saldoAkhir,
                        ]);

                        //update Saldo
                        AccountingSaldo::where('branch_id', Auth::user()->branch_id)
                        ->update([
                            'petty_cash'    => $pettyKhas,
                            'saldo_akhir'   => $saldoAkhir,
                        ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);

                        //update status operational
                        Operational::where('trx_id', $data->referensi_id)->update([
                            'status_approval'   => $this->statusApproval,
                        ]);

                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                        session()->flash('success', 'Approval berhasil!');

                    }
                    
                } catch (\Exception $e) {
                    session()->flash('warning', 'Terjadi kesalahan '.$e->getMessage());
                }

            }

        } else {
            session()->flash('warning', 'Referensi Id tidak tidak ditemukan!');
        }
    }

    public function modalReviewNota($id)
    {

        $this->nomorNota = $id;
        $order = Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                ->where('nomor_nota', $this->nomorNota)
                ->select('orders.*', 'costumers.costumer_name', 'costumers.costumer_phone')
                ->first();

        $query = OrderItem::join('items', 'items.iditem', '=', 'orderitems.item_id')
                ->where('orderitems.order_id', $order->uuid)
                ->select('orderitems.*', 'items.item_name')
                ->get();
        $this->dataItems = $query;

        $queryMaterial = Ordermaterial::join('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                        ->where('order_id', $order->idorder)
                        ->select('ordermaterials.*', 'products.product_name', 'products.harga_jual')
                        ->get();
        $this->dataMaterial = $queryMaterial;

        $this->costumerName = $order->costumer_name ?? '-';
        $this->costumerPhone = $order->costumer_phone ?? '';
        $this->emit('modalReview');
    }

    public function resetDetail()
    {
        $this->reset('nomorNota', 'costumerName', 'costumerPhone');
        $this->emit('closeModal');
    }
}
