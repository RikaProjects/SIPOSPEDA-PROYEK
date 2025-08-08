<?php
namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table = 'wilayah';

    public function getAllProvinsi()
    {
        return $this->select('provinsi')->distinct()->findAll();
    }

    public function getKotaByProvinsi($provinsi)
    {
        return $this->select('kota')
                    ->where('provinsi', $provinsi)
                    ->distinct()
                    ->findAll();
    }

    public function getKecamatanByKota($kota)
    {
        return $this->select('kecamatan')
                    ->where('kota', $kota)
                    ->distinct()
                    ->findAll();
    }
}
