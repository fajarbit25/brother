<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}" />
  <title>BroTech | {{$title}}</title>

  <link rel="icon" href="{{asset('/storage/logo/logo-title.png')}}" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- Vendor Ajax JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <!-- Bootstrap Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('../../assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  @livewireStyles

</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{asset('/storage/logo/logo-title.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="{{asset('/storage/logo/logo-bti-panjang.png')}}" alt="Brother Tech Logo" class="brand-image elevation-3" style="opacity: .8">
      {{-- <span class="brand-text font-weight-light">BrotherTech</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('storage/foto-user/'.Auth::user()->foto)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{Auth::user()->name}} </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


          <!--Aside-->
          @if(Auth::user()->privilege == 1)
            @include('template.aside-1')
          @endif

          @if(Auth::user()->privilege == 2)
            @include('template.aside-2')
          @endif

          @if(Auth::user()->privilege == 3)
            @include('template.aside-3')
          @endif

          @if(Auth::user()->privilege == 4)
            @include('template.aside-4')
          @endif

          @if(Auth::user()->privilege == 5)
            @include('template.aside-5')
          @endif

          @if(Auth::user()->privilege == 6)
            @include('template.aside-6')
          @endif

          @if(Auth::user()->privilege == 7)
            @include('template.aside-7')
          @endif

          @if(Auth::user()->privilege == 8)
            @include('template.aside-8')
          @endif

          @if(Auth::user()->privilege == 11)
            @include('template.aside-11')
          @endif

          <!-- End Aside-->

            {{-- End Inventory Nav --}}

          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="/tracking-unit" class="nav-link">
              <i class="bi bi-search"></i>
              <p>
                Tracking Unit
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/employee/{{Auth::user()->nik}}/profile" class="nav-link">
              <i class="bi bi-person-circle"></i>
              <p>
                My Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/operational/cashbon" class="nav-link">
              <i class="bi bi-cash"></i>
              <p>
                Bon
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/sop" class="nav-link">
              <i class="bi bi-question-octagon"></i>
              <p>
                SOP
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="logout()">
              <i class="bi bi-box-arrow-right"></i>
              <p>
                Logout <span id="logout-animasi" class="text-danger"><i>   please wait</i>....</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('main')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023-2024 <a href="#">brothertech.co.id</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
{{-- <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- Bootstrap -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('../../assets/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
{{-- <script src="{{asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script> --}}
<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script> --}}
<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('assets/dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('assets/dist/js/pages/dashboard2.js')}}"></script> --}}

<!-- Toastr -->
<script src="{{asset('../../assets/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('/assets/js/logout.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })
  
  //close toast
  // Set default options untuk semua toast
  $(document).on('shown.bs.toast', function() {
      setTimeout(function() {
          $('.toast').toast('hide'); // Menutup toast lama setelah delay
      }, 3000); // Delay 100 milidetik
  });

  document.addEventListener('DOMContentLoaded', function() {
        let currentUrl = window.location.href;
    
        let sidebarLinks = document.querySelectorAll('.nav-link');
    
        sidebarLinks.forEach(function(link) {
            if (link.href === currentUrl) {
                link.classList.add('active');
            }
        });
        
    });
    

    // Mendapatkan URL saat ini
    var currentUrl = window.location.href;
    
    // Memisahkan URL menggunakan tanda "/" dan menyimpannya dalam array
    var urlParts = currentUrl.split("/");
    
    // Mengambil bagian URL yang diinginkan (setelah domain)
    //var path = urlParts.slice(3).join("/");
    var orderValue = urlParts[3];
    console.log(orderValue)

    if(orderValue === 'dashboard'){
      $(".nav-item").removeClass('menu-open')
      $("#dashboard").addClass('menu-open')
    } else if(orderValue === 'costumers'){
      $(".nav-item").removeClass('menu-open')
      $("#costumers").addClass('menu-open')
    } else if(orderValue === 'order'){
      $(".nav-item").removeClass('menu-open')
      $("#order").addClass('menu-open')
    } else if(orderValue === 'inventory'){
      $(".nav-item").removeClass('menu-open')
      $("#inventory").addClass('menu-open')
    } else if(orderValue === 'operational'){
      $(".nav-item").removeClass('menu-open')
      $("#operational").addClass('menu-open')
    } else if(orderValue === 'employee'){
      $(".nav-item").removeClass('menu-open')
      $("#employee").addClass('menu-open')
    } else if(orderValue === 'invoice'){
      $(".nav-item").removeClass('menu-open')
      $("#invoice").addClass('menu-open')
    } else if(orderValue === 'finance'){
      $(".nav-item").removeClass('menu-open')
      $("#finance").addClass('menu-open')
    } else if(orderValue === 'tools'){
      $(".nav-item").removeClass('menu-open')
      $("#tools").addClass('menu-open')
    } else if(orderValue === 'acc'){
      $(".nav-item").removeClass('menu-open')
      $("#accounting").addClass('menu-open')
    }
</script>
@stack('scripts')
@livewireScripts
</body>
</html>
