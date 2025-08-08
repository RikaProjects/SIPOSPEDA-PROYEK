<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<!-- MULAI Konten -->
<div class="content-wrapper">

  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1 class="animate__animated animate__fadeInDown">Dashboard Mitra</h1>
          <p class="animate__animated animate__fadeIn animate__delay-1s">
            Selamat datang, <?= esc(session()->get('nama')) ?>!
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Transaksi -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_transaksi ?></h3>
              <p>Total Transaksi</p>
            </div>
            <div class="icon">
              <i class="fas fa-exchange-alt"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $transaksi_dibayar ?></h3>
              <p>Transaksi Dibayar</p>
            </div>
            <div class="icon">
              <i class="fas fa-money-check-alt"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $transaksi_pending ?></h3>
              <p>Transaksi Pending</p>
            </div>
            <div class="icon">
              <i class="fas fa-clock"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $transaksi_gagal ?></h3>
              <p>Transaksi Gagal</p>
            </div>
            <div class="icon">
              <i class="fas fa-times-circle"></i>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<!-- AKHIR Konten -->

<?= $this->include('layout/footer') ?>
