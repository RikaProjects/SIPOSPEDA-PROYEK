<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper p-4" style="overflow-x: hidden;">
  <section class="content-header">
    <h1><?= esc($title) ?></h1>
  </section>

  <section class="content">
    <div class="container-fluid" style="max-width: 1000px; margin: auto;">

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif ?>

      <div class="card mb-4">
        <div class="card-header"><strong>Detail Transaksi</strong></div>
        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri: Detail Transaksi -->
            <div class="col-md-6">
              <p><strong>ID Transaksi:</strong> <?= esc($transaksi['id']) ?></p>
              <p><strong>ID Mitra:</strong> <?= esc($transaksi['mitra_id']) ?></p>
              <p><strong>Tanggal Transaksi:</strong> <?= esc($transaksi['tanggal_transaksi']) ?></p>
              <p><strong>Status Pembayaran:</strong> <?= ucfirst(esc($transaksi['status_pembayaran'])) ?></p>
              <p><strong>Status Pengiriman:</strong> <?= ucfirst(esc($transaksi['status_pengiriman'])) ?></p>

              <?php if (!empty($transaksi['tanggal_dibayar'])): ?>
                <p><strong>Tanggal Dibayar:</strong> <?= esc($transaksi['tanggal_dibayar']) ?></p>
              <?php endif ?>

              <?php if (!empty($transaksi['tanggal_dikirim'])): ?>
                <p><strong>Tanggal Dikirim:</strong> <?= esc($transaksi['tanggal_dikirim']) ?></p>
              <?php endif ?>

              <?php if (!empty($transaksi['bukti_pembayaran'])): ?>
  <p><strong>Bukti Pembayaran:</strong></p>
  <a href="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" target="_blank">
    <img src="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" 
         alt="Bukti Pembayaran" 
         class="img-fluid img-thumbnail" 
         style="max-width: 100%; height: auto; max-height: 300px;">
  </a>
  <br>
  <a href="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" download class="btn btn-sm btn-success mt-2">
    Download Bukti Pembayaran
  </a>
<?php else: ?>
  <p><strong>Bukti Pembayaran:</strong> <span class="text-danger">Belum diunggah</span></p>
<?php endif ?>

            </div>

            <!-- Kolom Kanan: Alamat Pengiriman + Form -->
            <div class="col-md-6">
              <h5>Alamat Pengiriman</h5>
              <p><?= esc($transaksi['alamat_jalan'] ?? '-') ?></p>
              <p>Kelurahan: <?= esc($transaksi['kelurahan_nama'] ?? '-') ?></p>
              <p>Kecamatan: <?= esc($transaksi['kecamatan_nama'] ?? '-') ?></p>
              <p>Kota: <?= esc($transaksi['kota_nama'] ?? '-') ?></p>
              <p>Provinsi: <?= esc($transaksi['provinsi_nama'] ?? '-') ?></p>
              <p>Kode Pos: <?= esc($transaksi['kodepos'] ?? '-') ?></p>

              <hr class="my-4">

              <h5>Update Status</h5>
              <form action="<?= base_url('admin/transaksi/updateStatus') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">

                <div class="form-group mb-3">
                  <label for="status_pembayaran">Status Pembayaran</label>
                  <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                    <option value="belum_dibayar" <?= ($transaksi['status_pembayaran'] === 'belum_dibayar') ? 'selected' : '' ?>>Belum Dibayar</option>
                    <option value="dibayar" <?= ($transaksi['status_pembayaran'] === 'dibayar') ? 'selected' : '' ?>>Dibayar</option>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <label for="status_pengiriman">Status Pengiriman</label>
                  <select name="status_pengiriman" id="status_pengiriman" class="form-control">
                    <option value="belum_dikirim" <?= ($transaksi['status_pengiriman'] === 'belum_dikirim') ? 'selected' : '' ?>>Belum Dikirim</option>
                    <option value="dikirim" <?= ($transaksi['status_pengiriman'] === 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                    <option value="selesai" <?= ($transaksi['status_pengiriman'] === 'selesai') ? 'selected' : '' ?>>Selesai</option>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <label for="tanggal_dikirim">Tanggal Dikirim</label>
                  <input type="datetime-local" name="tanggal_dikirim" id="tanggal_dikirim" class="form-control"
                    value="<?= !empty($transaksi['tanggal_dikirim']) ? date('Y-m-d\TH:i', strtotime($transaksi['tanggal_dikirim'])) : '' ?>">
                </div>

                <div class="form-group mb-3">
                  <label for="nomor_resi">Nomor Resi</label>
                  <input type="text" name="nomor_resi" id="nomor_resi" class="form-control" value="<?= esc($transaksi['nomor_resi'] ?? '') ?>">
                </div>

                <div class="form-group mb-3">
                  <label for="nama_pengirim">Nama Pengirim</label>
                  <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" value="<?= esc($transaksi['nama_pengirim'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary">Kembali ke Daftar</a>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
