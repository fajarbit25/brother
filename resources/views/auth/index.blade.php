<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}" />
  <title>BroTech | Log in</title>
  <link rel="icon" href="{{asset('/storage/logo/logo-title.png')}}" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('../../assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('../../assets/dist/css/adminlte.min.css')}}">
  <!-- Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- Vendor Ajax JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      {{-- <a href="/" class="h1"><b>Brother</b>Tech</a> --}}
      <img src="{{asset('/storage/logo/logo-bti-long-white.png')}}" alt="Logo" style="width: 100%;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Silahkan Login!</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="email" id="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" id="btn-login" onclick="login()" class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right"></i> Sign In</button>
            {{-- <button type="button" id="btn-loading" class="btn btn-secondary btn-block" disabled>Loading...</button> --}}
            <button class="btn btn-primary btn-block" type="button" id="btn-loading" disabled>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status">Loading...</span>
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('../../assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('../../assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('../../assets/js/login.js')}}"></script>
</body>
</html>
