<?php

namespace App\Http\Livewire\Accounting;

use App\Models\AccountingArusKhas;
use App\Models\Opsitem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ArusKas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    private $items;
    public $start;
    public $end;
    public $akun;
    public $dataAkun;
    public $method;
    public $tipe;

    public function render()
    {
        $this->getAkun();
        $this->getItems();

        return view('livewire.accounting.arus-kas', [
            'items'     => $this->items,
        ]);
    }

    public function getItems()
    {
        $query = AccountingArusKhas::join('opsitems', 'opsitems.id', '=', 'accounting_arus_khas.akun_id')
                    ->where('branch_id', Auth::user()->branch_id);

        if ($this->start && $this->end) {
            $query->whereBetween('tanggal', [$this->start, $this->end]);
        }

        if ($this->akun) {
            $query->where('akun_id', $this->akun);
        }

        if ($this->method) {
            $query->where('payment_method', $this->method);
        }

        if ($this->tipe) {
            $query->where('payment_type', $this->tipe);
        }

        $this->items = $query->select(
            'accounting_arus_khas.*',
            'opsitems.item',
        )->paginate(10);
    }

    public function reloadData()
    {
        $this->getItems();
    }

    public function getAkun()
    {
        $this->dataAkun = Opsitem::all();
    }
}
