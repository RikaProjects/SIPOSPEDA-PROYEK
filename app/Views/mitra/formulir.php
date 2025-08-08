<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_calon_mitra') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Formulir Pendaftaran Mitra</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form action="<?= base_url('mitra/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Informasi Umum -->
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="form-group">
          <label>No HP</label>
          <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Nama Brand</label>
          <input type="text" name="nama_brand" class="form-control">
        </div>

        <!-- Informasi Usaha -->
        <div class="form-group">
          <label>Jenis Usaha</label>
          <select name="jenis_usaha" class="form-control" required>
            <option value="">-- Pilih Jenis Usaha --</option>
            <option>Restoran</option>
            <option>Hotel</option>
            <option>Catering</option>
            <option>Warung Makan</option>
            <option>Distributor</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kepemilikan Usaha</label>
          <select name="kepemilikan_usaha" class="form-control" required>
            <option value="">-- Pilih Kepemilikan Usaha --</option>
            <option>Pribadi</option>
            <option>Keluarga</option>
            <option>Perusahaan</option>
            <option>Franchise</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kebutuhan per Order (kg)</label>
          <input type="number" name="kebutuhan_per_order_kg" class="form-control" step="0.01" min="0">
        </div>

        <div class="form-group">
          <label>Frekuensi Beli per Bulan</label>
          <input type="number" name="frekuensi_beli_per_bulan" class="form-control" min="0">
        </div>

        <!-- Alamat & Wilayah -->
        <div class="form-group">
          <label>Provinsi</label>
          <select name="provinsi_id" id="provinsi" class="form-control" required>
            <option value="">-- Pilih Provinsi --</option>
            <?php foreach ($provinsi as $p): ?>
              <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Kota/Kabupaten</label>
          <select name="kota_id" id="kota" class="form-control" required>
            <option value="">-- Pilih Kota --</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kecamatan</label>
          <select name="kecamatan_id" id="kecamatan" class="form-control" required>
            <option value="">-- Pilih Kecamatan --</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kelurahan/Desa</label>
          <select name="kelurahan_id" id="kelurahan" class="form-control" required>
            <option value="">-- Pilih Kelurahan --</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kode Pos</label>
          <input type="text" id="kode_pos" name="kode_pos" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label>Alamat Lengkap (Jalan)</label>
          <textarea name="alamat_jalan" class="form-control" rows="2" placeholder="Contoh: Jl. Raya Sukabumi No. 10"></textarea>
        </div>

        <!-- Dokumen -->
        <div class="form-group">
          <label>Upload KTP</label>
          <input type="file" name="dokumen_ktp" class="form-control" accept="image/*,application/pdf">
        </div>

        <div class="form-group">
          <label>Upload NPWP</label>
          <input type="file" name="dokumen_npwp" class="form-control" accept="image/*,application/pdf">
        </div>

        <!-- Submit -->
        <div class="text-right">
          <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
        </div>
      </form>
    </div>
  </section>
</div>

<!-- Script Dropdown Berantai -->
<script>
  document.getElementById('provinsi').addEventListener('change', function () {
    const provinsiId = this.value;
    fetch('<?= base_url('get-kota') ?>/' + provinsiId)
      .then(res => res.json())
      .then(data => {
        let options = '<option value="">-- Pilih Kota --</option>';
        data.forEach(kota => {
          options += `<option value="${kota.id}">${kota.nama}</option>`;
        });
        document.getElementById('kota').innerHTML = options;
        document.getElementById('kecamatan').innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        document.getElementById('kelurahan').innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
        document.getElementById('kode_pos').value = '';
      });
  });

  document.getElementById('kota').addEventListener('change', function () {
    const kotaId = this.value;
    fetch('<?= base_url('get-kecamatan') ?>/' + kotaId)
      .then(res => res.json())
      .then(data => {
        let options = '<option value="">-- Pilih Kecamatan --</option>';
        data.forEach(kec => {
          options += `<option value="${kec.id}">${kec.nama}</option>`;
        });
        document.getElementById('kecamatan').innerHTML = options;
        document.getElementById('kelurahan').innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
        document.getElementById('kode_pos').value = '';
      });
  });

  document.getElementById('kecamatan').addEventListener('change', function () {
    const kecamatanId = this.value;
    fetch('<?= base_url('get-kelurahan') ?>/' + kecamatanId)
      .then(res => res.json())
      .then(data => {
        let options = '<option value="">-- Pilih Kelurahan --</option>';
        data.forEach(kel => {
          options += `<option value="${kel.id}" data-kodepos="${kel.kode_pos}">${kel.nama}</option>`;
        });
        document.getElementById('kelurahan').innerHTML = options;
        document.getElementById('kode_pos').value = '';
      });
  });

  document.getElementById('kelurahan').addEventListener('change', function () {
    const kodepos = this.options[this.selectedIndex].getAttribute('data-kodepos');
    document.getElementById('kode_pos').value = kodepos || '';
  });
</script>

<?= $this->include('layout/footer') ?>
