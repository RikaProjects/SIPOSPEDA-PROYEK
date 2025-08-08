<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Kotak Profil -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img src="<?= base_url('assets/img/users/admin.jpeg') ?>" class="img-circle elevation-2" alt="User Image" style="width: 40px; height: 40px; object-fit: cover;">
      </div>
      <div class="info">
        <a href="#" class="d-block text-white"><?= session()->get('nama') ?></a>
        <small class="text-light"><?= session()->get('email') ?></small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Admin Menu -->
        <?php if (session()->get('role') === 'admin_gudang'): ?>
          <li class="nav-item">
            <a href="<?= base_url('/dashboard-admin-gudang') ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('/admin/kategori') ?>" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kelola Kategori</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="<?= base_url('/admin/produk') ?>" class="nav-link">
              <i class="nav-icon fas fa-drumstick-bite"></i>
              <p>Kelola Produk</p>
            </a>
          </li>

        <?php endif; ?>

        <!-- Tombol Logout -->
        <li class="nav-item mt-3">
          <a href="<?= base_url('/logout') ?>" class="nav-link text-danger" onclick="return confirm('Yakin ingin logout?')">
            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->

  </div>
  <!-- /.sidebar -->
</aside>
