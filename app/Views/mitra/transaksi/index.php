<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_mitra') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Riwayat Transaksi Saya</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php elseif (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning"><?= esc(session()->getFlashdata('warning')) ?></div>
      <?php endif ?>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Transaksi</h3>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th>No</th>
                <th>Status Pembayaran</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($transaksi) && !empty($transaksi)): ?>
                <?php $no = 1; ?>
                <?php foreach ($transaksi as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <?php if ($row['status_pembayaran'] === 'pending'): ?>
                        <span class="badge bg-warning">Pending</span>
                      <?php elseif ($row['status_pembayaran'] === 'dibayar'): ?>
                        <span class="badge bg-success">Dibayar</span>
                      <?php elseif ($row['status_pembayaran'] === 'belum_dibayar'): ?>
                        <span class="badge bg-secondary">Belum Dibayar</span>
                      <?php else: ?>
                        <span class="badge bg-danger">Gagal</span>
                      <?php endif ?>
                    </td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_transaksi'])) ?></td>
                    <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td>
                      <a href="<?= base_url('mitra/transaksi/' . esc($row['id'])) ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Detail
                      </a>

                      <?php if ($row['status_pembayaran'] === 'dibayar'): ?>
                        <a href="<?= base_url('mitra/transaksi/cetak/' . esc($row['id'])) ?>" class="btn btn-sm btn-success">
                          <i class="fas fa-print"></i> Cetak
                        </a>
                      <?php endif ?>

                      <?php if (in_array($row['status_pembayaran'], ['pending', 'belum_dibayar'])): ?>
                        <a href="<?= base_url('mitra/transaksi/batal/' . esc($row['id'])) ?>" 
                           onclick="return confirm('Batalkan transaksi ini?')" 
                           class="btn btn-sm btn-danger">
                          <i class="fas fa-times-circle"></i> Batalkan
                        </a>
                      <?php endif ?>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center">Belum ada transaksi.</td>
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
