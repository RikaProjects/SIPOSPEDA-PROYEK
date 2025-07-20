<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Profil Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar & Sidebar ... (sama seperti sebelumnya) -->

    <div class="content-wrapper" style="min-height: 100vh; padding: 20px;">
        <h1>Profil Saya</h1>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('profil/update') ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf_field() ?>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Profil</h3>
                </div>
                <div class="card-body">

                    <div class="form-group text-center mb-4">
                        <label>Foto Profil Saat Ini</label><br>
                        <?php if (!empty($user['foto'])) : ?>
                            <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="Foto Profil" class="img-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else : ?>
                            <img src="<?= base_url('AdminLTE/dist/img/user2-160x160.jpg') ?>" alt="Foto Profil Default" class="img-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="foto">Ganti Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" name="foto" class="custom-file-input <?= isset($validation) && $validation->hasError('foto') ? 'is-invalid' : '' ?>" id="foto" accept="image/*">
                            <label class="custom-file-label" for="foto">Pilih file</label>
                            <?php if (isset($validation) && $validation->hasError('foto')) : ?>
                                <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                               class="form-control <?= isset($validation) && $validation->hasError('nama_lengkap') ? 'is-invalid' : '' ?>"
                               value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>"
                               placeholder="Masukkan nama lengkap">
                        <?php if (isset($validation) && $validation->hasError('nama_lengkap')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_lengkap') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>"
                               value="<?= old('email', $user['email'] ?? '') ?>"
                               placeholder="Masukkan email">
                        <?php if (isset($validation) && $validation->hasError('email')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" id="role" name="role" class="form-control" value="<?= esc($user['role'] ?? '') ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" class="form-control" value="<?= esc($user['status'] ?? '') ?>" readonly>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer, Scripts dll seperti sebelumnya... -->
</div>

<script src="<?= base_url('AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE/dist/js/adminlte.min.js') ?>"></script>

<script>
    // Update nama file saat pilih file
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</body>
</html>
