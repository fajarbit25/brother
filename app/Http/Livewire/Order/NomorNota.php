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
                    ->where('tag_usage', 0)->select('nomor_notas.id', 'name', 'nomor', 'tag_usage')
                    ->orderBy('nomor_notas.id', 'DESC')->paginate(10);
        $this->dataNota = $data;
    }

    public function deleteNota($id)
    {
        $nota = ModelsNomorNota::findOrFail($id);
        $nota->delete();
        session()->flash('alert', 'Nomor Nota Dihapus!');
    }
}
