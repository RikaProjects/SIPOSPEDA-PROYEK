<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper p-4">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Produk</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="mb-0"><?= esc($produk['nama_produk']) ?></h3>
          <small class="text-muted"><?= esc($produk['nama_kategori']) ?></small>
        </div>

        <div class="card-body">
          <?php
            $gambar = !empty($produk['foto_produk']) && file_exists(FCPATH . 'uploads/produk/' . $produk['foto_produk'])
              ? base_url('uploads/produk/' . $produk['foto_produk'])
              : base_url('uploads/produk/default.png');
          ?>
          <div class="text-center mb-3">
            <img src="<?= $gambar ?>" alt="<?= esc($produk['nama_produk']) ?>" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
          </div>

          <h5>Deskripsi</h5>
          <p><?= nl2br(esc($produk['deskripsi'])) ?></p>

          <h5>Harga</h5>
          <p class="fw-bold text-success">
            Rp <?= number_format($produk['harga'], 0, ',', '.') ?> / <?= esc($produk['satuan']) ?>
          </p>

          <a href="<?= base_url('mitra/produk') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
