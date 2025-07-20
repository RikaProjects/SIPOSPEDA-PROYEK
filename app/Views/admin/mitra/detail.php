<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Mitra</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <a href="<?= base_url('admin/mitra') ?>" class="btn btn-secondary mb-3">Kembali</a>

      <div class="card">
        <div class="card-body">
          <!-- Informasi Umum -->
          <h5>Informasi Umum</h5>
          <table class="table table-bordered">
            <tr><th>Nama Lengkap</th><td><?= esc($mitra['nama_lengkap']) ?></td></tr>
            <tr><th>No HP</th><td><?= esc($mitra['no_hp']) ?></td></tr>
            <tr><th>Nama Brand</th><td><?= esc($mitra['nama_brand']) ?></td></tr>
            <tr><th>Jenis Usaha</th><td><?= esc($mitra['jenis_usaha']) ?></td></tr>
            <tr><th>Kepemilikan Usaha</th><td><?= esc($mitra['kepemilikan_usaha']) ?></td></tr>
            <tr><th>Kebutuhan per Order (kg)</th><td><?= esc($mitra['kebutuhan_per_order_kg']) ?> kg</td></tr>
            <tr><th>Frekuensi Beli per Bulan</th><td><?= esc($mitra['frekuensi_beli_per_bulan']) ?> kali</td></tr>
          </table>

          <!-- Alamat Usaha -->
          <h5 class="mt-4">Alamat Usaha</h5>
          <table class="table table-bordered">
            <tr><th>Provinsi</th><td><?= esc($mitra['nama_provinsi'] ?? '-') ?></td></tr>
            <tr><th>Kota/Kabupaten</th><td><?= esc($mitra['nama_kota'] ?? '-') ?></td></tr>
            <tr><th>Kecamatan</th><td><?= esc($mitra['nama_kecamatan'] ?? '-') ?></td></tr>
            <tr><th>Kelurahan</th><td><?= esc($mitra['nama_kelurahan'] ?? '-') ?></td></tr>
            <tr><th>Kode Pos</th><td><?= esc($mitra['kode_pos'] ?? '-') ?></td></tr>
            <tr><th>Alamat Jalan</th><td><?= esc($mitra['alamat_jalan'] ?? '-') ?></td></tr>
          </table>

             <!-- Dokumen -->
              <h5 class="mt-4">Dokumen</h5>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <h6>KTP</h6>
                  <img src="<?= base_url('uploads/ktp/' . $mitra['dokumen_ktp']) ?>" 
                      class="img-fluid img-thumbnail" width="300" alt="Foto KTP">
                </div>
                <div class="col-md-6 mb-3">
                  <h6>NPWP</h6>
                  <img src="<?= base_url('uploads/npwp/' . $mitra['dokumen_npwp']) ?>" 
                      class="img-fluid img-thumbnail" width="300" alt="Foto NPWP">
                </div>
              </div>


        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
