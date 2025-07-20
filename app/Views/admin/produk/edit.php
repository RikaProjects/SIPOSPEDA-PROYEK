<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Produk</h1>
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

      <form action="<?= base_url('admin/produk/update/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="nama_produk" class="form-control" value="<?= esc(old('nama_produk', $produk['nama_produk'])) ?>" required>
        </div>

        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="4" required><?= esc(old('deskripsi', $produk['deskripsi'])) ?></textarea>
        </div>

        <div class="form-group">
          <label>Kategori</label>
          <select name="kategori_id" class="form-control" required>
            <option value="" disabled <?= old('kategori_id', $produk['kategori_id']) ? '' : 'selected' ?>>-- Pilih Kategori --</option>
            <?php foreach ($kategori as $kat): ?>
              <option value="<?= $kat['id'] ?>" <?= $kat['id'] == old('kategori_id', $produk['kategori_id']) ? 'selected' : '' ?>>
                <?= esc($kat['nama_kategori']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Satuan</label>
          <input type="text" name="satuan" class="form-control" value="<?= esc(old('satuan', $produk['satuan'])) ?>" required>
        </div>

        <div class="form-group">
          <label>Harga</label>
          <input type="number" name="harga" class="form-control" step="0.01" value="<?= esc(old('harga', $produk['harga'])) ?>" required>
        </div>

        <!-- Tampilkan gambar saat ini -->
        <div class="form-group">
          <label>Foto Saat Ini</label><br>
          <?php if (!empty($produk['foto_produk']) && file_exists(FCPATH . 'uploads/produk/' . $produk['foto_produk'])): ?>
            <img src="<?= base_url('uploads/produk/' . $produk['foto_produk']) ?>" alt="Foto Produk" width="150" class="mb-2 img-thumbnail">
          <?php else: ?>
            <p class="text-muted">Belum ada foto</p>
          <?php endif; ?>
        </div>

        <!-- Upload gambar baru -->
        <div class="form-group">
          <label>Ganti Foto Produk (opsional)</label>
          <input type="file" name="foto_produk" class="form-control-file" accept="image/*">
        </div>

        <!-- Simpan nama foto lama agar bisa dipakai jika tidak upload baru -->
        <input type="hidden" name="foto_lama" value="<?= esc($produk['foto_produk']) ?>">

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
