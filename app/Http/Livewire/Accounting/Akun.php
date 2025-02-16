<?php

namespace App\Http\Livewire\Accounting;

use App\Models\AccountingArusKhas;
use App\Models\AccountingKlasifikasiAkun;
use App\Models\Operational;
use App\Models\Opsitem;
use Livewire\Component;
use Livewire\WithPagination;

class Akun extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    private $items;
    public $dataKlasifikasi;
    public $idEdit;

    public $akun;
    public $type;
    public $klasifikasi;
    public $kategory;
        

    public function mount()
    {
        $this->getKlasifikasi();
    }

    public function render()
    {
        $this->getItems();
        return view('livewire.accounting.akun', [
            'items' => $this->items
        ]);
    }

    public function getItems()
    {
        $query = Opsitem::join('accounting_klasifikasi_akuns', 'accounting_klasifikasi_akuns.id', '=', 'opsitems.klasifikasi')
                    ->select('opsitems.*', 'accounting_klasifikasi_akuns.klasifikasi')->paginate(10);
        $this->items = $query;
    }

    public function getKlasifikasi()
    {
        $this->dataKlasifikasi = AccountingKlasifikasiAkun::All();
    }

    public function modalAdd()
    {
        $this->emit('modalAdd');
    }

    public function submitData()
    {
        $this->validate([
           'akun'       => 'required',
           'type'       => 'required',
           'klasifikasi'=> 'required',
           'kategory'   => 'required',
        ]);

        try {
            Opsitem::create([
                'item'          => $this->akun,
                'category'      => $this->kategory,
                'akun'          => 0,
                'type'          => $this->type,
                'klasifikasi'   => $this->klasifikasi,
            ]);
            $this->resetForm();
            $this->emit('closeModal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan, '.$e->getMessage());
        }
    }

    public function editData($id)
    {
        $this->idEdit = $id;

        $query = Opsitem::find($this->idEdit);

        $this->akun = $query->item;
        $this->kategory = $query->category;
        $this->type = $query->type;
        $this->klasifikasi = $query->klasifikasi;

        $this->emit('modalAdd');
    }

    public function updateData()
    {
        $this->validate([
            'akun'       => 'required',
            'type'       => 'required',
            'klasifikasi'=> 'required',
            'kategory'   => 'required',
         ]);
 
         try {
             $query = Opsitem::find($this->idEdit);
             $query->update([
                 'item'          => $this->akun,
                 'category'      => $this->kategory,
                 'akun'          => 0,
                 'type'          => $this->type,
                 'klasifikasi'   => $this->klasifikasi,
             ]);
             $this->resetForm();
             $this->emit('closeModal');
         } catch (\Exception $e) {
             session()->flash('error', 'Terjadi kesalahan, '.$e->getMessage());
         }
    }

    public $idDelete;
    public function deleteData($id)
    {
        $this->idDelete = $id;
        $this->emit('modalDelete');
    }

    public function prosesDeleteData()
    {
        /**Cek akun pada operational*/
        $cekOperational = Operational::where('jenis', $this->idDelete)->count();
        if ($cekOperational == 0) {

            /**Cek akun pada arus kas */
            $cekArusKhas = AccountingArusKhas::where('akun_id', $this->idDelete)->count();
            if ($cekArusKhas == 0) {

                try {

                    $query = Opsitem::find($this->idDelete);
                    $query->delete();

                    $this->resetForm();
                    $this->emit('closeModal');

                } catch (\Exception $e) {
                    session()->flash('error', 'Terjadi kesalahan, '.$e->getMessage());
                }

            } else {
                session()->flash('error', 'Gagal.., Kode / Akun Terpakai pada laporan anda!');
            }

        } else {
            session()->flash('error', 'Gagal.., Kode / Akun Terpakai pada laporan anda!');
        }

    }

    public function resetForm()
    {
        $this->reset(
            'idDelete',
            'idEdit',
            'akun',
            'type',
            'klasifikasi',
            'kategory',
        );
    }
}
