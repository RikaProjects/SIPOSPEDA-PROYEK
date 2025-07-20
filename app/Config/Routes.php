<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// === AUTH ===
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');


// === DASHBOARD UTAMA ===
$routes->get('dashboard', 'Dashboard::index'); // Auto-redirect sesuai role

// === DASHBOARD DIREKTUR ====
$routes->get('dashboard-direktur', 'Dashboard::direktur');
$routes->get('laporan/terbaru', 'Direktur\Laporan::terbaru');
$routes->get('logout', 'Auth::logout');


// === DASHBOARD MANAGER ====
$routes->get('dashboard-manager', 'Dashboard::manager');

// === DASHBOARD ADMIN ====
$routes->get('dashboard-admin', 'Dashboard::admin');
$routes->group('admin', function($routes) {
    
    // kelola user
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');
    
    // kelola mitra
    $routes->get('mitra', 'admin\mitra::index');
    $routes->get('mitra/detail/(:num)', 'admin\mitra::detail/$1');
    $routes->post('mitra/setujui/(:num)', 'Admin\mitra::setujui/$1');
    $routes->post('mitra/tolak/(:num)', 'Admin\mitra::tolak/$1');
    $routes->post('mitra/setujui/(:num)', 'Admin\Mitra::setujui/$1');
    $routes->get('mitra/dokumen/ktp/(:num)', 'Mitra::dokumenKtp/$1');
    $routes->get('mitra/dokumen/npwp/(:num)', 'Mitra::dokumenNpwp/$1');

    // kelola ayam hidup
    $routes->get('ayam-hidup', 'Admin\AyamHidup::index');
    $routes->get('ayam-hidup/create', 'Admin\AyamHidup::create');
    $routes->post('ayam-hidup/store', 'Admin\AyamHidup::store');
    $routes->get('ayam-hidup/edit/(:segment)', 'Admin\AyamHidup::edit/$1');
    $routes->post('ayam-hidup/update/(:segment)', 'Admin\AyamHidup::update/$1');

    // kelola produk
    $routes->get('produk', 'Admin\Produk::index');
    $routes->get('produk/create', 'Admin\Produk::create');
    $routes->post('produk/store', 'Admin\Produk::store');
    $routes->get('produk/edit/(:num)', 'Admin\Produk::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\Produk::update/$1');
    $routes->post('produk/delete/(:num)', 'Admin\Produk::delete/$1');

    // Route untuk hasil_produksi
    $routes->get('hasil-produksi', 'Admin\HasilProduksi::index');
    $routes->get('hasil-produksi/create', 'Admin\HasilProduksi::create');
    $routes->post('hasil-produksi/store', 'Admin\HasilProduksi::store');
    $routes->get('hasil-produksi/edit/(:num)', 'Admin\HasilProduksi::edit/$1');
    $routes->post('hasil-produksi/update/(:num)', 'Admin\HasilProduksi::update/$1');


    // Kelola kategori
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->get('kategori/create', 'Admin\Kategori::create');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/update/(:num)', 'Admin\Kategori::update/$1');
    $routes->get('kategori/delete/(:num)', 'Admin\Kategori::delete/$1');

    // kelola transaksi
    $routes->get('transaksi', 'Admin\TransaksiController::index');
    $routes->match(['get', 'post'], 'transaksi/detail/(:num)', 'Admin\TransaksiController::detail/$1');
    $routes->match(['get', 'post'], 'transaksi/detail/(:num)', 'Admin\TransaksiController::detail/$1');
    $routes->post('transaksi/updateStatus', 'Admin\TransaksiController::updateStatus');

    // Kelola laporan
    $routes->get('laporan/transaksi', 'Admin\LaporanController::index');
    $routes->get('laporan/cetak', 'Admin\LaporanController::cetak');


    $routes->get('laporan/produksi', 'Admin\LaporanController::produksi');
    $routes->get('laporan/cetak-produksi', 'Admin\LaporanController::cetakProduksi');

    $routes->get('laporan/pergerakan-stok', 'Admin\LaporanController::pergerakanStok');
    $routes->get('laporan/cetak-pergerakan-stok', 'Admin\LaporanController::cetakPergerakanStok');


});

// === DASHBOARD MITRA ====
$routes->get('dashboard-mitra', 'Dashboard::mitra');
$routes->group('mitra', function($routes) {

    $routes->get('produk', 'Mitra\Produk::index');
    $routes->get('produk/detail/(:num)', 'Mitra\Produk::detail/$1');

    // data kemitraan
    $routes->get('data', 'Mitra\Data::data');


    // keranjang
    $routes->get('keranjang', 'Mitra\Keranjang::index');
    $routes->get('keranjang/tambah/(:num)', 'Mitra\Keranjang::tambah/$1');
    $routes->post('keranjang/update', 'Mitra\Keranjang::update');
    $routes->get('keranjang/hapus/(:num)', 'Mitra\Keranjang::hapus/$1');
    $routes->get('keranjang/checkout', 'Mitra\keranjang::checkout');         // Form konfirmasi checkout
    $routes->post('keranjang/checkout', 'Mitra\keranjang::checkoutProses');       // Simpan transaksi

    // Transaksi
    $routes->get('transaksi', 'Mitra\Transaksi::index');
    $routes->get('transaksi/(:num)', 'Mitra\Transaksi::detail/$1');
    $routes->get('transaksi/konfirmasi/(:num)', 'Mitra\Transaksi::konfirmasi/$1');
    $routes->post('transaksi/update/(:num)', 'Mitra\Transaksi::update/$1');
    $routes->post('transaksi/update/(:num)', 'Mitra\Transaksi::update/$1');
    $routes->get('transaksi/batalkan/(:num)', 'Mitra\Transaksi::batalkan/$1');
    $routes->get('transaksi/cetak/(:num)', 'Mitra\Transaksi::cetak/$1');
    $routes->get('transaksi/batal/(:num)', 'Mitra\Transaksi::batal/$1');


});

// === DASHBOARD CALON MITRA ===
$routes->get('dashboard-calon-mitra', 'Dashboard::calonMitra');

// edit profil
$routes->get('mitra/edit-profil', 'Mitra\Profil::edit');
$routes->post('mitra/edit-profil', 'Mitra\Profil::update');

// Formulir pendaftaran mitra
$routes->get('mitra/formulir', 'Mitra\Daftar::index');       // tampilkan formulir
$routes->post('mitra/formulir', 'Mitra\Daftar::index');      // biar reload dropdown (optional)
$routes->post('mitra/simpan', 'Mitra\Daftar::simpan');       // simpan ke database


// wilayah pake ajax
$routes->get('get-kota/(:num)', 'Wilayah::getKota/$1');
$routes->get('get-kecamatan/(:num)', 'Wilayah::getKecamatan/$1');
$routes->get('get-kelurahan/(:num)', 'Wilayah::getKelurahan/$1');
$routes->get('get-kodepos/(:num)', 'Wilayah::getkodepos/$1');
$routes->get('SeederManual', 'SeederManual::index');
$routes->get('seedermanual', 'SeederManual::index');






