<table class="table m-0">
    <thead>
    <tr>
        <th>#</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Telephone</th>
        <th>Email</th>
        <th>Keterangan</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($supplier as $sup)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td><a href="/supplier/{{$sup->idsupplier}}/show">{{$sup->supplier_code}}</a></td>
        <td>{{$sup->supplier_name}}</td>
        <td>{{$sup->supplier_phone}}</td>
        <td>{{$sup->supplier_email}}</td>
        <td>{{$sup->supplier_description}}</td>
        <td>
            <button class="btn btn-success btn-xs" onclick="editSupplier({{$sup->idsupplier}})"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-danger btn-xs" onclick="modalDelete({{$sup->idsupplier}})"><i class="bi bi-trash3"></i></button>
        </td>
    </tr>
    @endforeach
    </tbody>
  </table>