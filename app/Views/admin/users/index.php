<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>Manajemen Pengguna</h1>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Notifikasi -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header">
          <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus"></i> Tambah Pengguna
          </a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hover table-striped" id="userTable">
            <thead class="bg-dark text-white">
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $i => $user): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><?= esc($user['nama_lengkap'] ?? '-') ?></td>
                  <td><?= esc($user['email'] ?? '-') ?></td>
                  <td><?= esc($user['role'] ?? '-') ?></td>
                  <td>
                    <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus User ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
