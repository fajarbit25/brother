<table class="table m-0">
    <thead>
        <tr>
            <th>#</th>
            <th>ID Karyawan</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Cabang</th>
            <th>Handphone</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $row)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td><a href="/employee/{{$row->nik}}/profile">{{$row->nik}}</a></td>
            <td>{{$row->name}}</td>
            <td>{{$row->nama_role}}</td>
            <td>{{$row->branch_name}}</td>
            <td>{{$row->phone}}</td>
            <td>{{$row->email}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div class="col-sm-12">
        {{$employees->links()}}
    </div>