<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper p-4">
  <section class="content-header">
    <h2>Daftar Transaksi</h2>
  </section>

  <section class="content">
    <div class="card shadow-sm">
      <div class="card-body">
        <table id="tabelTransaksi" class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>ID Mitra</th>
              <th>Tanggal Transaksi</th>
              <th>Status Pembayaran</th>
              <th>Status Pengiriman</th>
              <th>Total Harga</th>
              <th>Metode Pembayaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($transaksi as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['mitra_id']) ?></td>
                <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                <td>
                  <?php
                    $statusBayar = $row['status_pembayaran'];
                    $badgeBayar = 'secondary';
                    if ($statusBayar == 'dibayar') $badgeBayar = 'success';
                    elseif ($statusBayar == 'pending') $badgeBayar = 'warning';
                    elseif ($statusBayar == 'dibatalkan') $badgeBayar = 'danger';
                  ?>
                  <span class="badge bg-<?= $badgeBayar ?>">
                    <?= ucfirst($statusBayar) ?>
                  </span>
                </td>
                <td>
                  <?php
                    $statusKirim = $row['status_pengiriman'];
                    $badgeKirim = 'secondary';
                    if ($statusKirim == 'selesai') $badgeKirim = 'success';
                    elseif ($statusKirim == 'dikirim') $badgeKirim = 'info';
                    elseif ($statusKirim == 'belum dikirim' || $statusKirim == 'pending') $badgeKirim = 'warning';
                  ?>
                  <span class="badge bg-<?= $badgeKirim ?>">
                    <?= ucfirst(str_replace('_', ' ', $statusKirim)) ?>
                  </span>
                </td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= esc($row['metode_pembayaran'] ?? '-') ?></td>
                <td>
                  <a href="<?= base_url('admin/transaksi/detail/' . $row['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>

<!-- Optional: Aktifkan DataTables jika dipakai -->
<script>
  $(document).ready(function() {
    $('#tabelTransaksi').DataTable();
  });
</script>
