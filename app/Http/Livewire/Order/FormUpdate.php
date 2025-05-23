<?php

namespace App\Http\Livewire\Order;

use App\Models\Merk;
use App\Models\NomorNota;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Timeline;
use App\Models\TrackingOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormUpdate extends Component
{
    use WithFileUploads;
    public $tagUploadNota = 0;
    public $tagContinous = 0;
    public $tagPending = 0;
    public $status;
    public $progres;
    public $idorder;
    public $uuid;
    public $items;
    public $dataMerk;

    public $idItem;
    public $merk;
    public $pk;
    public $lantai;
    public $ruangan;
    public $kodeUnit;
    public $teknisi;
    public $helper;

    public $photo;
    public $nomorNota;

    public $keteranganContinous;
    public $keteranganPending;


    public function mount($idorder)
    {
        $this->idorder = $idorder;

        $this->getStatus();
    }

    public function render()
    {
        $this->getItem();
        $this->getMerk();
        return view('livewire.order.form-update');
    }

    public function getItem()
    {
        $query = Orderitem::join('items', 'items.iditem', '=', 'orderitems.item_id')
            ->where('order_id', $this->uuid)
            ->select(
                'orderitems.idoi',
                'items.item_name',
                'merk',
                'pk',
                'lantai',
            )
            ->get();
        $this->items = $query;
    }

    public function getStatus()
    {
        $query = Order::where('idorder', $this->idorder)
                ->select(
                    'idorder', 
                    'status', 
                    'progres', 
                    'uuid',
                    'teknisi',
                    'helper')
                ->first();
        $this->status = $query->status ?? 'load gagal!';
        $this->progres = $query->progres ?? 'load gagal!';
        $this->uuid = $query->uuid ?? 'none';
        $this->teknisi = $query->teknisi ?? '-';
        $this->helper = $query->helper ?? '-';
    }

    public function getMerk()
    {
        $query = Merk::all();
        $this->dataMerk = $query;
    }

    public function recallOrder()
    {
        Order::where('idorder', $this->idorder)->update([
            'progres'       => 'Processing',
            'status'        => 'Open',
            'status_invoice'=> null,
            'tag_invoice'   => 0,
            'payment'       => null,
        ]);

        $this->getStatus();
    }

    public function updateItem()
    {
        $this->validate([
            'idItem'        => 'required',
            'merk'          => 'required',
            'pk'            => 'required',
            'lantai'        => 'required',
            'ruangan'       => 'required',
            'kodeUnit'      => 'required',
        ]);

        try {

            Orderitem::where('idoi', $this->idItem)
            ->update([
                'merk'          => $this->merk,
                'pk'            => $this->pk,
                'lantai'        => $this->lantai,
                'ruangan'       => $this->ruangan,
            ]);

            $cekTrackId = TrackingOrder::where('order_id', $this->uuid)
            ->where('item_id', $this->idItem)
            ->count();

            if ($cekTrackId <= 0) {

                TrackingOrder::create([
                    'track_id'  => $this->kodeUnit,
                    'order_id'  => $this->uuid,
                    'item_id'   => $this->idItem,
                    'teknisi'   => $this->teknisi,
                    'helper'    => $this->helper,
                ]);

            } else {
                TrackingOrder::where('order_id', $this->uuid)
                ->where('item_id', $this->idItem)
                ->update([
                    'track_id'  => $this->kodeUnit,
                ]);
            }

            return redirect('order/'.$this->uuid.'/show');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function updatedidItem()
    {
        $query = Orderitem::where('idoi', $this->idItem)
            ->select(
                'merk',
                'pk',
                'lantai',
                'ruangan',
            )
            ->first();

        $queryTrackId = TrackingOrder::where('order_id', $this->uuid)
            ->where('item_id', $this->idItem)
            ->select('track_id')
            ->first();


        $this->merk = $query->merk ?? '';
        $this->pk = $query->pk ?? '';
        $this->lantai = $query->lantai ?? '';
        $this->ruangan = $query->ruangan ?? '';
        $this->kodeUnit = $queryTrackId->track_id ?? '';
    }

    public function changeTagUploadNota()
    {

        if ($this->tagUploadNota == '0') {
            $this->tagUploadNota = '1';
        } else {
            $this->tagUploadNota = '0';
        }
    }

    public function changeTagContinous()
    {     

        if ($this->tagContinous == '0') {
            $this->tagContinous = '1';
        } else {
            $this->tagContinous = '0';
        }
    }

    public function changeTagPending()
    {     

        if ($this->tagPending == '0') {
            $this->tagPending = '1';
        } else {
            $this->tagPending = '0';
        }
    }

    public function uploadNota()
    {
        $this->validate([
            'photo'     => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'nomorNota' => 'required',
        ]);

        $queryLoadOrder = Order::where('idorder', $this->idorder)->first();

        $cekNota = NomorNota::where('nomor', $this->nomorNota)
                    ->where('user_id', $queryLoadOrder->teknisi)
                    ->where('tag_usage', 0)
                    ->count();

        if($cekNota >= 1){
            $gambar = $this->photo;
            $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/nota', $nama_gambar);

            /**update data order */
            Order::where('idorder', $this->idorder)->update([
                'nota'      => $nama_gambar,
                'progres'   => 'Closing',
                'nomor_nota'    => $this->nomorNota,
            ]);

            /**Added Timeline */
            Timeline::create([
                'order_id'          => $this->idorder,
                'user_id'           => $queryLoadOrder->teknisi,
                'timeline_status'   => 'Order telah dikerjakan oleh tim teknisi.',  
                'keterangan'        => 'Order Closing'
            ]);

            /**Update Nomor Nota */
            NomorNota::where('nomor', $this->nomorNota)->update(['tag_usage' => 1]);

            $this->approveNota();

        }else{
            
            session()->flash('error', 'Gagal mengupload, Nomor Nota tidak terdaftar, Atau telah digunakan!');

        }

    }

    public function approveNota()
    {
        $load = Order::where('idorder', $this->idorder)->first();
        Order::where('idorder', $this->idorder)->update([
            'progres'   => 'Complete',
        ]);

        /**update count order teknisi */
        // $loadTeknisi = User::where('id', $load->teknisi)->first();
        // $loadHelper = User::where('id', $load->helper)->first();

        // Pastikan teknisi_order_count tidak null sebelum dikurangkan
        // $countTeknisi = ($loadTeknisi->teknisi_order_count ?? 0) - 1;
        // $countHelper = ($loadHelper->teknisi_order_count ?? 0) - 1;


        // User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        // User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        return redirect('order/'.$this->uuid.'/show')->with('success', 'Nota berhasil diupload, [Order Closed]');
    }


    public function continueOrder()
    {
        $this->validate([
            'idorder'    => 'required',
        ]);

        /**update count order teknisi */
        $order = Order::where('idorder', $this->idorder)->first();
        // $loadTeknisi = User::where('id', $order->teknisi)->first();
        // $loadHelper = User::where('id', $order->helper)->first();
        // $countTeknisi = $loadTeknisi->teknisi_order_count-1;
        // $countHelper = $loadHelper->teknisi_order_count-1;

        // User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        // User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        /**update data order */
        Order::where('idorder', $this->idorder)->update([
            'progres'       => 'Continous',
            'teknisi'       => NULL,
            'helper'        => NULL,
            'keterangan'    => $this->keteranganContinous,
        ]);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $this->idorder,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order di pending karena ('.$this->keteranganContinous.')',  
            'keterangan'        => 'Order Pending',
        ]);

        return redirect('order/'.$this->uuid.'/show')->with('success', 'Order di Continous!');
    }

    public function pending()
    {
        $this->validate([
            'idorder'    => 'required',
        ]);

        /**update count order teknisi */
        $order = Order::where('idorder', $this->idorder)->first();
        // $loadTeknisi = User::where('id', $order->teknisi)->first();
        // $loadHelper = User::where('id', $order->helper)->first();
        // $countTeknisi = ($loadTeknisi->teknisi_order_count ?? 0) - 1;
        // $countHelper = ($loadHelper->teknisi_order_count ?? 0) - 1;


        // User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        // User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        /**update data order */
        Order::where('idorder', $this->idorder)->update([
            'progres'       => 'Pending',
            'teknisi'       => NULL,
            'helper'        => NULL,
            'keterangan'    => $this->keteranganPending,
        ]);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $this->idorder,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order di pending karena ('.$this->keteranganPending.')',  
            'keterangan'        => 'Order Pending',
        ]);

        return redirect('order/'.$this->uuid.'/show')->with('success', 'Order di Pending!');
    }
}
