<?php

namespace App\Http\Livewire\Sop;

use App\Models\Sop;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $loading = false;

    public $tagEdit = 0;
    public $sop;
    public $name;
    public $updateAt;
    public $baris;

    public function mount()
    {
        $this->getSop();
    }

    public function render()
    {
        return view('livewire.sop.index');
    }

    public function getSop()
    {
        $data = Sop::findOrFail(1);
        $this->sop = $data->sop ?? "";
        $this->name = $data->updated_by ?? "";
        $this->updateAt = $data->updated_at ?? "";
        $this->baris = $data->baris ?? "";
    }

    public function edit()
    {
        if($this->tagEdit == 1){
            $this->tagEdit = 0;
        }else{
            $this->tagEdit = 1;
        }
    }

    public function update()
    {
        $this->validate(['sop' => 'required']);
        $sop = Sop::findOrFail(1);
        $sop->update([
            'sop'           => $this->sop,
            'updated_by'    => Auth::user()->nik.' | '.Auth::user()->name
,        ]);

        $this->getSop();
        $this->tagEdit = 0;
        // Kirim flash message
        session()->flash('success', 'Data berhasil diperbaharui!');
    }
}
