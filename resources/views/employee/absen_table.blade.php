<h5>Absensi</h5>
<table class="table table-hover table-bordered m-0 mb-3">
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
<h5>List Absensi</h5>
<table class="table table-hover table-bordered m-0 mb-3">
<thead>
    <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Absensi</th>
        <th>Alasan Lembur</th>
        <th>Manage</th>
    </tr>
</thead>
<tbody>
    @foreach($karyawan as $kr)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$kr->name}}</td>
        <td>{{$kr->jam_masuk}}</td>
        <td>
            {{$kr->jam_pulang}}
            @if($kr->masuk == 1 && $kr->jam_pulang == '--:--')
            <button class="btn btn-success btn-xs float-right" id="btn-pulang-{{$kr->id}}" onclick="absenPulang({{$kr->id}})">
                <i class="bi bi-arrow-repeat"></i> Pulang
            </button>
            @endif
        </td>
        <td>
            @if($kr->masuk == 1) <span class="badge badge-success"><strong>Masuk</strong></span>
            @elseif($kr->izin == 1) <span class="badge badge-warning"><strong>Izin</strong></span>
            @elseif($kr->alfa == 1) <span class="badge badge-danger"><strong>Alfa</strong></span>
            @elseif($kr->off == 1) <span class="badge badge-secondary"><strong>Off</strong></span>
            @endif

            @if($kr->lembur == 1) 
                <span class="badge badge-primary"><strong>Lembur</strong></span> 
            @endif
        </td>
        <td>
            {{$kr->alasan_lembur}}
        </td>
        <td>
            @if($kr->jam_pulang == '--:--')
                <button class="btn btn-danger btn-xs" id="btn-delete-{{$kr->id}}" onclick="deleteAbsen({{$kr->id}})"><i class="bi bi-trash3"></i></button>
                @if($kr->lembur == 0 && $kr->masuk == 1)
                <button class="btn btn-primary btn-xs" onclick="modalLembur({{$kr->id}})"><i class="bi bi-clock-history"></i> Lembur</button>
                @endif
            @endif
        </td>
    </tr>
    @endforeach
</tbody>