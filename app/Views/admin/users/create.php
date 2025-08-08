<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Tambah Pengguna</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <form action="<?= base_url('admin/users/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>

            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Role</label>
              <select name="role" class="form-control" required>
                <option value="admin_utama" <?= old('role') === 'admin utama' ? 'selected' : '' ?>>Admin Utama</option>
                <option value="admin_sales" <?= old('role') === 'admin sales' ? 'selected' : '' ?>>Admin Sales</option>
                <option value="admin_gudang" <?= old('role') === 'admin gudang' ? 'selected' : '' ?>>Admin Gudang</option>
                <option value="admin_factory" <?= old('role') === 'admin_factory' ? 'selected' : '' ?>>Admin Factory</option>
                <option value="admin produksi" <?= old('role') === 'admin_produksi' ? 'selected' : '' ?>>Admin Produksi</option>
                <option value="mitra" <?= old('role') === 'mitra' ? 'selected' : '' ?>>Mitra</option>
                <option value="calon mitra" <?= old('role') === 'calon_mitra' ? 'selected' : '' ?>>Calon Pembeli</option>
              </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
