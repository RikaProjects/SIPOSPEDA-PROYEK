<?php

namespace App\Controllers\Mitra;

use App\Controllers\BaseController;
use App\Models\MitraModel;
use App\Models\ProvinsiModel;

class Daftar extends BaseController
{
    public function index()
    {
        $provinsiModel = new ProvinsiModel();
        $data['provinsi'] = $provinsiModel->findAll();

        $no_hp = $this->request->getGet('no_hp'); // Bisa juga dari session

        if ($no_hp) {
            $mitraModel = new MitraModel();
            $existing = $mitraModel->where('no_hp', $no_hp)->first();

            if ($existing && $existing['status_verifikasi'] != 'ditolak') {
                return redirect()->to('/mitra/status')->with('warning', 'Anda sudah mendaftar. Menunggu verifikasi.');
            }
        }

        return view('mitra/formulir', $data);
    }

    public function simpan()
    {
        $request = $this->request;
        $no_hp = $request->getPost('no_hp');

        $mitraModel = new MitraModel();
        $existing = $mitraModel->where('no_hp', $no_hp)->first();

        if ($existing && $existing['status_verifikasi'] != 'ditolak') {
            return redirect()->back()->with('warning', 'Anda sudah mendaftar. Tunggu verifikasi.');
        }

        // Ambil file dari input form
        $ktp = $request->getFile('dokumen_ktp');
        $npwp = $request->getFile('dokumen_npwp');

        $ktpName = '';
        $npwpName = '';

        if ($ktp && $ktp->isValid() && !$ktp->hasMoved()) {
            $ktpName = $ktp->getRandomName();
            $ktp->move('uploads/ktp', $ktpName);
        }

        if ($npwp && $npwp->isValid() && !$npwp->hasMoved()) {
            $npwpName = $npwp->getRandomName();
            $npwp->move('uploads/npwp', $npwpName);
        }

        // Ambil user_id dari session jika ada
        $userId = session()->get('user_id') ?? null;

        // Simpan data ke DB
        $mitraModel->save([
            'user_id'                  => $userId,
            'nama_lengkap'             => $request->getPost('nama_lengkap'),
            'no_hp'                    => $no_hp,
            'nama_brand'               => $request->getPost('nama_brand'),
            'jenis_usaha'              => $request->getPost('jenis_usaha'),
            'kepemilikan_usaha'        => $request->getPost('kepemilikan_usaha'),
            'kebutuhan_per_order_kg'   => $request->getPost('kebutuhan_per_order_kg'),
            'frekuensi_beli_per_bulan' => $request->getPost('frekuensi_beli_per_bulan'),
            'provinsi_id'              => $request->getPost('provinsi_id'),
            'kota_id'                  => $request->getPost('kota_id'),
            'kecamatan_id'             => $request->getPost('kecamatan_id'),
            'kelurahan_id'             => $request->getPost('kelurahan_id'),
            'kode_pos'                 => $request->getPost('kode_pos'),
            'alamat_jalan'             => $request->getPost('alamat_jalan'),
            'dokumen_ktp'              => $ktpName, // Sesuaikan dengan nama kolom di model
            'dokumen_npwp'             => $npwpName,
            'status_verifikasi'        => 'menunggu',
            'tanggal_daftar'           => date('Y-m-d H:i:s') // Set tanggal otomatis
        ]);

        return redirect()->to('/dashboard-calon-mitra')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi admin.');
    }
}
