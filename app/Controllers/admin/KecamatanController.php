<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\KotaModel;
use App\Models\ProvinsiModel;

class KecamatanController extends BaseController
{
    protected $kecamatanModel;
    protected $kotaModel;
    protected $provinsiModel;

    public function __construct()
    {
        $this->kecamatanModel = new KecamatanModel();
        $this->kotaModel = new KotaModel();
        $this->provinsiModel = new ProvinsiModel();
    }

    public function index()
    {
        $data = [
            'kecamatan' => $this->kecamatanModel->getAllWithKotaProvinsi(),
        ];
        return view('admin/wilayah/kecamatan', $data);
    }

    public function create()
    {
        $data = [
            'provinsi' => $this->provinsiModel->findAll(),
        ];
        return view('admin/wilayah/kecamatan_tambah', $data);
    }

    public function store()
    {
        $this->kecamatanModel->insert([
            'kota_id' => $this->request->getPost('kota_id'),
            'nama'    => $this->request->getPost('nama')
        ]);

        return redirect()->to(base_url('admin/kecamatan'))->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kecamatan = $this->kecamatanModel->find($id);
        if (!$kecamatan) {
            return redirect()->to(base_url('admin/kecamatan'))->with('error', 'Data tidak ditemukan.');
        }

        $kota = $this->kotaModel->findAll();
        $provinsi = $this->provinsiModel->findAll();

        $data = [
            'kecamatan' => $kecamatan,
            'kota'      => $kota,
            'provinsi'  => $provinsi,
        ];

        return view('admin/wilayah/kecamatan_edit', $data);
    }

    public function update($id)
    {
        $this->kecamatanModel->update($id, [
            'kota_id' => $this->request->getPost('kota_id'),
            'nama'    => $this->request->getPost('nama')
        ]);

        return redirect()->to(base_url('admin/kecamatan'))->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kecamatanModel->delete($id);
        return redirect()->to(base_url('admin/kecamatan'))->with('success', 'Kecamatan berhasil dihapus.');
    }
}
