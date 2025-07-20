<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper p-4">
  <section class="content-header text-center">
    <div class="container-fluid">
      <h1 class="mb-3">Keranjang Belanja</h1>
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php elseif(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if(empty($keranjang)): ?>
        <div class="text-center">
          <p>Keranjang Anda kosong.</p>
          <a href="<?= base_url('mitra/produk') ?>" class="btn btn-primary">Kembali ke Produk</a>
        </div>
      <?php else: ?>
        <form action="<?= base_url('mitra/keranjang/update') ?>" method="post">
          <?= csrf_field() ?>
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead class="table-light">
                <tr class="text-center">
                  <th>Produk</th>
                  <th>Harga</th>
                  <th>Jumlah (kg)</th>
                  <th>Subtotal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($keranjang as $item): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="<?= base_url('uploads/produk/' . $item['foto_produk']) ?>" alt="<?= esc($item['nama_produk']) ?>" class="img-thumbnail me-2" width="80">
                      <?= esc($item['nama_produk']) ?>
                    </div>
                    <input type="hidden" name="id[]" value="<?= esc($item['produk_id']) ?>">
                  </td>
                  <td class="text-center">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                  <td class="text-center">
                    <input type="number" name="qty[]" value="<?= esc($item['jumlah_kg']) ?>" min="1" class="form-control text-center" style="width: 80px; margin: auto;">
                  </td>
                  <td class="text-center">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                  <td class="text-center">
                    <a href="<?= base_url('mitra/keranjang/hapus/' . $item['produk_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini dari keranjang?')">Hapus</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total</th>
                  <th class="text-center">Rp <?= number_format($total_harga, 0, ',', '.') ?></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="d-flex justify-content-between mt-3">
            <div>
              <a href="<?= base_url('mitra/produk') ?>" class="btn btn-secondary">Lanjut Belanja</a>
              <button type="submit" class="btn btn-success">Update Keranjang</button>
            </div>
            <a href="<?= base_url('mitra/keranjang/checkout') ?>" class="btn btn-primary">Checkout</a>
          </div>

          <div class="alert alert-info mt-4">
            <strong>Informasi:</strong>  
            Minimal pemesanan untuk kota <strong>Tasikmalaya</strong> dan <strong>Bandung</strong> adalah <strong>10 kg</strong>.  
            Untuk kota lainnya, minimal <strong>50 kg</strong>.
          </div>
        </form>
      <?php endif; ?>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
