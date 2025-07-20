<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin', ['activeMenu' => 'users']) ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Data Ayam Hidup</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form action="<?= base_url('admin/ayam-hidup/update/' . $data_ayam['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group mb-3">
          <label for="tanggal_masuk">Tanggal Masuk</label>
          <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" value="<?= esc($data_ayam['tanggal_masuk']) ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="jumlah_ekor">Jumlah Ekor</label>
          <input type="number" id="jumlah_ekor" name="jumlah_ekor" class="form-control" value="<?= esc($data_ayam['jumlah_ekor']) ?>" required min="1">
        </div>

        <div class="form-group mb-3">
          <label for="berat_total_kg">Berat Total (Kg)</label>
          <input type="number" step="0.01" id="berat_total_kg" name="berat_total_kg" class="form-control" value="<?= esc($data_ayam['berat_total_kg']) ?>" required min="0.01">
        </div>

        <div class="form-group mb-3">
          <label for="tanggal_keluar">Tanggal Keluar (Opsional)</label>
          <input type="date" id="tanggal_keluar" name="tanggal_keluar" class="form-control" value="<?= esc($data_ayam['tanggal_keluar']) ?>">
        </div>

        <div class="form-group mb-3">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <?php 
              $statuses = ['tersedia', 'dipotong', 'mati', 'hilang'];
              foreach ($statuses as $status) : 
                $selected = ($data_ayam['status'] === $status) ? 'selected' : '';
            ?>
              <option value="<?= $status ?>" <?= $selected ?>><?= ucfirst($status) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="catatan">Catatan</label>
          <textarea id="catatan" name="catatan" class="form-control" rows="3"><?= esc($data_ayam['catatan']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/ayam-hidup') ?>" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
