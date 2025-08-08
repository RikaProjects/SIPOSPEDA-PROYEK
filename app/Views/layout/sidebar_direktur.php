<!-- Sidebar Direktur -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="<?= base_url('/dashboard-direktur') ?>" class="brand-link">
    <span class="brand-text font-weight-light">Sukahati</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block"><?= session()->get('nama_lengkap') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard-direktur') ?>" class="nav-link <?= (uri_string() == 'dashboard-direktur') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Kelola Laporan -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Kelola Laporan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('/direktur/laporan/transaksi') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Transaksi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('/direktur/laporan/pergerakan-stok') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pergerakan Stok Produk</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
          <a href="<?= base_url('logout') ?>" class="nav-link" onclick="return confirm('Yakin ingin logout?')">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
