<?php

namespace App\Http\Livewire\Accounting;

use App\Models\AccountingArusKhas;
use App\Models\CompanySaldo;
use App\Models\Opsitem;
use Carbon\Carbon;
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

    public $saldoCash;
    public $saldoBRI;
    public $saldoBCA;
    public $saldoMandiri;
    public $saldoTotal;

    public function mount()
    {
        // Tentukan tanggal 25 bulan ini
        $tanggal = Carbon::now()->startOfMonth()->addDays(24); // 25 hari dari awal bulan ini

        // Tentukan tanggal 25 bulan sebelumnya
        $tanggalSebelumnya = $tanggal->copy()->subMonth(); // Salin tanggal dan kurangi 1 bulan

        // Format tanggal
        $this->start = $tanggalSebelumnya->format('Y-m-d');
        $this->end = $tanggal->format('Y-m-d');
    }

    public function render()
    {
        $this->getAkun();
        $this->getItems();
        $this->getTotalSaldo();

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
        )->get();
    }

    public function reloadData()
    {
        $this->getItems();
    }

    public function getAkun()
    {
        $this->dataAkun = Opsitem::all();
    }

    public function getTotalSaldo()
    {
        $query = CompanySaldo::where('branch_id', Auth::user()->branch_id)
                ->select('tipe', 'saldo')->get();
        
        $cash = $query->where('tipe', 'Cash')->first();
        $this->saldoCash = $cash ? $cash->saldo : 0;

        $bri = $query->where('tipe', 'BRI')->first();
        $this->saldoBRI = $bri ? $bri->saldo : 0;

        $bca = $query->where('tipe', 'BCA')->first();
        $this->saldoBCA = $bca ? $bca->saldo : 0;

        $mandiri = $query->where('tipe', 'Mandiri')->first();
        $this->saldoMandiri = $mandiri ? $mandiri->saldo : 0;

        $this->saldoTotal = $this->saldoTotal = $query->sum('saldo') ?? 0;

                
    }
}
