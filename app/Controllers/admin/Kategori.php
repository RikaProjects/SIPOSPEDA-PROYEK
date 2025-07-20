<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        return view('admin/kategori/create');
    }

    public function store()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['kategori'] = $this->kategoriModel->find($id);
        return view('admin/kategori/edit', $data);
    }

    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
