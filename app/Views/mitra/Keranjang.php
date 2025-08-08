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

        <!-- FORM UPDATE KERANJANG -->
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

          <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('mitra/produk') ?>" class="btn btn-secondary">Lanjut Belanja</a>
            <button type="submit" class="btn btn-success">Update Keranjang</button>
          </div>
        </form>

        <hr class="my-4">

        <!-- FORM CHECKOUT -->
        <form action="<?= base_url('mitra/keranjang/checkout') ?>" method="post">
          <?= csrf_field() ?>
          <h5 class="mb-3">Alamat Pengiriman</h5>
          <div class="row g-2">
            <div class="col-md-4">
              <label>Provinsi</label>
              <select name="provinsi_id" id="provinsi" class="form-control" required>
                <option value="">Pilih Provinsi</option>
                <?php foreach ($provinsi as $p): ?>
                  <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label>Kota/Kabupaten</label>
              <select name="kota_id" id="kota" class="form-control" required></select>
            </div>
            <div class="col-md-4">
              <label>Kecamatan</label>
              <select name="kecamatan_id" id="kecamatan" class="form-control" required></select>
            </div>
            <div class="col-md-4 mt-2">
              <label>Kelurahan</label>
              <select name="kelurahan_id" id="kelurahan" class="form-control" required></select>
            </div>
            <div class="col-md-4 mt-2">
              <label>Kode Pos</label>
              <input type="text" name="kode_pos" id="kode_pos" class="form-control" readonly>
            </div>
            <div class="col-md-12 mt-2">
              <label>Alamat Jalan</label>
              <textarea name="alamat_jalan" rows="2" class="form-control" placeholder="Contoh: Jl. Melati No. 123 RT 01 RW 02" required></textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">Checkout</button>
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
