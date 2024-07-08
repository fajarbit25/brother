@foreach($order as $item)
<a href="#" class="list-group-item list-group-item-action text-light" aria-current="true">
    <div class="d-flex w-100 justify-content-between">
    <h5 class="mb-1 text-primary">{{$item->uuid}}</h5>

    <small> 
        @if($item->progres == 'Delivered')<span class="badge badge-secondary">{{$item->progres}}</span> 
        @elseif($item->progres == 'Pickup')<span class="badge badge-info">{{$item->progres}}</span> 
        @elseif($item->progres == 'Processing')<span class="badge badge-info">{{$item->progres}}</span> 
        @elseif($item->progres == 'Pending')<span class="badge badge-warning">{{$item->progres}}</span> 
        @elseif($item->progres == 'Cancel')<span class="badge badge-danger">{{$item->progres}}</span>
        @elseif($item->progres == 'Closing')<span class="badge badge-info">{{$item->progres}}</span> 
        @elseif($item->progres == 'Complete')<span class="badge badge-success">{{$item->progres}}</span>
        @endif
    </small>

    </div>
    <p class="mb-1">
    <i class="bi bi-people"></i> {{$item->costumer_name}} .<br/>
    <small>
        <i class="bi bi-geo-alt"></i> {{$item->costumer_address}}. 
        <i class="bi bi-clock-history"></i> {{$item->jadwal}}
    </small>
    </p>
    @if($item->progres == 'Delivered')
    <button class="btn btn-success btn-sm" id="btnPickup-{{$item->idorder}}" onclick="pickupOrder({{$item->idorder}})"><i class="bi bi-plus-lg"></i> PickUp Order</button>
    @endif
    @if($item->progres != 'Delivered')
        @if($item->progres == 'Closing')
        <button class="btn btn-success btn-sm" disabled><i class="bi bi-check-circle"></i> Complete | Menunggu Approval Admin</button>
        @else
        <button class="btn btn-primary btn-sm" id="btnUpdate-{{$item->idorder}}" onclick="updateProgres({{$item->idorder}})"><i class="bi bi-arrow-repeat"></i> Update Progres</button>
        @endif
    @endif

</a>
@endforeach
