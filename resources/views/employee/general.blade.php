<ul class="list-group list-group-unbordered mb-3">
    <li class="list-group-item">
      <b>Nomor Handphone</b> <a class="float-right">{{$user->phone}}</a>
    </li>
    <li class="list-group-item">
      <b>Alamat Email</b> <a class="float-right">{{$user->email}}</a>
    </li>
    <li class="list-group-item">
      <b>Pendidikan</b> <a class="float-right">{{$employee->pendidikan}}</a>
    </li>
    <li class="list-group-item">
        <b>Nomor KTP</b> <a class="float-right">{{$employee->ktp}}</a>
    </li>
    <li class="list-group-item">
        <b>Nomor KK</b> <a class="float-right">{{$employee->kk}}</a>
    </li>
    <li class="list-group-item">
        <b>Tempat, Tanggal Lahir</b> <a class="float-right">{{$employee->tempat_lahir.', '.$employee->tanggal_lahir}}</a>
    </li>
    <li class="list-group-item">
        <b>Jenis Kelamin</b> <a class="float-right">{{$employee->gender}}</a>
    </li>
    <li class="list-group-item">
        <b>Alamat</b> <a class="float-right">{{$employee->alamat}}</a>
    </li>
    <li class="list-group-item">
        <b>Nomor Telpon Darurat</b> <a class="float-right">{{$employee->telpon_darurat}}</a>
    </li>
</ul>