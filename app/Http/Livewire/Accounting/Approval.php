<?php

namespace App\Http\Livewire\Accounting;

use App\Models\AccountingApproval;
use App\Models\AccountingArusKhas;
use App\Models\AccountingSaldo;
use App\Models\Costumer;
use App\Models\Opsitem;
use App\Models\Order;
use App\Models\Orderitem;
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
                                ->where('order_id', $order->uuid)->select('items.item_name', 'orderitems.merk', 'orderitems.pk', 'orderitems.qty')
                                ->get();

                        $saldo = AccountingSaldo::where('branch_id', Auth::user()->branch_id)->first();

                        $saldoAkhir = $saldo->saldo_akhir+$data->amount;
                        if ($data->payment_method == 'Cash') {
                            $pettyKhas = $saldo->petty_cash+$data->amount;
                        } else {
                            $pettyKhas = $saldo->petty_cash;
                        }

                        //create arus khas
                        foreach ($items as $item) {
                            AccountingArusKhas::create([
                                'branch_id'         => Auth::user()->branch_id,
                                'tanggal'           => $data->tanggal,
                                'nota'              => $data->referensi_id,
                                'costumer'          => $cust->costumer_name,
                                'items'             => $item->item_name.' '.$item->merk.' '.$item->pk,
                                'qty'               => $item->qty,
                                'payment_method'    => $data->payment_method,
                                'payment_type'      => $data->tipe,
                                'amount'            => $data->amount,
                                'akun_id'           => $akun->id, //from ops item table
                                'klasifikasi'       => $akun->category,
                                'petty_cash'        => $pettyKhas,
                                'saldo'             => $saldoAkhir,
                            ]);
                        }

                        //update Saldo
                        $updateSaldo = AccountingSaldo::where('branch_id', Auth::user()->branch_id)
                                ->update([
                                    'petty_cash'    => $pettyKhas,
                                    'saldo_akhir'   => $saldoAkhir,
                                ]);

                        //update Approval
                        AccountingApproval::where('id', $approvalData->id)
                        ->update([
                            'approval'      => $this->statusApproval,
                        ]);

                        $this->emit('closeModal');
                        $this->reset('idApproval', 'idreferensi');

                        session()->flash('success', 'Approval berhasil!');

                    } catch (\Exception $e) {
                        session()->flash('warning', 'Terjadi kesalahan '.$e->getMessage());
                    }

                }

            }

        } else {
            session()->flash('warning', 'Referensi Id tidak tidak ditemukan!');
        }
    }
}
