<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Data Hasil Produksi</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <a href="<?= base_url('admin/hasil-produksi/create') ?>" class="btn btn-success mb-3">+ Tambah Hasil Produksi</a>

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Tanggal Produksi</th>
            <th>Tanggal Masuk Ayam Hidup</th>
            <th>Jenis Potongan</th>
            <th>Jumlah (Kg)</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($hasil_produksi)): ?>
            <?php foreach ($hasil_produksi as $row): ?>
              <tr>
                <td><?= esc($row['tanggal_produksi']) ?></td>
                <td><?= esc($row['tanggal_masuk']) ?></td>
                <td><?= esc($row['nama_produk']) ?></td>
                <td><?= esc($row['jumlah_kg']) ?></td>
                <td>
                  <a href="<?= base_url('admin/hasil-produksi/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center">Belum ada data hasil produksi.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
