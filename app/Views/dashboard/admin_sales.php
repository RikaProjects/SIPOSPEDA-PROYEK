<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin_sales') ?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="animate__animated animate__fadeInDown">Dashboard Admin Sales</h1>
      <p class="animate__animated animate__fadeIn animate__delay-1s">
        Selamat datang, berikut ringkasan statistik hari ini (<?= date('d M Y') ?>).
      </p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Mulai baris -->
      <div class="row">

        <!-- Stok Produk -->
        <div class="col-md-4 mb-3">
          <div class="small-box bg-primary animate__animated animate__fadeInUp animate__delay-3s">
            <div class="inner">
              <h3><?= number_format($produk, 0, ',', '.') ?></h3>
              <p>Stok Produk (Kg)</p>
            </div>
            <div class="icon"><i class="fas fa-drumstick-bite"></i></div>
            <a href="<?= base_url('/admin/produk') ?>" class="small-box-footer">
              Kelola Produk <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Calon Mitra -->
        <div class="col-md-4 mb-3">
          <div class="small-box bg-info animate__animated animate__fadeInUp">
            <div class="inner">
              <h3><?= number_format($calonMitra, 0, ',', '.') ?></h3>
              <p>Calon Mitra</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <a href="<?= base_url('/admin/mitra') ?>" class="small-box-footer">
              Lihat Calon Mitra <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Total Mitra Aktif -->
        <div class="col-md-4 mb-3">
          <div class="small-box bg-secondary animate__animated animate__fadeInUp animate__delay-1s">
            <div class="inner">
              <h3><?= number_format($totalMitra, 0, ',', '.') ?></h3>
              <p>Total Mitra Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="<?= base_url('/admin/mitra') ?>" class="small-box-footer">
              Kelola Mitra <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

      </div> <!-- Akhir baris -->

    </div>
  </section>

</div>

<?= $this->include('layout/footer') ?>
