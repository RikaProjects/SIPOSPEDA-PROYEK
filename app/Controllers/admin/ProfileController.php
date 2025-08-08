<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function index()
    {
        $userId = $this->session->get('id');
        $user = $this->userModel->find($userId);

        return view('admin/profile/index', [
            'title' => 'Profil Saya',
            'user'  => $user
        ]);
    }

    public function update()
    {
        $userId = $this->session->get('id');
        $user = $this->userModel->find($userId);

        $data = [
            'nama_lengkap' => $this->request->getPost('nama'),
            'email'        => $this->request->getPost('email'),
        ];

        // Update foto jika ada file baru
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('assets/img/users', $newName);
            $data['foto'] = $newName;

            // Hapus foto lama (kecuali default)
            if ($user['foto'] && file_exists('assets/img/users/' . $user['foto']) && $user['foto'] !== 'admin.jpeg') {
                unlink('assets/img/users/' . $user['foto']);
            }
        }

        $this->userModel->update($userId, $data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        return view('admin/profile/password', [
            'title' => 'Ganti Password'
        ]);
    }

    public function updatePassword()
    {
        $userId = $this->session->get('id');
        $user = $this->userModel->find($userId);

        $oldPass = $this->request->getPost('password_lama');
        $newPass = $this->request->getPost('password_baru');
        $confirm = $this->request->getPost('konfirmasi_password');

        if (!password_verify($oldPass, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        if ($newPass !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($newPass, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/profil')->with('success', 'Password berhasil diubah.');
    }
}
