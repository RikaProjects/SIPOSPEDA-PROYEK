<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProvinsiModel;

class ProvinsiController extends BaseController
{
    protected $provinsiModel;

    public function __construct()
    {
        $this->provinsiModel = new ProvinsiModel();
    }

    public function index()
    {
        $data['provinsi'] = $this->provinsiModel->findAll();
        return view('admin/wilayah/provinsi', $data);
    }

    public function tambah()
    {
        $this->provinsiModel->insert([
            'nama' => $this->request->getPost('nama')
        ]);
        return redirect()->back()->with('success', 'Provinsi ditambahkan.');
    }

    public function hapus($id)
    {
        $this->provinsiModel->delete($id);
        return redirect()->back()->with('success', 'Provinsi dihapus.');
    }
}
