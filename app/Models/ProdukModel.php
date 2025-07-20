<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'kategori_id',
        'nama_produk',
        'deskripsi',
        'satuan',
        'harga',
        'foto_produk',
        'stok_kg',
        'kode_produk',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua produk beserta nama kategori (JOIN)
     * 
     * @return array
     */
    public function getProdukWithKategori()
    {
        return $this->select('produk.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id = produk.kategori_id')
                    ->findAll();
    }

    /**
     * Ambil produk berdasarkan ID (dengan kategori)
     * 
     * @param int $id
     * @return array|null
     */
    public function getProdukById($id)
    {
        return $this->select('produk.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id = produk.kategori_id')
                    ->where('produk.id', $id)
                    ->first();
    }

    /**
     * Hitung stok aktual produk berdasarkan data stok_log
     * Asumsikan ada tabel stok_log dengan kolom:
     * - produk_id
     * - tipe (masuk/keluar)
     * - jumlah_kg
     * 
     * @param int $produk_id
     * @return float
     */
    public function hitungStokAktual($produk_id)
    {
        $builder = $this->db->table('stok_log');

        // Hitung total masuk
        $masuk = (float) $builder->selectSum('jumlah_kg')
                         ->where('produk_id', $produk_id)
                         ->where('tipe', 'masuk')
                         ->get()
                         ->getRow()
                         ->jumlah_kg ?? 0;

        // Hitung total keluar
        $keluar = (float) $builder->selectSum('jumlah_kg')
                          ->where('produk_id', $produk_id)
                          ->where('tipe', 'keluar')
                          ->get()
                          ->getRow()
                          ->jumlah_kg ?? 0;

        return $masuk - $keluar;
    }

    /**
     * Tambah record stok_log untuk produk
     * 
     * @param int $produk_id
     * @param string $tipe ('masuk' atau 'keluar')
     * @param float $jumlah_kg
     * @param string|null $keterangan
     * @return bool
     */
    public function tambahStokLog($produk_id, $tipe, $jumlah_kg, $keterangan = null)
    {
        $stokLog = [
            'produk_id' => $produk_id,
            'tipe'      => $tipe,
            'jumlah_kg' => $jumlah_kg,
            'keterangan'=> $keterangan,
            'tanggal'   => date('Y-m-d H:i:s'),
        ];

        $builder = $this->db->table('stok_log');
        $inserted = $builder->insert($stokLog);

        if ($inserted) {
            // Jika berhasil tambah stok_log, update stok produk
            $this->updateStokProduk($produk_id);
            return true;
        }

        return false;
    }

    /**
     * Update stok produk di tabel produk berdasarkan stok_log
     * 
     * @param int $produk_id
     * @return bool
     */
    public function updateStokProduk($produk_id)
    {
        $stok = $this->hitungStokAktual($produk_id);
        return $this->update($produk_id, ['stok_kg' => $stok]);
    }
}
