<!-- app/Views/layout/sidebar_mitra.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Info -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="info">
        <a href="#" class="d-block"><?= session()->get('nama') ?></a>
      </div>
    </div>

    <!-- Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard-mitra') ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Produk -->
        <li class="nav-item">
          <a href="<?= base_url('mitra/produk') ?>" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Pilih Produk</p>
          </a>
        </li>

        <!-- Transaksi -->
        <li class="nav-item">
          <a href="<?= base_url('mitra/transaksi') ?>" class="nav-link">
            <i class="nav-icon fas fa-receipt"></i>
            <p>Transaksi</p>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="<?= base_url('logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
          </a>
        </li>
      </ul>
    </nav>
  </div> <!-- /.sidebar -->
</aside> <!-- /.main-sidebar -->
