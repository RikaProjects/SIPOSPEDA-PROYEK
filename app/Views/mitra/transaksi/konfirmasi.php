<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper p-4">
  <section class="content-header mb-4">
    <div class="container-fluid">
      <h1>Konfirmasi & Pembayaran</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (!empty($detail_transaksi) && !empty($transaksi)): ?>

      <!-- Ringkasan Belanja -->
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Ringkasan Belanja</h5>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light text-center">
              <tr>
                <th>Produk</th>
                <th>Harga (Rp)</th>
                <th>Jumlah (kg)</th>
                <th>Subtotal (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($detail_transaksi as $item): ?>
              <tr>
                <td><?= esc($item['nama_produk']) ?></td>
                <td class="text-end"><?= number_format($item['harga_satuan'] ?? $item['harga'], 0, ',', '.') ?></td>
                <td class="text-center"><?= esc($item['jumlah_kg']) ?></td>
                <td class="text-end"><?= number_format($item['subtotal'], 0, ',', '.') ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light fw-bold">
              <tr>
                <td colspan="3" class="text-end">Total</td>
                <td class="text-end">
                  <?= number_format(array_sum(array_column($detail_transaksi, 'subtotal')), 0, ',', '.') ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Informasi Rekening Penjual -->
      <div class="card mb-4">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Transfer ke Rekening Penjual</h5>
        </div>
        <div class="card-body">
          <p><strong>Bank:</strong> BNI</p>
          <p><strong>No. Rekening:</strong> 55638457899</p>
          <p><strong>Atas Nama:</strong> RPA Sukahati</p>
          <div class="alert alert-warning mt-3 mb-0">
            Silakan lakukan pembayaran ke rekening di atas dan upload bukti pembayaran di bawah ini.
          </div>
        </div>
      </div>

      <!-- Form Upload Bukti Pembayaran -->
      <form action="<?= base_url('mitra/transaksi/update/' . $transaksi['id']) ?>" method="post" enctype="multipart/form-data" novalidate>
        <?= csrf_field() ?>
        
        <div class="mb-3">
          <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
          <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" required accept="image/*,application/pdf">
          <div class="invalid-feedback">
            Silakan pilih file bukti pembayaran.
          </div>

          <?php if (!empty($transaksi['bukti_pembayaran'])): ?>
            <a href="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" target="_blank" class="btn btn-outline-primary mt-2">Lihat Bukti Sebelumnya</a>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Konfirmasi Transaksi</button>
        <a href="<?= base_url('mitra/transaksi') ?>" class="btn btn-secondary ms-2">Kembali</a>
      </form>

      <?php else: ?>
        <div class="alert alert-danger">Data transaksi tidak ditemukan.</div>
      <?php endif; ?>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>

<script>
// Validasi client-side Bootstrap 5
(() => {
  'use strict'
  const forms = document.querySelectorAll('form')

  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
