@if($count != 0)
  <table class="table m-0">
    <thead>
    <tr>
        <th>#</th>
        <th>Teknisi</th>
        <th>Item</th>
        <th>Satuan</th>
        <th>Qty</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->teknisi}}</td>
        <td>{{$r->name}}</td>
        <td>{{$r->satuan}}</td>
        <td>{{$r->qty}}</td>
        <td>
            @if($r->approve == 1)
            <button class="btn btn-success btn-xs" disabled><i class="bi bi-check-circle"></i> Approved</button>
            @else
            <button class="btn btn-primary btn-xs" id="btn-approve-{{$r->idretur}}" onclick="approveRetur('{{$r->idretur}}', '{{$r->idproduct}}', {{$r->teknisi_id}})"><i class="bi bi-pencil-square"></i> Approve</button>
            <button class="btn btn-danger btn-xs" onclick="deleteRetur({{$r->idretur}})"><i class="bi bi-trash3"></i></button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
  </table>
@else
<table class="table m-0">
    <thead>
    <tr>
        <th>#</th>
        <th>Teknisi</th>
        <th>Item</th>
        <th>Satuan</th>
        <th>Qty</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6" class="text-center">
            <strong>
                <i class="bi bi-exclamation-triangle"></i> <i>Tidak ada data...</i>
            </strong>
        </td>
    </tr>
    </tbody>
  </table>
@endif