<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KotaModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\KodeposModel;

class Wilayah extends Controller
{
    public function getKota($provinsi_id)
    {
        $kotaModel = new KotaModel();
        $data = $kotaModel->getByProvinsi($provinsi_id);
        return $this->response->setJSON($data);
    }

    public function getKecamatan($kota_id)
    {
        $kecamatanModel = new KecamatanModel();
        $data = $kecamatanModel->getByKota($kota_id);
        return $this->response->setJSON($data);
    }

    public function getKelurahan($kecamatan_id)
    {
        $kelurahanModel = new KelurahanModel();
        $kodeposModel = new KodeposModel();

        $kelurahanList = $kelurahanModel->getByKecamatan($kecamatan_id);

        foreach ($kelurahanList as &$kel) {
            $kodepos = $kodeposModel->where('id_kelurahan', $kel['id'])->first();
            $kel['kode_pos'] = $kodepos['kodepos'] ?? '';
        }

        return $this->response->setJSON($kelurahanList);
    }
}
