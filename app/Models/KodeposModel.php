<?php

namespace App\Models;

use CodeIgniter\Model;

class KodeposModel extends Model
{
    protected $table = 'kodepos';
    protected $primaryKey = 'id_kelurahan';
    protected $allowedFields = ['id_kelurahan', 'kodepos'];
    public $timestamps = false;

    /**
     * Ambil kodepos berdasarkan ID kelurahan
     */
    public function getByKelurahan($kelurahan_id)
    {
        return $this->where('id_kelurahan', $kelurahan_id)->first();
    }
}
