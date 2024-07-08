  <li class="nav-item" id="dashboard">
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
  {{-- End Order Nav --}}
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
        <a href="/order/jadwal" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Jadwal</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/order/report" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Report</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/order/pekerjaan-jasa" class="nav-link">
          <i class="bi bi-chevron-compact-right"></i>
          <p>Pekerjaan Jasa</p>
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
  {{-- End Order Nav --}}

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
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/operational/master" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Master</p>
          </a>
        </li>
      </ul>
    </li>
    {{-- End Inventory Nav --}}

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

    {{-- Operational Nav --}}
    <li class="nav-item" id="finance">
      <a href="#" class="nav-link">
        <i class="bi bi-coin"></i>
        <p>
          Finance 
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/absensi/report" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Laporan Absensi</p>
          </a>
          <a href="/employee/payroll" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Payroll</p>
          </a>
          <a href="/salary/report" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Salary Report</p>
          </a>
          <a href="/finance/inbound/payment" class="nav-link">
              <i class="bi bi-chevron-compact-right"></i>
              <p>Inbound Payment</p>
            </a>
          <a href="/finance/khas" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Kas Perusahaan</p>
          </a>
          <a href="/finance/asset" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Asset Perusahaan</p>
          </a>
          <a href="/finance/asset/payment" class="nav-link">
            <i class="bi bi-chevron-compact-right"></i>
            <p>Pembayaran Angsuran</p>
          </a>
        </li>
      </ul>
    </li>