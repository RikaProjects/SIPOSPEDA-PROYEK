<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Transaksi</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-body">
          <table class="table table-bordered">
            <tbody>
              <tr><th>Kode Struk</th><td><?= esc($transaksi['kode_struk'] ?? '-') ?></td></tr>
              <tr><th>Nama Mitra</th><td><?= esc($transaksi['mitra_nama']) ?></td></tr>
              <tr><th>Tanggal Transaksi</th><td><?= esc($transaksi['tanggal_transaksi']) ?></td></tr>
              <tr><th>Total Harga</th><td>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></td></tr>
              <tr><th>Metode Pembayaran</th><td><?= esc(strtoupper($transaksi['metode_pembayaran'])) ?></td></tr>
              <tr><th>Status Pembayaran</th><td><span class="badge bg-warning text-dark"><?= esc($transaksi['status_pembayaran']) ?></span></td></tr>
              <tr><th>Status Pengiriman</th><td><span class="badge bg-info text-dark"><?= esc($transaksi['status_pengiriman']) ?></span></td></tr>
              
              <!-- Tambahan Nomor Resi -->
              <tr>
                <th>Nomor Resi</th>
                <td><?= !empty($transaksi['nomor_resi']) ? esc($transaksi['nomor_resi']) : '<em>Belum ada nomor resi</em>' ?></td>
              </tr>
              
              <!-- Tambahan Nama Pengirim -->
              <tr>
                <th>Nama Pengirim</th>
                <td><?= !empty($transaksi['nama_pengirim']) ? esc($transaksi['nama_pengirim']) : '<em>Belum ada nama pengirim</em>' ?></td>
              </tr>

              <tr>
                <th>Bukti Pembayaran</th>
                <td>
                  <?php if (!empty($transaksi['bukti_pembayaran'])): ?>
                    <img src="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" width="200">
                  <?php else: ?>
                    <em>Belum diunggah</em>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Tanggal Dibayar</th>
                <td>
                  <?= !empty($transaksi['tanggal_dibayar']) ? date('d-m-Y H:i', strtotime($transaksi['tanggal_dibayar'])) : '<em>Belum dibayar</em>' ?>
                </td>
              </tr>
              <tr>
                <th>Tanggal Dikirim</th>
                <td>
                  <?= !empty($transaksi['tanggal_dikirim']) ? date('d-m-Y H:i', strtotime($transaksi['tanggal_dikirim'])) : '<em>Belum dikirim</em>' ?>
                </td>
              </tr>
              <tr>
                <th>Alamat Lengkap</th>
                <td>
                  <?= esc($transaksi['alamat_jalan']) ?><br>
                  Kelurahan: <?= esc($transaksi['kelurahan_nama'] ?? '-') ?><br>
                  Kecamatan: <?= esc($transaksi['kecamatan_nama'] ?? '-') ?><br>
                  Kota: <?= esc($transaksi['kota_nama'] ?? '-') ?><br>
                  Provinsi: <?= esc($transaksi['provinsi_nama'] ?? '-') ?><br>
                  Kode Pos: <?= esc($transaksi['kode_pos'] ?? '-') ?>
                </td>
              </tr>
            </tbody>
          </table>

          <h5 class="mt-4">Detail Item Transaksi</h5>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah (kg)</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($detail as $item): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($item['nama_produk'] ?? '-') ?></td>
                <td>Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= esc($item['jumlah_kg']) ?> kg</td>
                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <div class="mt-4 d-flex justify-content-between">
            <a href="<?= base_url('mitra/transaksi') ?>" class="btn btn-secondary">Kembali</a>

            <?php if ($transaksi['status_pembayaran'] === 'dibayar'): ?>
              <a href="<?= base_url('mitra/transaksi/cetak/' . $transaksi['id']) ?>" target="_blank" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak
              </a>
            <?php endif; ?>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
