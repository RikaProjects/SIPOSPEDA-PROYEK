<?php

namespace App\Controllers;
use App\Models\MitraModel;
use App\Models\DashboardModel; 

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login dan memiliki role
        if (!session()->has('role')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        // Arahkan user sesuai peran
        switch ($role) {
            case 'direktur':
                return redirect()->to('/dashboard-direktur');
            case 'manager':
                return redirect()->to('/dashboard-manager');
            case 'adminutama':
                return redirect()->to('/dashboard-admin');
            case 'admin_sales':
                return redirect()->to('/dashboard-admin-sales');
            case 'admin_produksi':
                return redirect()->to('/dashboard-admin-produksi');
            case 'admin_gudang':
                return redirect()->to('/dashboard-admin-gudang');
            case 'operator_produksi':
                return redirect()->to('/dashboard-operator-produksi');
            case 'mitra':
                return redirect()->to('/dashboard-mitra');
            case 'calon_mitra':
                return redirect()->to('/dashboard-calon-mitra');
            default:
                return redirect()->to('/logout'); // role tidak dikenali
        }
    }

    // === Direktur
    public function direktur()
    {
        $model = new DashboardModel();

        $data = [
            'totalPenjualan' => $model->getTotalPenjualanBulanIni(),
            'jumlahMitra' => $model->getJumlahMitraAktif(),
            'totalBeratAyam' => $model->getTotalBeratAyamHidup(),
            'totalEkorAyam' => $model->getTotalEkorAyamHidup(),
        ];

        return view('dashboard/direktur', $data);
    }

    // === Manager
    public function manager()
    {
        return view('dashboard/manager');
    }

    // === Admin Utama
    public function admin()
    {
        $db = \Config\Database::connect();

        // Sisa Ayam Hidup (jumlah ekor yang status tersedia dan belum keluar)
        $ayamHidup = $db->table('ayam_hidup')
            ->selectSum('jumlah_ekor')
            ->where('status', 'tersedia')
            ->where('tanggal_keluar IS NULL', null, false)
            ->get()
            ->getRow()
            ->jumlah_ekor ?? 0;

        // Total produksi hari ini (jumlah kg)
        $produksiHariIniRow = $db->table('hasil_produksi')
            ->selectSum('jumlah_kg')
            ->where('tanggal_produksi', date('Y-m-d'))
            ->get()
            ->getRow();

        $produksiHariIni = $produksiHariIniRow->jumlah_kg ?? 0;

        // Hitung stok produk (total produksi - produk keluar)
        $stokMasuk = $db->table('hasil_produksi')->selectSum('jumlah_kg')->get()->getRow()->jumlah_kg ?? 0;
        $stokKeluar = $db->table('detail_transaksi')->selectSum('jumlah_kg')->get()->getRow()->jumlah_kg ?? 0;
        $totalStokProduk = max(0, $stokMasuk - $stokKeluar);

        // Calon mitra & total mitra
        $calonMitra = $db->table('users')->where('role', 'calon_mitra')->countAllResults();
        $totalMitra = $db->table('users')->where('role', 'mitra')->countAllResults();

        $data = [
            'ayamHidup' => $ayamHidup,
            'produk' => $totalStokProduk,
            'produksiHariIni' => $produksiHariIni,
            'calonMitra' => $calonMitra,
            'totalMitra' => $totalMitra,
        ];

        return view('dashboard/admin', $data);
    }

    // === Admin Sales
    public function adminSales()
    {
        return view('dashboard/admin_sales');
    }

    // === Admin Produksi
    public function adminProduksi()
    {
        return view('dashboard/admin_produksi');
    }

    // === Admin Gudang
    public function adminGudang()
    {
        return view('dashboard/admin_gudang');
    }

    // === Operator Produksi
    public function operatorProduksi()
    {
        return view('dashboard/operator_produksi');
    }

    // mitra

 public function mitra()
{
    $sessionUserId = session()->get('user_id');

    // Ambil mitra_id dari tabel mitra
    $mitraModel = new \App\Models\MitraModel();
    $mitra = $mitraModel->where('user_id', $sessionUserId)->first();

    if (!$mitra) {
        return redirect()->back()->with('error', 'Data mitra tidak ditemukan.');
    }

  $mitraId = $mitra['mitra_id'];

    $model = new \App\Models\TransaksiModel();

    $totalTransaksi = $model->where('mitra_id', $mitraId)->countAllResults();

    $dibayar = $model->where('mitra_id', $mitraId)
                     ->where('status_pembayaran', 'dibayar')
                     ->countAllResults();

    $gagal = $model->where('mitra_id', $mitraId)
                   ->where('status_pembayaran', 'gagal')
                   ->countAllResults();

    $pending = $model->where('mitra_id', $mitraId)
                     ->where('status_pembayaran', 'pending')
                     ->countAllResults();

    $data = [
        'total_transaksi' => $totalTransaksi,
        'transaksi_dibayar' => $dibayar,
        'transaksi_pending' => $pending,
        'transaksi_gagal' => $gagal,
    ];

    return view('dashboard/mitra', $data);
}
     // === Calon Mitra
    public function calonMitra()
    {
        $userId = session()->get('user_id');
        $model = new MitraModel();
        $pendaftaran = $model->where('user_id', $userId)->first();

        return view('dashboard/calon_mitra', [
            'pendaftaran' => $pendaftaran,
        ]);
    }

}