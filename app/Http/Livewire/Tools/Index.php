<?php

namespace App\Http\Livewire\Tools;

use App\Models\Tools;
use App\Models\ToolsMaster;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    public $teknisi;
    public $item;
    public $qty;
    public $idRemove = 0;

    protected $dataTools;
    public $toolsMaster;
    public $dataUser;

    public function mount()
    {
        $this->getDataMaster();
        $this->getDataUser();
    }
    public function render()
    {
        $this->getDataTools();
        return view('livewire.tools.index', [
            'tools' => $this->dataTools,
        ]);
    }

    public function  getDataTools()
    {
        $data = Tools::join('users', 'users.id', '=', 'tools.user_id')->where('tools.branch_id', Auth::user()->branch_id)
                    ->join('tools_masters', 'tools_masters.id', '=', 'tools.item_id')
                    ->select('tools.id', 'name', 'tools_name', 'merk', 'nomor_seri', 'tools.qty')->paginate(10);
        $this->dataTools = $data;
    }

    public function getDataMaster()
    {
        $data = ToolsMaster::where('branch_id', Auth::user()->branch_id)->get();
        $this->toolsMaster = $data;
    }

    public function getDataUser()
    {
        $user = User::where('branch_id', Auth::user()->branch_id)->get();
        $this->dataUser = $user;
    }

    public function setIdRemove($id)
    {
        $this->idRemove = $id;
    }

    public function assign()
    {
        $this->validate([
            'teknisi'       => 'required',
            'item'          => 'required',
            'qty'           => 'required',
        ]);

        $tools = ToolsMaster::findOrFail($this->item);
        $stockAwal = $tools->stock;
        $stockAkhir = $stockAwal-$this->qty;
        $stockTeknisi = $tools->stock_teknisi ?? 0;
        $stockTeknisiAkhir = $stockTeknisi+$this->qty;

        Tools::create([
            'item_id'       => $this->item,
            'user_id'       => $this->teknisi,
            'qty'           => $this->qty,
            'branch_id'     => Auth::user()->branch_id,
        ]);

        $updateMaster = ToolsMaster::findOrFail($this->item);
        $updateMaster->update([
            'stock'         => $stockAkhir,
            'stock_teknisi' => $stockTeknisiAkhir,
        ]);

        $this->getDataTools();

        

        // Kirim flash message
        session()->flash('success', 'Data berhasil disimpan!');

    }

    public function removed()
    {
        $load = Tools::findOrFail($this->idRemove);
        $master = ToolsMaster::findOrFail($load->item_id);

        $newStock = $master->stock+$load->qty;
        $stockTeknisi = $master->stock_teknisi ?? 0;
        $newStockTeknisi = $stockTeknisi-$load->qty;

        $updateMaster = ToolsMaster::findOrFail($load->item_id);
        $updateMaster->update([
            'stock'         => $newStock,
            'stock_teknisi' => $newStockTeknisi,
        ]);

        $delete = Tools::findOrFail($this->idRemove);
        $delete->delete();

        $this->getDataTools();
        $this->idRemove = 0;
        // Kirim flash message
        session()->flash('warning', 'Data berhasil dihapus!');
    }
}