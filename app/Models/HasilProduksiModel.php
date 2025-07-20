<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilProduksiModel extends Model
{
    protected $table = 'hasil_produksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ayam_hidup_id', 'produk_id', 'tanggal_produksi', 'jumlah_kg'];

    public function getAllWithRelations()
    {
        return $this->select('hasil_produksi.*, ayam_hidup.tanggal_masuk, produk.nama_produk')
                    ->join('ayam_hidup', 'hasil_produksi.ayam_hidup_id = ayam_hidup.id')
                    ->join('produk', 'hasil_produksi.produk_id = produk.id')
                    ->orderBy('hasil_produksi.tanggal_produksi', 'DESC')
                    ->findAll();
    }
}
