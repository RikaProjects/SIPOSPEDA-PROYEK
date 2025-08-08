<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // ini adalah tabel users
    protected $allowedFields = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mendapatkan semua user berdasarkan role
     */
    public function getByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Cek apakah email sudah terdaftar (digunakan saat register)
     */
    public function emailExists($email)
    {
        return $this->where('email', $email)->first();
    }
}
