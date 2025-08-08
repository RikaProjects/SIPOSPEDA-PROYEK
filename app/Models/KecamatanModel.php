<?php

namespace App\Models;

use CodeIgniter\Model;

class KecamatanModel extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'kota_id', 'nama'];

    /**
     * Ambil semua kecamatan beserta kota dan provinsinya
     * Cocok untuk tampilan admin
     */
    public function getAllWithKotaProvinsi()
    {
        return $this->select('kecamatan.*, kota_kabupaten.nama as kota_nama, provinsi.nama as provinsi_nama')
                    ->join('kota_kabupaten', 'kota_kabupaten.id = kecamatan.kota_id')
                    ->join('provinsi', 'provinsi.id = kota_kabupaten.provinsi_id')
                    ->orderBy('provinsi.nama', 'asc')
                    ->orderBy('kota_kabupaten.nama', 'asc')
                    ->orderBy('kecamatan.nama', 'asc')
                    ->findAll();
    }

    /**
     * Ambil daftar kecamatan berdasarkan ID kota
     * Digunakan untuk dropdown dinamis
     */
    public function getByKota($kota_id)
    {
        return $this->where('kota_id', $kota_id)
                    ->orderBy('nama', 'asc')
                    ->findAll();
    }
}
