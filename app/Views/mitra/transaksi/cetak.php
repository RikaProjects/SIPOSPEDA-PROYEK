<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Bukti Transaksi</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    .no-border td { border: none; }
    .text-right { text-align: right; }
    .mt-4 { margin-top: 1.5em; }
  </style>
</head>
<body>

  <h2>Bukti Transaksi</h2>

  <table class="no-border">
    <tr><td><strong>Kode Struk</strong></td><td><?= esc($transaksi['kode_struk'] ?? '-') ?></td></tr>
    <tr><td><strong>Nama Mitra</strong></td><td><?= esc($transaksi['mitra_nama']) ?></td></tr>
    <tr><td><strong>Tanggal Transaksi</strong></td><td><?= date('d-m-Y H:i', strtotime($transaksi['tanggal_transaksi'])) ?></td></tr>
    <tr><td><strong>Status Pembayaran</strong></td><td><?= ucfirst(esc($transaksi['status_pembayaran'])) ?></td></tr>
    <tr><td><strong>Status Pengiriman</strong></td><td><?= ucfirst(esc($transaksi['status_pengiriman'])) ?></td></tr>

    <!-- Tanggal Dikirim -->
    <tr><td><strong>Tanggal Dikirim</strong></td>
      <td>
        <?= !empty($transaksi['tanggal_dikirim']) 
            ? date('d-m-Y H:i', strtotime($transaksi['tanggal_dikirim'])) 
            : '-' ?>
      </td>
    </tr>

    <!-- Nomor Resi -->
    <tr><td><strong>Nomor Resi</strong></td><td><?= !empty($transaksi['nomor_resi']) ? esc($transaksi['nomor_resi']) : '-' ?></td></tr>

    <!-- Nama Pengirim -->
    <tr><td><strong>Nama Pengirim</strong></td><td><?= !empty($transaksi['nama_pengirim']) ? esc($transaksi['nama_pengirim']) : '-' ?></td></tr>

    <tr><td><strong>Alamat Lengkap</strong></td><td>
      <?= esc($transaksi['alamat_jalan']) ?><br>
      Kelurahan: <?= esc($kelurahan['nama'] ?? '-') ?><br>
      Kecamatan: <?= esc($kecamatan['nama'] ?? '-') ?><br>
      Kota: <?= esc($kota['nama'] ?? '-') ?><br>
      Provinsi: <?= esc($provinsi['nama'] ?? '-') ?><br>
      Kode Pos: <?= esc($kodepos ?? '-') ?>
    </td></tr>
  </table>

  <h4 class="mt-4">Detail Produk</h4>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Produk</th>
        <th>Harga Satuan</th>
        <th>Jumlah (kg)</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($detail as $item): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($item['nama_produk']) ?></td>
        <td>Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
        <td><?= esc($item['jumlah_kg']) ?></td>
        <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p class="text-right mt-4">
    <strong>Total Harga: Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></strong>
  </p>

  <br><br>
  <p><em>Dicetak pada <?= date('d-m-Y H:i') ?></em></p>

</body>
</html>
