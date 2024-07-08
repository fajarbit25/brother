<li class="nav-item menu-open" id="dashboard">
    <a href="/dashboard" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
        Dashboard
        <i class="right fas fa-angle-left"></i>
    </p>
    </a>
</li>
{{-- Costumer Nav --}}
  <li class="nav-item" id="costumers">
    <a href="#" class="nav-link">
      <i class="bi bi-people"></i>
      <p>
        Costumers
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/costumers" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Data Costumers</p>
        </a>
      </li>
    </ul>
  </li>
{{-- Operational Nav --}}
<li class="nav-item" id="employee">
    <a href="#" class="nav-link">
      <i class="bi bi-person-badge"></i>
      <p>
        Human Resource
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/branch" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Kantor Cabang</p>
        </a>
        <a href="/employee" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Data Karyawan</p>
        </a>
        <a href="{{url('/employee/absensi')}}" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Absensi</p>
        </a>
        <a href="/absensi/report" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Laporan Absensi</p>
        </a>
        <a href="/employee/role" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Role User</p>
        </a>
      </li>
    </ul>
</li>
{{-- End Operational Nav --}}