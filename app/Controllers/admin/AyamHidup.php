<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AyamHidupModel;

class AyamHidup extends BaseController
{
    protected $ayamHidupModel;

    public function __construct()
    {
        $this->ayamHidupModel = new AyamHidupModel();
    }

    // Menampilkan semua data ayam hidup
    public function index()
    {
        $data['title'] = 'Data Ayam Hidup';
        $data['data_ayam'] = $this->ayamHidupModel->orderBy('tanggal_masuk', 'DESC')->findAll();

        return view('admin/ayam_hidup/index', $data);
    }

    // Tampilkan form tambah
    public function create()
    {
        return view('admin/ayam_hidup/create');
    }

    // Simpan data baru
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'tanggal_masuk'   => 'required|valid_date',
            'jumlah_ekor'     => 'required|integer|greater_than[0]',
            'berat_total_kg'  => 'required|decimal|greater_than[0]',
            'status'          => 'required|in_list[tersedia,dipotong,mati,hilang]',
            'catatan'         => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->ayamHidupModel->save([
            'tanggal_masuk'   => $this->request->getPost('tanggal_masuk'),
            'jumlah_ekor'     => $this->request->getPost('jumlah_ekor'),
            'berat_total_kg'  => $this->request->getPost('berat_total_kg'),
            'status'          => $this->request->getPost('status'),
            'tanggal_keluar'  => null,
            'catatan'         => $this->request->getPost('catatan'),
        ]);

        session()->setFlashdata('success', 'Data ayam hidup berhasil ditambahkan.');
        return redirect()->to('/admin/ayam-hidup');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $data = $this->ayamHidupModel->find($id);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        return view('admin/ayam_hidup/edit', ['data_ayam' => $data]);
    }

    // Update data
    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'tanggal_masuk'   => 'required|valid_date',
            'jumlah_ekor'     => 'required|integer|greater_than[0]',
            'berat_total_kg'  => 'required|decimal|greater_than[0]',
            'status'          => 'required|in_list[tersedia,dipotong,mati,hilang]',
            'tanggal_keluar'  => 'permit_empty|valid_date',
            'catatan'         => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->ayamHidupModel->update($id, [
            'tanggal_masuk'   => $this->request->getPost('tanggal_masuk'),
            'jumlah_ekor'     => $this->request->getPost('jumlah_ekor'),
            'berat_total_kg'  => $this->request->getPost('berat_total_kg'),
            'status'          => $this->request->getPost('status'),
            'tanggal_keluar'  => $this->request->getPost('tanggal_keluar'),
            'catatan'         => $this->request->getPost('catatan'),
        ]);

        session()->setFlashdata('success', 'Data ayam hidup berhasil diperbarui.');
        return redirect()->to('/admin/ayam-hidup');
    }

    // Hapus data
    public function delete($id)
    {
        $data = $this->ayamHidupModel->find($id);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        $this->ayamHidupModel->delete($id);
        session()->setFlashdata('success', 'Data ayam hidup berhasil dihapus.');
        return redirect()->to('/admin/ayam-hidup');
    }
}
