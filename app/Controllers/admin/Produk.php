<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Produk extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $produkList = $this->produkModel->getProdukWithKategori();

        // Tambahkan stok ke setiap produk secara dinamis
        foreach ($produkList as &$produk) {
            $produk['stok'] = $this->produkModel->hitungStokAktual($produk['id']);
        }

        return view('admin/produk/index', ['produk' => $produkList]);
    }

    public function create()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('admin/produk/create', $data);
    }

    public function store()
    {
        $validationRules = [
            'nama_produk' => 'required',
            'kategori_id' => 'required|numeric',
            'satuan'      => 'required',
            'harga'       => 'required|numeric',
            'foto_produk' => 'uploaded[foto_produk]|is_image[foto_produk]|max_size[foto_produk,2048]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('foto_produk');
        $namaFile = $file->getRandomName();
        $file->move('uploads/produk', $namaFile);

        // Generate kode produk unik (contoh sederhana: KPD + timestamp)
        $kodeProduk = 'KPD' . time();

        $this->produkModel->insert([
            'kode_produk' => $kodeProduk,
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'satuan'      => $this->request->getPost('satuan'),
            'harga'       => $this->request->getPost('harga'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto_produk' => $namaFile,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }

        return view('admin/produk/edit', [
            'produk'   => $produk,
            'kategori' => $this->kategoriModel->findAll()
        ]);
    }

    public function update($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan.');
        }

        $validationRules = [
            'nama_produk' => 'required',
            'kategori_id' => 'required|numeric',
            'satuan'      => 'required',
            'harga'       => 'required|numeric',
            'foto_produk' => 'is_image[foto_produk]|max_size[foto_produk,2048]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoBaru = $this->request->getFile('foto_produk');
        $namaFile = $produk['foto_produk']; // default pakai foto lama

        if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
            $namaFile = $fotoBaru->getRandomName();
            $fotoBaru->move('uploads/produk', $namaFile);

            // Hapus foto lama jika ada
            if (!empty($produk['foto_produk']) && file_exists('uploads/produk/' . $produk['foto_produk'])) {
                unlink('uploads/produk/' . $produk['foto_produk']);
            }
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'satuan'      => $this->request->getPost('satuan'),
            'harga'       => $this->request->getPost('harga'),
            'foto_produk' => $namaFile
        ]);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        if ($produk && !empty($produk['foto_produk']) && file_exists('uploads/produk/' . $produk['foto_produk'])) {
            unlink('uploads/produk/' . $produk['foto_produk']);
        }

        $this->produkModel->delete($id);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus.');
    }

    // Method untuk stoklog masuk
    public function masukStok($produk_id)
    {
        $jumlah_kg = $this->request->getPost('jumlah_kg');

        if (!$jumlah_kg || !is_numeric($jumlah_kg) || $jumlah_kg <= 0) {
            return redirect()->back()->with('error', 'Jumlah stok masuk tidak valid.');
        }

        $this->produkModel->tambahStokLog($produk_id, 'masuk', $jumlah_kg, 'Penambahan stok dari penerimaan barang');

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan.');
    }

    // Method untuk stoklog keluar
    public function keluarStok($produk_id)
    {
        $jumlah_kg = $this->request->getPost('jumlah_kg');

        if (!$jumlah_kg || !is_numeric($jumlah_kg) || $jumlah_kg <= 0) {
            return redirect()->back()->with('error', 'Jumlah stok keluar tidak valid.');
        }

        // validasi stok cukup di sini 

        $this->produkModel->tambahStokLog($produk_id, 'keluar', $jumlah_kg, 'Pengurangan stok karena penjualan');

        return redirect()->back()->with('success', 'Stok berhasil dikurangi.');
    }
}
