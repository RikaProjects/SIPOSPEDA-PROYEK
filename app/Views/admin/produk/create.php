<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Tambah Produk</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Tampilkan error validasi -->
      <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('admin/produk/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="nama_produk" class="form-control" value="<?= esc(old('nama_produk')) ?>" required>
        </div>

        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="4" required><?= esc(old('deskripsi')) ?></textarea>
        </div>

        <div class="form-group">
          <label>Kategori</label>
          <select name="kategori_id" class="form-control" required>
            <option value="" disabled <?= old('kategori_id') ? '' : 'selected' ?>>-- Pilih Kategori --</option>
            <?php foreach ($kategori as $k): ?>
              <option value="<?= esc($k['id']) ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                <?= esc($k['nama_kategori']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Satuan</label>
          <input type="text" name="satuan" class="form-control" value="<?= esc(old('satuan')) ?>" required>
        </div>

        <div class="form-group">
          <label>Harga</label>
          <input type="number" name="harga" class="form-control" step="0.01" value="<?= esc(old('harga')) ?>" required>
        </div>

        <div class="form-group">
          <label>Foto Produk</label>
          <input type="file" name="foto_produk" class="form-control-file" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
