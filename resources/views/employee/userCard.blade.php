<div class="card-body box-profile">
    <div class="text-center">
      <img class="profile-user-img img-fluid img-circle"
           src="{{asset('storage/foto-user/'.$user->foto)}}"
           alt="User profile picture">
    </div>

    <h3 class="profile-username text-center">{{$user->name}}</h3>

    <p class="text-muted text-center">{{$user->nama_role}}</p>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>ID Karyawan</b> <a class="float-right">{{$user->nik}}</a>
      </li>
      <li class="list-group-item">
        <b>Tanggal Masuk</b> <a class="float-right">{{$employee->tanggal_masuk}}</a>
      </li>
      <li class="list-group-item">
        <b>Pendidikan</b> <a class="float-right">{{$employee->pendidikan}}</a>
      </li>
    </ul>

    <form action="" id="formUpload" enctype="multipart/form-data">
      <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
      <div class="form-group">
          <label for="foto">Ganti Foto</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="foto" id="foto">
              <label class="custom-file-label" for="exampleInputFile">Pilih</label>
            </div>
            <div class="input-group-append">
              <button class="input-group-text btn-success" id="btn-upload" onclick="uploadFoto()">Upload</button>
            </div>
          </div>
        </div>
    </form>
  </div>
  <!-- /.card-body -->