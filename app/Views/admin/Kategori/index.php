<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin', ['activeMenu' => 'kategori']) ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Data Kategori</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <a href="<?= base_url('/admin/kategori/create') ?>" class="btn btn-primary mb-3">+ Tambah Kategori</a>

          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($kategori as $key => $row): ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= esc($row['nama_kategori']) ?></td>
                  <td>
                    <a href="<?= base_url('/admin/kategori/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('/admin/kategori/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
