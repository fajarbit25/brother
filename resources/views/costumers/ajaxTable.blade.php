<table class="table m-0">
    <thead>
    <tr>
      <th>No</th>
      <th>Nama Pelanggan</th>
      <th>Status</th>
      <th>Cabang</th>
      <th>PIC</th>
      <th>Kontak</th>
      <th>Jumlah Order</th>
      <th>Alamat</th>
      <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($result as $row)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$row->costumer_name}}</td>
      <td>{{$row->costumer_status}}</td>
      <td>{{$row->branch_name}}</td>
      <td>{{$row->costumer_pic}}</td>
      <td>{{$row->costumer_phone}}</td>
      <td>{{$row->jumlah_order}}</td>
      <td>{{$row->costumer_address}}</td>
      <td>
        <button class="btn btn-success btn-xs" title="Edit" onclick="editCostumer({{$row->idcostumer}})" data-toggle="modal" data-target="#modal-edit"><i class="bi bi-pencil-square"></i></button>
        <button class="btn btn-danger btn-xs" title="Delete"onclick="alertDelete({{$row->idcostumer}})" data-toggle="modal" data-target="#modal-delete"><i class="bi bi-trash3"></i></button>
      </td>
    </tr>
    @endforeach
    </tbody>
</table>
<div class="col-sm-12">
    {{$result->links()}}
</div>