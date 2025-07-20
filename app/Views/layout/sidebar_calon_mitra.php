<!-- Sidebar Calon Mitra -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('/dashboard') ?>" class="brand-link">

  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('uploads/foto/' . (session()->get('foto') ?? 'default.png')) ?>" 
             class="img-circle elevation-2" alt="User Image" style="width: 35px; height: 35px;">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= session()->get('nama_lengkap') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="<?= base_url('/dashboard') ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
</li>

        <li class="nav-item">
          <a href="<?= base_url('/mitra/formulir') ?>" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>Daftar Mitra</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('/logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
