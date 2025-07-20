<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin', ['activeMenu' => 'users']) ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Data Ayam Hidup</h1>
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
          <a href="<?= base_url('admin/ayam-hidup/create') ?>" class="btn btn-success mb-3">+ Tambah Data</a>

          <table class="table table-bordered table-striped">
            <thead>
  <tr>
    <th>Tanggal Masuk</th>
    <th>Jumlah Ekor</th>
    <th>Berat Total (Kg)</th>
    <th>Tanggal Keluar</th>  <!-- tambahan -->
    <th>Status</th>          <!-- tambahan -->
    <th>Catatan</th>
    <th>Aksi</th>
  </tr>
</thead>
<tbody>
  <?php if (count($data_ayam) > 0): ?>
    <?php foreach ($data_ayam as $row): ?>
      <tr>
        <td><?= esc($row['tanggal_masuk']) ?></td>
        <td><?= esc($row['jumlah_ekor']) ?></td>
        <td><?= esc($row['berat_total_kg']) ?></td>
        <td><?= esc($row['tanggal_keluar'] ?? '-') ?></td> <!-- kalau null tampil - -->
        <td><?= esc($row['status'] ?? '-') ?></td>
        <td><?= esc($row['catatan']) ?></td>
        <td>
          <a href="<?= base_url('admin/ayam-hidup/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
        </td>
      </tr>
    <?php endforeach ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="text-center">Belum ada data ayam hidup masuk.</td>
    </tr>
  <?php endif ?>
</tbody>

          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
