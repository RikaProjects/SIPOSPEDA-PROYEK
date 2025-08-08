<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_direktur') ?>

<div class="content-wrapper p-4">
    <h1 class="mb-4">Laporan Transaksi</h1>

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
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="<?= site_url('admin/laporan') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <?php if (!empty($laporan)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Nama Mitra</th>
                        <th>Nama Produk</th>
                        <th>Jumlah (kg)</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $row): ?>
                    <tr>
                        <td><?= esc($row['id']); ?></td>
                        <td><?= esc($row['tanggal_transaksi']); ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td><?= esc($row['nama_lengkap']); ?></td>
                        <td><?= esc($row['nama_produk']); ?></td>
                        <td><?= esc($row['jumlah_kg']); ?></td>
                        <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                        <td>Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="<?= site_url('admin/laporan/cetak') . '?start_date=' . ($start_date ?? '') . '&end_date=' . ($end_date ?? '') ?>" target="_blank" class="btn btn-success mt-3">
            <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
        </a>

    <?php else: ?>
        <div class="alert alert-warning">Tidak ada data laporan.</div>
    <?php endif; ?>
</div>

<?= $this->include('layout/footer') ?>
