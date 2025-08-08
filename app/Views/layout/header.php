<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= isset($title) ? $title : 'Dashboard' ?> - Sukahati</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Optional custom style -->
  <style>
    .brand-logo img {
      height: 15px;
      margin-right: 5px;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 15px;
    }
    .user-image {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light bg-white border-bottom">
  <!-- Left navbar -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-flex align-items-center">
<a href="<?= base_url('/dashboard-admin') ?>" class="navbar-brand d-flex align-items-center">
  <img src="<?= base_url('assets/img/logo/logo-sukahati.png') ?>" alt="Logo" class="brand-logo" style="width: 120px;">
  <span class="d-none d-md-inline"></span>
</a>
    </li>
  </ul>
  <!-- Right navbar -->
<ul class="navbar-nav ml-auto">
 
</nav>
<!-- /.navbar -->
