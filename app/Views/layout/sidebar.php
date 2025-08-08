<?php
$role = session()->get('role');

if ($role === 'adminutama') {
  echo view('layout/sidebar_admin');
} elseif ($role === 'admin_sales') {
  echo view('layout/sidebar_admin_sales');
} elseif ($role === 'admin_gudang') {
  echo view('layout/sidebar_admin_gudang');
} elseif ($role === 'admin_factory') {
  echo view('layout/sidebar_admin_factory');
} else {
  echo "<aside class='main-sidebar sidebar-dark-primary elevation-4'>
    <div class='sidebar'>
      <p class='text-white p-3'>Sidebar tidak tersedia untuk role: <strong>$role</strong></p>
    </div>
  </aside>";
}
?>
