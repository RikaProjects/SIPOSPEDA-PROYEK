<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper p-4">
  <!-- Header -->
  <section class="content-header text-center mb-4">
    <div class="container-fluid">
      <h1 class="mb-2">Daftar Produk</h1>
      <p class="text-muted">Silakan pilih kategori produk yang ingin dipesan</p>
    </div>
  </section>

  <!-- Filter Kategori -->
  <div class="container mb-4 text-center">
    <div class="btn-group flex-wrap">
      <button class="btn btn-outline-danger btn-sm filter-btn active" data-filter="all">Semua Produk</button>
      <?php foreach ($kategori as $kat): ?>
        <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="<?= strtolower($kat['nama_kategori']) ?>">
          <?= esc($kat['nama_kategori']) ?>
        </button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Produk -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <?php if (empty($produk)): ?>
          <div class="col-12 text-center">
            <p class="text-muted">Belum ada produk tersedia.</p>
          </div>
        <?php endif; ?>

        <?php foreach ($produk as $item): ?>
          <div class="col-md-4 mb-4 product-card" data-category="<?= strtolower($item['nama_kategori']) ?>">
            <div class="card h-100 shadow-sm">
              <img src="<?= base_url('uploads/produk/' . $item['foto_produk']) ?>"
                   class="card-img-top"
                   alt="<?= esc($item['nama_produk']) ?>"
                   onerror="this.onerror=null;this.src='<?= base_url('assets/img/produk/default.jpg') ?>';"
                   style="height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                <h5 class="card-title"><?= esc($item['nama_produk']) ?></h5>
                <p class="card-text fw-bold text-success">
                  Rp <?= number_format($item['harga'], 0, ',', '.') ?> / <?= esc($item['satuan']) ?>
                </p>
                <p>
                  <?php if ($item['stok'] > 0): ?>
                    <span class="badge bg-success">Stok: <?= esc($item['stok']) ?></span>
                  <?php else: ?>
                    <span class="badge bg-danger">Stok Habis</span>
                  <?php endif; ?>
                </p>
                <span class="badge bg-danger"><?= esc($item['nama_kategori']) ?></span>
              </div>
              <div class="card-footer d-flex justify-content-between">
                <a href="<?= base_url('mitra/produk/detail/' . $item['id']) ?>" class="btn btn-sm btn-info">
                  <i class="fas fa-info-circle"></i> Detail
                </a>
                <a href="<?= base_url('mitra/keranjang/tambah/' . $item['id']) ?>" class="btn btn-sm btn-success">
                  <i class="fas fa-cart-plus"></i> Keranjang
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>

<script>
  const filterButtons = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');
      filterButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      productCards.forEach(card => {
        const category = card.getAttribute('data-category');
        card.style.display = (filter === 'all' || category === filter) ? 'block' : 'none';
      });
    });
  });
</script>
