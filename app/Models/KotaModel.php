<?php

namespace App\Models;

use CodeIgniter\Model;

class KotaModel extends Model
{
    protected $table = 'kota_kabupaten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'provinsi_id', 'nama'];

    /**
     * Ambil semua kota/kab dengan nama provinsinya (untuk list, admin, dll)
     */
    public function getAllWithProvinsi()
    {
        return $this->select('kota_kabupaten.*, provinsi.nama as provinsi_nama')
                    ->join('provinsi', 'provinsi.id = kota_kabupaten.provinsi_id')
                    ->orderBy('provinsi.nama', 'asc')
                    ->findAll();
    }

    /**
     * Ambil daftar kota/kab berdasarkan ID provinsi
     * Digunakan untuk dropdown dinamis
     */
    public function getByProvinsi($provinsi_id)
    {
        return $this->where('provinsi_id', $provinsi_id)
                    ->orderBy('nama', 'asc')
                    ->findAll();
    }
}
