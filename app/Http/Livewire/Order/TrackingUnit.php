<?php

namespace App\Http\Livewire\Order;

use App\Models\TrackingOrder;
use Livewire\Component;

class TrackingUnit extends Component
{
    public $loading = false;
    public $kode;
    public $history;

    public function render()
    {
        return view('livewire.order.tracking-unit');
    }

    public function prosesCekUnit()
    {
        $data = TrackingOrder::join('items', 'items.iditem', '=', 'tracking_orders.item_id')
                ->join('users', 'users.id', '=', 'tracking_orders.teknisi')
                ->where('track_id', $this->kode)->orderBy('tracking_orders.id', 'DESC')
                ->select('track_id', 'order_id', 'item_name', 'name', 'tracking_orders.created_at')
                ->limit(10)->get();
        $this->history = $data;
    }
}
