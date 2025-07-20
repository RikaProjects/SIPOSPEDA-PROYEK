<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Kelola Produk</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Notifikasi -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-body">
          <a href="<?= base_url('admin/produk/create') ?>" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Produk
          </a>

          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="text-center">
                <tr>
                  <th>Nama Produk</th>
                  <th>Deskripsi</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <th>Stok (kg)</th>
                  <th>Foto</th>
                  <th>Created At</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($produk as $row): ?>
                  <tr>
                    <td><?= esc($row['nama_produk']) ?></td>
                    <td><?= esc($row['deskripsi']) ?></td>
                    <td><?= esc($row['nama_kategori']) ?></td>
                    <td class="text-center"><?= esc($row['satuan']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>

                    <!-- Stok diambil dari data yang sudah dihitung di controller -->
                    <td class="text-center"><?= number_format($row['stok'] ?? 0, 2) ?> kg</td>

                    <td class="text-center">
                      <?php if (!empty($row['foto_produk']) && file_exists(FCPATH . 'uploads/produk/' . $row['foto_produk'])): ?>
                        <img src="<?= base_url('uploads/produk/' . $row['foto_produk']) ?>" alt="Foto Produk" class="img-thumbnail" width="70" height="70">
                      <?php else: ?>
                        <span class="text-muted">Belum ada</span>
                      <?php endif; ?>
                    </td>

                    <td class="text-center"><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>

                    <td class="text-center">
                      <a href="<?= base_url('admin/produk/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                      </a>

                      <form action="<?= base_url('admin/produk/delete/' . $row['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
