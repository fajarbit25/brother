<li class="nav-item menu-open" id="dashboard">
    <a href="/dashboard" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
        Dashboard
        <i class="right fas fa-angle-left"></i>
    </p>
    </a>
</li>

{{-- Operational Nav --}}
<li class="nav-item" id="invoice">
    <a href="#" class="nav-link">
        <i class="bi bi-receipt"></i>
        <p>
        Invoice
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
        <a href="/invoice" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Invoice Unpaid</p>
        </a>
        <a href="/invoice/report" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Report Invoice</p>
        </a>
        </li>
    </ul>
</li>
{{-- End Inventory Nav --}}

{{-- Order Nav --}}
<li class="nav-item" id="order">
  <a href="#" class="nav-link">
    <i class="bi bi-cart4"></i>
    <p>
      Order
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="/order" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Order</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/order/jadwal-order" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Jadwal</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/order/report" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Laporan Order</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/order/pekerjaan-jasa" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Laporan Umum</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/order/nomor-nota" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Nomor Nota</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/order/master" class="nav-link">
        <i class="bi bi-chevron-compact-right"></i>
        <p>Master</p>
      </a>
    </li>
  </ul>
</li>

{{-- Inventory Nav --}}
  <li class="nav-item" id="inventory">
    <a href="#" class="nav-link">
      <i class="bi bi-calculator"></i>
      <p>
        Inventory
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/inventory/products" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Products</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/reservasi" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Reservasi</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/pos" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Point Of Sale</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/pos-report" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Laporan Penjualan</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/return" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Return</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/outbound/branch" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Kirim Antar Cabang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/inbound" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Inbound</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/outbound" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Outbound</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/supplier" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Data Supplier</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/inventory/master" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Master</p>
        </a>
      </li>
    </ul>
  </li>

  {{-- Inventory Nav --}}
  <li class="nav-item" id="tools">
    <a href="#" class="nav-link">
      <i class="bi bi-tools"></i>
      <p>
        Tools Inventory
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/tools" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Tools</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/tools/master" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Master</p>
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

  {{-- Operational Nav --}}
  <li class="nav-item" id="operational">
    <a href="#" class="nav-link">
      <i class="bi bi-cash-coin"></i>
      <p>
        Operational
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/operational" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Pemasukan</p>
        </a>
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/operational/pengeluaran" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Pengeluaran</p>
        </a>
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/operational/history" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>History</p>
        </a>
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="/opx/cashbon" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Bon Karyawan</p>
        </a>
      </li>
    </ul>
    {{-- End Inventory Nav --}}
  </li>
  {{-- End Inventory Nav --}}
