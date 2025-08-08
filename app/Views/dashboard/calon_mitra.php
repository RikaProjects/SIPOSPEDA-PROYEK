<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_calon_mitra') ?>

<div class="content-wrapper p-4">
  <h2 class="mb-4">Dashboard Calon Mitra</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <p class="mb-3">Halo, <strong><?= esc(session()->get('nama_lengkap')) ?></strong> 👋</p>

      <?php if ($pendaftaran): ?>
        <!-- Status Pendaftaran -->
        <p>Status Pendaftaran:
          <span class="badge 
            <?= $pendaftaran['status_verifikasi'] === 'menunggu' ? 'bg-warning text-dark' : 
                 ($pendaftaran['status_verifikasi'] === 'disetujui' ? 'bg-success' : 'bg-danger') ?>">
            <?= ucfirst($pendaftaran['status_verifikasi']) ?>
          </span>
        </p>

        <?php if ($pendaftaran['status_verifikasi'] === 'diterima'): ?>
          <div class="alert alert-success mt-3">
            ✅ Selamat! Anda telah <strong>terverifikasi</strong> sebagai mitra.
            <br>Silakan mulai melakukan pemesanan produk.
          </div>

        <?php elseif ($pendaftaran['status_verifikasi'] === 'ditolak'): ?>
          <div class="alert alert-danger mt-3">
            ❌ Maaf, pendaftaran Anda <strong>ditolak</strong>.
            <br>Silakan hubungi admin atau <a href="<?= base_url('mitra/formulir') ?>">daftar ulang</a>.
          </div>

        <?php else: ?>
          <div class="alert alert-warning mt-3">
            ⏳ Pendaftaran Anda sedang dalam proses <strong>verifikasi</strong> oleh admin.
            <br>Mohon tunggu informasi selanjutnya.
          </div>
        <?php endif; ?>

      <?php else: ?>
        <!-- Belum Daftar -->
        <div class="alert alert-info mt-3">
          ℹ️ Anda belum mengisi formulir pendaftaran mitra.
          <br>Silakan daftar untuk menjadi mitra resmi.
        </div>
        <a href="<?= base_url('mitra/formulir') ?>" class="btn btn-primary mt-2">
          <i class="fas fa-file-alt me-1"></i> Daftar Jadi Mitra
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->include('layout/footer') ?>
