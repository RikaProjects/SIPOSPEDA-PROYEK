<?php

namespace App\Controllers\Mitra;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profil extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function edit()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        return view('mitra/edit_profil', ['user' => $user]);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        // Validasi form
        $validationRules = [
            'nama' => 'required',
            'email' => "required|valid_email",
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email')
        ];

        // Upload foto jika ada
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads/foto', $newName);
            $data['foto'] = $newName;

            // Hapus foto lama (jika bukan default)
            $user = $this->userModel->find($userId);
            if ($user['foto'] && $user['foto'] !== 'default.png') {
                @unlink('uploads/foto/' . $user['foto']);
            }

            session()->set('foto', $newName);
        }

        $this->userModel->update($userId, $data);
        session()->set('nama_lengkap', $data['nama']);
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('/mitra/edit-profil');
    }
}
