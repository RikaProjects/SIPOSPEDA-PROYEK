<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Manajemen Mitra</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif ?>

      <!-- CALON MITRA -->
      <div class="card mb-4">
        <div class="card-header bg-info text-white">
          <strong>Calon Mitra (Menunggu Verifikasi)</strong>
        </div>
        <div class="card-body">
          <?php if (empty($calonMitra)): ?>
            <p class="mb-0">Tidak ada calon mitra saat ini.</p>
          <?php else: ?>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($calonMitra as $i => $m): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                      <a href="<?= base_url('admin/mitra/detail/' . $m['id']) ?>">
                        <?= esc($m['nama_lengkap']) ?>
                      </a>
                    </td>
                    <td><?= esc($m['email']) ?></td>
                    <td>
                      <!-- Setujui -->
                      <form action="<?= base_url('admin/mitra/setujui/' . $m['id']) ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui mitra ini?')">
                          Setujui
                        </button>
                      </form>

                      <!-- Tombol Tolak -->
                      <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTolak<?= $m['id'] ?>">
                        Tolak
                      </button>
                    </td>
                  </tr>

                  <!-- Modal Tolak -->
                  <div class="modal fade" id="modalTolak<?= $m['id'] ?>" tabindex="-1" aria-labelledby="labelTolak<?= $m['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <form action="<?= base_url('admin/mitra/tolak/' . $m['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-content">
                          <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="labelTolak<?= $m['id'] ?>">Tolak Calon Mitra</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                              <span>&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Alasan Penolakan</label>
                              <textarea name="catatan_verifikasi" class="form-control" rows="3" required></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Tolak</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- /Modal -->
                <?php endforeach ?>
              </tbody>
            </table>
          <?php endif ?>
        </div>
      </div>

      <!-- MITRA AKTIF -->
<div class="card">
  <div class="card-header bg-success text-white">
    <strong>Mitra Aktif (Diterima)</strong>
  </div>
  <div class="card-body">
    <?php if (empty($mitraAktif)): ?>
      <p class="mb-0">Belum ada mitra aktif.</p>
    <?php else: ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Tgl Daftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mitraAktif as $i => $m): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= esc($m['nama_lengkap']) ?></td>
              <td><?= esc($m['email']) ?></td>
              <td><?= date('d M Y', strtotime($m['tanggal_daftar'])) ?></td>
              <td>
                <!-- Tombol Detail -->
                <a href="<?= base_url('admin/mitra/detail/' . $m['id']) ?>" class="btn btn-info btn-sm">
                  Detail
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>
  </div>
</div>


    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
