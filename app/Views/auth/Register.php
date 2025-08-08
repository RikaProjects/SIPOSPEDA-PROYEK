<!DOCTYPE html>
<html>
<head>
  <title>Register - Sukahati</title>
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
  <style>
    body.login-page {
      background-color: #f8d7da;
    }
    .login-logo b {
      color: #dc3545;
    }
    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    a {
      color: #dc3545;
    }
    a:hover {
      color: #a71d2a;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>SIPOSPEDA</b> 
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Buat akun untuk mulai berbelanja daging ayam segar</p>

      <!-- Flash Message -->
      <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>


      <!-- Form Registrasi -->
      <form action="<?= base_url('register') ?>" method="post">
        <?= csrf_field() ?>
        <div class="input-group mb-3">
          <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a href="<?= base_url('login') ?>">Sudah punya akun?</a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">Daftar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
