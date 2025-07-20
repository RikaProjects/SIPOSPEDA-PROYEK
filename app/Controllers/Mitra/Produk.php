<?php

namespace App\Controllers\Mitra;

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
        $produk = $this->produkModel
    ->select('produk.id, produk.nama_produk, produk.deskripsi, produk.harga, produk.satuan, produk.foto_produk, produk.stok_kg as stok, kategori.nama_kategori')
    ->join('kategori', 'kategori.id = produk.kategori_id')
    ->findAll();


        $kategori = $this->kategoriModel->findAll();

        return view('mitra/produk', [
            'produk' => $produk,
            'kategori' => $kategori
        ]);
    }

    public function detail($id)
    {
        $produk = $this->produkModel
            ->select('produk.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id')
            ->find($id);

        if (!$produk) {
            return redirect()->to(base_url('mitra/produk'))->with('error', 'Produk tidak ditemukan');
        }

        return view('mitra/produk/detail', ['produk' => $produk]);
    }

    public function create()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('mitra/produk/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_produk' => 'required',
            'harga'       => 'required|decimal',
            'kategori_id' => 'required|integer',
            'stok_kg'     => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->produkModel->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'satuan'      => $this->request->getPost('satuan') ?? 'kg',
            'harga'       => $this->request->getPost('harga'),
            'stok_kg'     => $this->request->getPost('stok_kg'),
            'status'      => 'aktif',
        ]);

        return redirect()->to(base_url('mitra/produk'))->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to(base_url('mitra/produk'))->with('error', 'Produk tidak ditemukan');
        }

        $kategori = $this->kategoriModel->findAll();

        return view('mitra/produk/edit', [
            'produk' => $produk,
            'kategori' => $kategori
        ]);
    }

    public function update($id)
    {
        $rules = [
            'nama_produk' => 'required',
            'harga'       => 'required|decimal',
            'kategori_id' => 'required|integer',
            'stok_kg'     => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'satuan'      => $this->request->getPost('satuan') ?? 'kg',
            'harga'       => $this->request->getPost('harga'),
            'stok_kg'     => $this->request->getPost('stok_kg'),
            'status'      => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to(base_url('mitra/produk'))->with('success', 'Produk berhasil diperbarui');
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to(base_url('mitra/produk'))->with('error', 'Produk tidak ditemukan');
        }

        $this->produkModel->delete($id);

        return redirect()->to(base_url('mitra/produk'))->with('success', 'Produk berhasil dihapus');
    }
}
