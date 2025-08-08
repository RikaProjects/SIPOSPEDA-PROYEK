<?php

namespace App\Models;

use CodeIgniter\Model;

class KelurahanModel extends Model
{
    protected $table = 'kelurahan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'kecamatan_id', 'nama'];

    /**
     * Ambil semua kelurahan berdasarkan kecamatan, dan gabungkan kodepos-nya
     * Cocok untuk dropdown wilayah & pengisian otomatis kode pos
     */
    public function getByKecamatan($kecamatan_id)
    {
        return $this->select('kelurahan.id, kelurahan.nama, kodepos.kodepos')
                    ->join('kodepos', 'kodepos.id_kelurahan = kelurahan.id', 'left')
                    ->where('kelurahan.kecamatan_id', $kecamatan_id)
                    ->orderBy('kelurahan.nama', 'asc')
                    ->findAll();
    }
}
