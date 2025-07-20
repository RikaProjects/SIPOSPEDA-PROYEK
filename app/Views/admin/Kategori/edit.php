<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar_admin', ['activeMenu' => 'kategori']) ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Kategori</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <form action="<?= base_url('/admin/kategori/update/' . $kategori['id']) ?>" method="post">
            <div class="form-group">
              <label for="nama_kategori">Nama Kategori</label>
              <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" value="<?= esc($kategori['nama_kategori']) ?>" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('/admin/kategori') ?>" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->include('layout/footer') ?>
