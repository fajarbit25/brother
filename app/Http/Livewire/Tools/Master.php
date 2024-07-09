<?php

namespace App\Http\Livewire\Tools;

use App\Models\Tools;
use App\Models\ToolsMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Master extends Component
{
    public $loading = false;
    use WithPagination;
    protected $dataMaster;
    public $name;
    public $merk;
    public $stock;
    public $nameEdit;
    public $merkEdit;
    public $stockEdit;
    public $idEdit;
    public $idDelete;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $this->getDataMaster();
        return view('livewire.tools.master', [
            'collection'    => $this->dataMaster,
        ]);
    }

    public function getDataMaster()
    {
        $data = ToolsMaster::where('branch_id', Auth::user()->branch_id)->orderBy('id', 'DESC')->paginate(10);
        $this->dataMaster = $data;
    }

    public function modalAdd()
    {
        $this->emit('modalAdd');
    }

    public function saved()
    {
        $this->validate([
            'name'      => 'required',
            'merk'      => 'required',
            'stock'     => 'required',
        ]);

        $data = [
            'tools_name'        => $this->name,
            'merk'              => $this->merk,
            'nomor_seri'        => '-',
            'stock'             => $this->stock,
            'stock_teknisi'     => 0,
            'branch_id'         => Auth::user()->id,
        ];

        ToolsMaster::create($data);

        // Kirim flash message
        session()->flash('success', 'Tools '.$this->name.' merk '.$this->merk.' ditambahkan !');

        $this->name = "";
        $this->merk = "";
        $this->stock = "";

        $this->emit('closeModal');
    }

    public function modalEdit($id)
    {
        $this->emit('modalEdit');
        $this->idEdit = $id;
        $data = ToolsMaster::findOrFail($this->idEdit);
        $this->nameEdit = $data->tools_name;
        $this->merkEdit = $data->merk;
        $this->stockEdit = $data->stock;
    }

    public function update()
    {
        $this->validate([
            'nameEdit'      => 'required',
            'merkEdit'      => 'required',
            'stockEdit'     => 'required',
        ]);

        $data = [
            'tools_name'        => $this->nameEdit,
            'merk'              => $this->merkEdit,
            'stock'             => $this->stockEdit,
        ];

        $update = ToolsMaster::findOrFail($this->idEdit);
        $update->update($data);

        // Kirim flash message
        session()->flash('success', 'Tools '.$this->nameEdit.' merk '.$this->merkEdit.' diupdate !');

        $this->nameEdit = "";
        $this->merkEdit = "";
        $this->stockEdit = "";

        $this->emit('closeModal');
    }

    public function modalDelete($id)
    {
        $this->idDelete = $id;
        $this->emit('modalDelete');
    }

    public function deleted()
    {
        $data = ToolsMaster::findOrFail($this->idDelete);
        $data->delete();

        Tools::where('item_id', $this->idDelete)->delete();

        $this->emit('closeModal');

        // Kirim flash message
        session()->flash('warning', 'Tools dihapus !');
    }
}
