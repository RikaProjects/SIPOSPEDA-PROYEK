<?php
namespace App\Models;

use CodeIgniter\Model;

class StokLogModel extends Model
{
    protected $table = 'stok_log';
    protected $primaryKey = 'id';
    protected $allowedFields = ['produk_id', 'tanggal', 'tipe', 'jumlah_kg', 'keterangan'];

    // Jika kamu ingin otomatis set tanggal saat insert, bisa buat manual di controller atau override fungsi insert.
    protected $useTimestamps = false;  // Tanggal otomatis tidak aktif, karena kolom sudah default current_timestamp

    // Jika ingin insert dengan tanggal otomatis tanpa harus kirim manual, bisa tambahkan method insert stok log:
    public function tambahLog($produkId, $tipe, $jumlahKg, $keterangan = '')
    {
        return $this->insert([
            'produk_id' => $produkId,
            'tipe' => $tipe,
            'jumlah_kg' => $jumlahKg,
            'keterangan' => $keterangan
            // tanggal otomatis oleh database
        ]);
    }
}
