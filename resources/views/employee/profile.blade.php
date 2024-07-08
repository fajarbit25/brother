@extends('template.layout')
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Employee</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">



        <div class="row">
            <div class="col-md-12">
              @if (session('status'))
                  <div class="alert alert-danger">
                      {{ session('status') }}
                  </div>
              @endif
            </div>
            <div class="col-md-12">
              @error('password')
                <div class="alert alert-danger"> {{$message }} </div>
              @enderror
            </div>

            <div class="col-md-12">
              @error('new_password')
                <div class="alert alert-danger"> {{$message }} </div>
              @enderror
            </div>

            <div class="col-md-12">
              @error('repeat_password')
                <div class="alert alert-danger"> {{$message }} </div>
              @enderror
            </div>

            <div class="col-md-3">
  
              <!-- Profile Image -->
              <div class="card card-primary card-outline" id="user-card">
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">General</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                    </div>
                    <!-- /.tab-pane -->
  
                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" id="formUpdate">
                        <input type="hidden" name="user_nik" id="user_nik" value="{{$user->nik}}"/>
                        <input type="hidden" name="privilegeActived" id="privilegeActived" value="{{$user->privilege}}"/>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="nama">
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Handphone</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="phone" id="phone">
                            </div>
                          </div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="privilege" class="col-sm-2 col-form-label">Level User</label>
                          <div class="col-sm-10">
                            <select name="privilege" id="privilege" class="form-control">
                                @foreach($role as $rol)
                                <option value="{{$rol->idrole}}" @if($rol->idrole < Auth::user()->privilege) disabled @endif>{{$rol->idrole.'. '.$rol->kode_role.' '.$rol->nama_role}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                        <div class="form-group row">
                            <label for="pendidikan" class="col-sm-2 col-form-label">Pendidikan</label>
                            <div class="col-sm-10">
                              <select name="pendidikan" id="pendidikan" class="form-control">
                                <option value="SD">1. SD</option>
                                <option value="SMP">2. SMP</option>
                                <option value="SMA">3. SMA</option>
                                <option value="SMK">4. SMK</option>
                                <option value="D3">5. D3</option>
                                <option value="S1">6. S1</option>
                                <option value="S2">7. S2</option>
                                <option value="S3">8. S3</option>
                                <option value="Non-Formal">9. Non-Formal</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group row">
                          <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nik" id="nik">
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="kk" class="col-sm-2 col-form-label">KK</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="kk" id="kk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                              <select name="gender" id="gender" class="form-control" value="Diploma">
                                <optgroup label="Pilih Jenis Kelamin">
                                    <option value="Laki-laki" selected>Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </optgroup>
                              </select>
                            </div>
                        </div>
                        <div class="form-group row">
                          <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="alamat" id="alamat" placeholder="Alanat"></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nomor_darurat" class="col-sm-2 col-form-label">Nomor Darurat</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nomor_darurat" id="nomor_darurat">
                          </div>
                        </div>
                        <div class="form-group row" id="cabangForm">
                          <label for="branch_id" class="col-sm-2 col-form-label">Cabang</label>
                          <div class="col-sm-10">
                            <select name="branch_id" id="branch_id" class="form-control">
                              <optgroup label="Pilih Kantor Cabang">
                                @foreach($branch as $br)
                                <option value="{{$br->idbranch}}" @if($br->idbranch == Auth::user()->branch_id) selected @endif>{{$br->idbranch.'. '.$br->id_office.' '.$br->branch_name}}</option>
                                @endforeach
                              </optgroup>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="button" class="btn btn-danger" id="btn-update" onclick="updateProfile()" @if($user->privilege < Auth::user()->privilege) disabled @endif>Update</button>
                            <button class="btn btn-danger" id="btn-loading-edit" type="button" disabled>
                              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                              <span role="status">Loading...</span>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="password">
                      <form method="POST" action="{{url('/profile/gantiPassword')}}">
                      @csrf

                      <div class="row g-3 align-items-center mb-3">
                        <div class="col-2">
                          <label for="password" class="col-form-label">Password</label>
                        </div>
                        <div class="col-6">
                          <input type="text" name="password" id="password" class="form-control" aria-describedby="passwordHelpInline" required>
                        </div>
                      </div>

                      <div class="row g-3 align-items-center mb-3">
                        <div class="col-2">
                          <label for="new_password" class="col-form-label">New Password</label>
                        </div>
                        <div class="col-6">
                          <input type="text" name="new_password" id="new_password" class="form-control" aria-describedby="passwordHelpInline" required>
                        </div>
                      </div>

                      <div class="row g-3 align-items-center mb-3">
                        <div class="col-2">
                          <label for="repeat_password" class="col-form-label">Repeat Password</label>
                        </div>
                        <div class="col-6">
                          <input type="text" name="repeat_password" id="repeat_password" class="form-control" aria-describedby="passwordHelpInline" required>
                        </div>
                      </div>

                      <div class="row g-3 align-items-center mb-3">
                        <button type="submit" class="btn btn-primary" id="btn-password">Change Password</button>
                      </div>
                      </form>
                    </div>
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


     
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{-- Js --}}
<script src="{{asset('assets/js/employee.js')}}"></script>
@endsection
