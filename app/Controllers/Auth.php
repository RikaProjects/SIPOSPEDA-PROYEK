<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && $user['password'] === $password) {
            session()->set([
                'user_id' => $user['id'], 
                'nama' => $user['nama_lengkap'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email atau Password salah!');
        }
    }
    
    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
{
    $data = [
        'nama_lengkap' => $this->request->getPost('nama_lengkap'),
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password'),
        'role' => 'calon_mitra'
    ];

    $userModel = new UserModel();
    $userModel->insert($data);

    return redirect()->back()->with('success', 'Akun berhasil dibuat! Silakan login jika sudah siap.');
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
