<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Tambah Data Ayam Hidup</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form action="<?= base_url('admin/ayam-hidup/store') ?>" method="post">
        <div class="mb-3">
          <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
          <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" required>
        </div>
        
        <div class="mb-3">
          <label for="jumlah_ekor" class="form-label">Jumlah Ekor</label>
          <input type="number" name="jumlah_ekor" id="jumlah_ekor" class="form-control" min="1" required>
        </div>
        
        <div class="mb-3">
          <label for="berat_total_kg" class="form-label">Berat Total (kg)</label>
          <input type="number" step="0.01" name="berat_total_kg" id="berat_total_kg" class="form-control" min="0.01" required>
        </div>
        
        <div class="mb-3">
          <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
          <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control">
        </div>
        
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="tersedia">Tersedia</option>
            <option value="dipotong">Dipotong</option>
            <option value="mati">Mati</option>
            <option value="hilang">Hilang</option>
          </select>
        </div>
        
        <div class="mb-3">
          <label for="catatan" class="form-label">Catatan</label>
          <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/ayam-hidup') ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
