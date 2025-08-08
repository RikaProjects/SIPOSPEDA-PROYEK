<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper p-4">
    <h1 class="mb-4">Laporan Pergerakan Stok Produk</h1>
     <!-- Form Filter Tanggal -->
    <form action="<?= site_url('admin/laporan') ?>" method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="<?= esc($start_date ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Tanggal Akhir</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="<?= esc($end_date ?? '') ?>">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            <a href="<?= site_url('admin/laporan') ?>" class="btn btn-secondary">
                <i class="fas fa-redo me-1"></i> Reset
            </a>
        </div>
    </form>

    <?php if (!empty($log)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Jumlah (Kg)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($log as $row): ?>
                        <tr>
                            <td><?= esc($row['id']) ?></td>
                            <td><?= esc($row['nama_produk']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($row['tanggal'])) ?></td>
                            <td>
                                <span class="badge <?= $row['tipe'] === 'masuk' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ucfirst($row['tipe']) ?>
                                </span>
                            </td>
                            <td><?= esc($row['jumlah_kg']) ?></td>
                            <td><?= esc($row['keterangan']) ?: '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="<?= site_url('admin/laporan/cetak-pergerakan-stok') ?>" target="_blank" class="btn btn-success mt-3">
            <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
        </a>

    <?php else: ?>
        <div class="alert alert-warning">Tidak ada data pergerakan stok.</div>
    <?php endif; ?>
</div>

<?= $this->include('layout/footer') ?>
