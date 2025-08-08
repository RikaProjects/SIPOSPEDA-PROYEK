<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $model = new UserModel();

        $data = [
            'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'status'    => $this->request->getPost('status'),
        ];

        $model->insert($data);
        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $model = new UserModel();

        $data = [
            'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
            'email'            => $this->request->getPost('email'),
            'role'             => $this->request->getPost('role'),
            'status'           => $this->request->getPost('status'),
        ];

        // Update password hanya jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);
        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
