<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HasilProduksiModel;
use App\Models\ProdukModel;
use App\Models\StokLogModel;
use App\Models\AyamHidupModel;

class HasilProduksi extends BaseController
{
    protected $hasilProduksiModel;
    protected $produkModel;
    protected $stokLogModel;
    protected $ayamHidupModel;

    public function __construct()
    {
        $this->hasilProduksiModel = new HasilProduksiModel();
        $this->produkModel = new ProdukModel();
        $this->stokLogModel = new StokLogModel();
        $this->ayamHidupModel = new AyamHidupModel();
    }

   public function index()
{
    $data['hasil_produksi'] = $this->hasilProduksiModel
        ->select('hasil_produksi.*, ayam_hidup.tanggal_masuk, produk.nama_produk')
        ->join('ayam_hidup', 'ayam_hidup.id = hasil_produksi.ayam_hidup_id')
        ->join('produk', 'produk.id = hasil_produksi.produk_id')
        ->orderBy('tanggal_produksi', 'DESC')
        ->findAll();

    return view('admin/hasil_produksi/index', $data);
}
public function create()
{
    // Contoh ambil data ayam hidup dan produk untuk pilihan di form
    $data['ayam_hidup'] = $this->ayamHidupModel->where('status', 'tersedia')->findAll();
    $data['produk'] = $this->produkModel->where('status', 'aktif')->findAll();

    return view('admin/hasil_produksi/create', $data);
}


    public function store()
    {
        $produkId         = $this->request->getPost('produk_id');
        $tanggalProduksi  = $this->request->getPost('tanggal_produksi');
        $jumlahKg         = (float) $this->request->getPost('jumlah_kg');
        $keterangan       = $this->request->getPost('keterangan') ?? 'Hasil produksi';

        if (!$produkId || !$tanggalProduksi || $jumlahKg <= 0) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid.');
        }

        $ayamHidupId = $this->kurangiAyamHidup($jumlahKg);

        $this->hasilProduksiModel->insert([
            'ayam_hidup_id'      => $ayamHidupId,
            'produk_id'          => $produkId,
            'tanggal_produksi'   => $tanggalProduksi,
            'jumlah_kg'          => $jumlahKg,
        ]);

        $this->stokLogModel->insert([
            'produk_id'   => $produkId,
            'tanggal'     => $tanggalProduksi,
            'tipe'        => 'masuk',
            'jumlah_kg'   => $jumlahKg,
            'keterangan'  => $keterangan,
        ]);

        $produk = $this->produkModel->find($produkId);
        if ($produk) {
            $stokBaru = (float) $produk['stok_kg'] + $jumlahKg;
            $this->produkModel->update($produkId, ['stok_kg' => $stokBaru]);
        }

        return redirect()->to('/admin/hasil-produksi')->with('success', 'Data hasil produksi berhasil disimpan.');
    }

   protected function kurangiAyamHidup(float $jumlahKg): ?int
{
    $sisaKg = $jumlahKg;
    $sisaEkor = ceil($jumlahKg / 2); // Asumsi 1 ekor ≈ 2 kg
    $lastUsedId = null;

    $records = $this->ayamHidupModel
        ->where('status', 'tersedia')
        ->where('tanggal_keluar IS NULL', null, false)
        ->orderBy('tanggal_masuk', 'ASC')
        ->findAll();

    foreach ($records as $row) {
        if ($sisaKg <= 0 || $sisaEkor <= 0) break;

        $berat = (float) $row['berat_total_kg'];
        $ekor = (int) $row['jumlah_ekor'];
        $ayamId = $row['id'];

        if ($berat <= $sisaKg || $ekor <= $sisaEkor) {
            // Semua ayam dari entri ini terpakai
            $this->ayamHidupModel->update($ayamId, [
                'tanggal_keluar' => date('Y-m-d'),
                'status' => 'dipotong'
            ]);
            $sisaKg -= $berat;
            $sisaEkor -= $ekor;
            $lastUsedId = $ayamId;
        } else {
            // Sebagian ayam digunakan
            $newBerat = $berat - $sisaKg;
            $newEkor  = $ekor - $sisaEkor;

            $this->ayamHidupModel->update($ayamId, [
                'berat_total_kg' => $newBerat,
                'jumlah_ekor'    => $newEkor
            ]);

            $insertedId = $this->ayamHidupModel->insert([
                'tanggal_masuk'    => $row['tanggal_masuk'],
                'jumlah_ekor'      => $sisaEkor,
                'berat_total_kg'   => $sisaKg,
                'tanggal_keluar'   => date('Y-m-d'),
                'status'           => 'dipotong',
                'catatan'          => 'Sebagian terpakai saat produksi'
            ], true);

            $sisaKg = 0;
            $sisaEkor = 0;
            $lastUsedId = $insertedId;
        }
    }

    return $lastUsedId;
}
// edit
    public function edit($id)
{
    // Ambil data hasil produksi berdasarkan ID
    $hasilProduksi = $this->hasilProduksiModel
        ->select('hasil_produksi.*, ayam_hidup.tanggal_masuk, produk.nama_produk')
        ->join('ayam_hidup', 'ayam_hidup.id = hasil_produksi.ayam_hidup_id')
        ->join('produk', 'produk.id = hasil_produksi.produk_id')
        ->where('hasil_produksi.id', $id)
        ->first();

    // Cek apakah data ditemukan
    if (!$hasilProduksi) {
        return redirect()->to('/admin/hasil-produksi')->with('error', 'Data tidak ditemukan.');
    }

    // Ambil data produk dan ayam hidup aktif untuk dropdown
    $data['produk'] = $this->produkModel->where('status', 'aktif')->findAll();
    $data['ayam_hidup'] = $this->ayamHidupModel->where('status', 'tersedia')->findAll();
    $data['hasil_produksi'] = $hasilProduksi;

    return view('admin/hasil_produksi/edit', $data);
}
}