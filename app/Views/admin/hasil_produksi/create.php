<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Tambah Data Hasil Produksi</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>

      <form action="<?= base_url('admin/hasil-produksi/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="ayam_hidup_id" class="form-label">Ayam Hidup (Tanggal Masuk)</label>
          <select name="ayam_hidup_id" id="ayam_hidup_id" class="form-control" required>
            <option value="">-- Pilih Ayam Hidup --</option>
            <?php foreach($ayam_hidup as $ayam): ?>
              <option value="<?= $ayam['id'] ?>" <?= set_select('ayam_hidup_id', $ayam['id']) ?>>
                <?= esc($ayam['tanggal_masuk']) ?> — Jumlah: <?= esc($ayam['jumlah_ekor']) ?> ekor
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="produk_id" class="form-label">Produk (Jenis Potongan)</label>
          <select name="produk_id" id="produk_id" class="form-control" required>
            <option value="">-- Pilih Produk --</option>
            <?php foreach($produk as $prod): ?>
              <option value="<?= $prod['id'] ?>" <?= set_select('produk_id', $prod['id']) ?>>
                <?= esc($prod['nama_produk']) ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
          <input type="date" name="tanggal_produksi" id="tanggal_produksi" class="form-control" value="<?= set_value('tanggal_produksi') ?>" required>
        </div>

        <div class="mb-3">
          <label for="jumlah_kg" class="form-label">Jumlah (Kg)</label>
          <input type="number" step="0.01" name="jumlah_kg" id="jumlah_kg" class="form-control" value="<?= set_value('jumlah_kg') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/hasil-produksi') ?>" class="btn btn-secondary">Kembali</a>
      </form>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
