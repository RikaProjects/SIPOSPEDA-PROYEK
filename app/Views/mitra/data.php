<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Detail Mitra</h1>
  </section>

  <section class="content">
    <div class="card card-body">
      <table class="table">
        <tr><th>Nama Lengkap</th><td><?= esc($mitra['nama_lengkap']) ?></td></tr>
        <tr><th>No HP</th><td><?= esc($mitra['no_hp']) ?></td></tr>
        <tr><th>Nama Brand</th><td><?= esc($mitra['nama_brand']) ?></td></tr>
        <tr><th>Jenis Usaha</th><td><?= esc($mitra['jenis_usaha']) ?></td></tr>
        <tr><th>Kepemilikan Usaha</th><td><?= esc($mitra['kepemilikan_usaha']) ?></td></tr>
        <tr><th>Kebutuhan per Order (kg)</th><td><?= esc($mitra['kebutuhan_per_order_kg']) ?></td></tr>
        <tr><th>Frekuensi Beli per Bulan</th><td><?= esc($mitra['frekuensi_beli_per_bulan']) ?></td></tr>
        <tr><th>Status Verifikasi</th><td><?= esc($mitra['status_verifikasi']) ?></td></tr>
        <tr><th>Catatan Verifikasi</th><td><?= esc($mitra['catatan_verifikasi'] ?? '-') ?></td></tr>
        <tr><th>Dokumen KTP</th><td><img src="<?= base_url('uploads/ktp/' . $mitra['dokumen_ktp']) ?>" width="150"></td></tr>
        <tr><th>Dokumen NPWP</th><td><img src="<?= base_url('uploads/npwp/' . $mitra['dokumen_npwp']) ?>" width="150"></td></tr>
        <tr><th>Tanggal Daftar</th><td><?= esc($mitra['tanggal_daftar']) ?></td></tr>
        <tr><th>Alamat</th><td><?= esc($mitra['alamat_jalan']) ?>, <?= esc($mitra['kode_pos']) ?></td></tr>
      </table>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
