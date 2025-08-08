<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_direktur') ?>

<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
          <h1 class="mb-0">Dashboard Direktur</h1>
          <small class="text-muted">Perusahaan RPA Sukahati</small>
        </div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Total Penjualan -->
        <div class="col-lg-3 col-6 mb-4">
          <div class="small-box bg-info text-white">
            <div class="inner text-center">
              <h3>Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></h3>
              <p>Total Penjualan Bulan Ini</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign fa-2x"></i>
            </div>
          </div>
        </div>

        <!-- Jumlah Mitra -->
        <div class="col-lg-3 col-6 mb-4">
          <div class="small-box bg-success text-white">
            <div class="inner text-center">
              <h3><?= $jumlahMitra ?></h3>
              <p>Jumlah Mitra Aktif</p>
            </div>
            <div class="icon">
              <i class="fas fa-users fa-2x"></i>
            </div>
          </div>
        </div>

        <!-- Berat Ayam -->
        <div class="col-lg-3 col-6 mb-4">
          <div class="small-box bg-warning text-white">
            <div class="inner text-center">
              <h3><?= number_format($totalBeratAyam, 2, ',', '.') ?> kg</h3>
              <p>Total Berat Ayam Hidup</p>
            </div>
            <div class="icon">
              <i class="fas fa-drumstick-bite fa-2x"></i>
            </div>
          </div>
        </div>

        <!-- Ekor Ayam -->
        <div class="col-lg-3 col-6 mb-4">
          <div class="small-box bg-danger text-white">
            <div class="inner text-center">
              <h3><?= number_format($totalEkorAyam, 0, ',', '.') ?></h3>
              <p>Total Ekor Ayam Hidup</p>
            </div>
            <div class="icon">
              <i class="fas fa-egg fa-2x"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Laporan Terbaru -->
      <div class="card mt-4">
        <div class="card-header bg-light">
          <h3 class="card-title">Laporan Terbaru</h3>
        </div>
        <div class="card-body">
          <p>Belum ada laporan terbaru.</p>
          <a href="<?= base_url('laporan/terbaru') ?>" class="btn btn-primary mt-2">Lihat Semua Laporan</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
