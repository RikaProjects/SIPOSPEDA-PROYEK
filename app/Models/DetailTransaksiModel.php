<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table      = 'detail_transaksi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'transaksi_id',
        'produk_id',
        'jumlah_kg',
        'harga_satuan',
        'subtotal',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
