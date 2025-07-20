<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<!-- Content Wrapper -->
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
              <input type="text" name="nama_lengkap" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Role</label>
              <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="mitra">Mitra</option>
                <option value="calon_pembeli">Calon Pembeli</option>
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
