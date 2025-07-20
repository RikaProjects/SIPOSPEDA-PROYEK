<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MitraModel;

class Mitra extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $data['calonMitra'] = $userModel->where('role', 'calon_mitra')->findAll();

        $data['mitraAktif'] = $userModel
            ->select('users.*, mitra.tanggal_daftar')
            ->join('mitra', 'mitra.user_id = users.id', 'left')
            ->where('users.role', 'mitra')
            ->findAll();

        return view('admin/mitra/index', $data);
    }

    public function detail($id)
    {
        $userModel = new UserModel();
        $mitraModel = new MitraModel();

        $user = $userModel->find($id);
        $mitra = $mitraModel->getDetailWithWilayah($id); // ✅ method khusus di MitraModel

        if (!$user) {
            return redirect()->to('/admin/mitra')->with('error', 'Data mitra tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Mitra',
            'user' => $user,
            'mitra' => $mitra
        ];

        return view('admin/mitra/detail', $data);
    }

    public function setujui($id)
    {
        $userModel = new UserModel();
        $mitraModel = new MitraModel();

        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/mitra')->with('error', 'Data user tidak ditemukan.');
        }

        // Ubah role jadi 'mitra'
        $userModel->update($id, ['role' => 'mitra']);

        // Update atau insert data mitra
        $mitra = $mitraModel->where('user_id', $id)->first();

        if ($mitra) {
            $mitraModel->update($mitra['mitra_id'], [
                'status_verifikasi' => 'diterima'
            ]);
        } else {
            $mitraModel->insert([
                'user_id' => $id,
                'nama_lengkap' => $user['nama'],
                'status_verifikasi' => 'diterima',
                'tanggal_daftar' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/admin/mitra')->with('success', 'Mitra berhasil disetujui.');
    }

    public function tolak($id)
    {
        $mitraModel = new MitraModel();
        $catatan = $this->request->getPost('catatan_verifikasi');

        $mitra = $mitraModel->where('user_id', $id)->first();

        if ($mitra) {
            $mitraModel->update($mitra['mitra_id'], [
                'status_verifikasi' => 'ditolak',
                'catatan_verifikasi' => $catatan
            ]);

            return redirect()->to('/admin/mitra')->with('success', 'Mitra telah ditolak dengan catatan.');
        } else {
            return redirect()->to('/admin/mitra')->with('error', 'Data mitra belum ditemukan.');
        }
    }

    // ✅ Tambahan: Tampilkan KTP (blob)
    public function dokumenKtp($id)
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->find($id);

        if (!$mitra || !$mitra['dokumen_ktp_blob']) {
            return $this->response->setStatusCode(404)->setBody('Dokumen KTP tidak ditemukan.');
        }

        return $this->response
            ->setHeader('Content-Type', 'image/png') // Ubah jika perlu (misal 'image/jpeg')
            ->setBody($mitra['dokumen_ktp_blob']);
    }

    // ✅ Tambahan: Tampilkan NPWP (blob)
    public function dokumenNpwp($id)
    {
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->find($id);

        if (!$mitra || !$mitra['dokumen_npwp_blob']) {
            return $this->response->setStatusCode(404)->setBody('Dokumen NPWP tidak ditemukan.');
        }

        return $this->response
            ->setHeader('Content-Type', 'image/png') // Ubah jika perlu
            ->setBody($mitra['dokumen_npwp_blob']);
    }
}
