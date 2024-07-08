
<table class="table table-bordered m-0 mb-3">
    <thead>
        <tr>
            <td> <strong>Masuk :</strong> {{$masuk}} Orang</td>
            <td> <strong>Izin :</strong> {{$izin}} Orang</td>
        </tr>
        <tr>
            <td> <strong>Alfa :</strong> {{$alfa}} Orang</td>
            <td> <strong>Off :</strong> {{$off}} Orang</td>
        </tr>

    </thead>
</table>

<table class="table m-0 mb-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Absensi</th>
            <th>Alasan Lembur</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$r->name}}</td>
            <td>{{$r->jam_masuk}}</td>
            <td>{{$r->jam_pulang}}</td>
            <td>
                @if($r->masuk == 1) <span class="badge badge-success"><strong>Masuk</strong></span>
                @elseif($r->izin == 1) <span class="badge badge-warning"><strong>Izin</strong></span>
                @elseif($r->alfa == 1) <span class="badge badge-danger"><strong>Alfa</strong></span>
                @elseif($r->off == 1) <span class="badge badge-secondary"><strong>Off</strong></span>
                @endif

                @if($r->lembur == 1) 
                    <span class="badge badge-primary"><strong>Lembur</strong></span> 
                @endif
            </td>
            <td>
                {{$r->alasan_lembur}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>