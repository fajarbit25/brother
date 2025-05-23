<?php

namespace App\Http\Livewire\Order;

use App\Models\NomorNota as ModelsNomorNota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NomorNota extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    public $nomor;
    public $teknisi;

    public $dataTeknisi;
    private $dataNota;

    public $filterTeknisi;
    public $filterStatus = "";
    public $status;
    public $idEdit;

    public $nomorEdit;
    public $teknisiEdit;
    public $statusEdit;

    public $key = "";



    protected $rules = [
        'nomor'     => 'required|max:6|min:4|unique:nomor_notas',
        'teknisi'   => 'required',
    ];

    public function mount()
    {
        $this->getDataTeknisi();
    }

    public function loadAll()
    {
        $this->getDataNota();
    }

    public function render()
    {
        $this->loadAll();
        return view('livewire.order.nomor-nota', [
            'nota'      => $this->dataNota,
        ]);
    }

    public function getDataTeknisi()
    {
        $data = User::where('branch_id', Auth::user()->branch_id)->where('privilege', '>=', 9)
                    ->select('id', 'name')->get();
        $this->dataTeknisi = $data;
    }

    public function saveNota()
    {
        $this->validate();
        ModelsNomorNota::create([
            'nomor'     => $this->nomor,
            'user_id'   => $this->teknisi,
            'tag_usage' => 0,
        ]);
        session()->flash('message', 'Nomor Nota '.$this->nomor.' berhasil disimpan!');
        $this->nomor = "";
    }

    public function getDataNota()
    {
        $data = ModelsNomorNota::join('users', 'users.id', '=', 'nomor_notas.user_id')
                    ->leftJoin('orders', 'orders.nomor_nota', '=', 'nomor_notas.nomor')
                    ->select('nomor_notas.id', 'name', 'nomor', 'tag_usage', 'uuid')
                    ->orderBy('nomor_notas.id', 'DESC');

        if ($this->key != "") {
            $data->where('nomor', 'like', '%' . $this->key . '%');
        }

        if ($this->filterStatus != "") {
            $data->where('tag_usage', $this->filterStatus);
        }

        $this->dataNota = $data->paginate(10);
    }


    public function deleteNota($id)
    {
        $nota = ModelsNomorNota::findOrFail($id);
        $nota->delete();
        session()->flash('alert', 'Nomor Nota Dihapus!');
    }

    public function editNota($id)
    {
        $this->idEdit = $id;

        $queryNota = ModelsNomorNota::findOrFail($this->idEdit);

        $this->nomorEdit = $queryNota->nomor ?? 'tidak ditemukan';
        $this->teknisiEdit = $queryNota->user_id ?? 'tidak diketahui';
        $this->statusEdit = $queryNota->tag_usage ?? '';
    }

    public function updateNota()
    {
        $this->validate([
            'nomorEdit'     => 'required',
            'teknisiEdit'   => 'required',
            'statusEdit'    => 'required',
        ]);

        $query = ModelsNomorNota::findOrFail($this->idEdit);
        $query->update([
            'nomor'         => $this->nomorEdit,
            'user_id'       => $this->teknisiEdit,
            'tag_usage'     => $this->statusEdit,
        ]);

        $this->reset(
            'nomorEdit',
            'teknisiEdit',
            'statusEdit',
            'idEdit',
        );

        session()->flash('success', 'Data berhasil diperbaharui!');

        try {

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalaha. '.$e->getMessage());
        }
    }

    public function cancelEdit()
    {
        $this->reset('idEdit');
    }

}
