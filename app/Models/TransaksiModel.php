<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'mitra_id',
        'kode_struk',
        'tanggal_transaksi',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'status_pengiriman',
        'bukti_pembayaran',
        'tanggal_dibayar',
        'tanggal_dikirim',
        'nomor_resi',
        'nama_pengirim',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'kode_pos',
        'alamat_jalan'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua transaksi milik mitra tertentu.
     */
    public function getByMitra($mitraId)
    {
        return $this->where('mitra_id', $mitraId)
                    ->orderBy('tanggal_transaksi', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil transaksi beserta nama mitra dari tabel users (bukan dari tabel mitra).
     */
    public function getWithMitra($mitraId = null)
    {
        $builder = $this->select('transaksi.*, users.nama as nama_mitra')
                        ->join('users', 'users.user_id = transaksi.mitra_id', 'left');

        if ($mitraId !== null) {
            $builder->where('transaksi.mitra_id', $mitraId);
        }

        return $builder->orderBy('tanggal_transaksi', 'DESC')->findAll();
    }

    /**
     * Ambil transaksi lengkap dengan detail wilayah dari alamat checkout.
     */
    public function getWithWilayah($id)
    {
        return $this->select('transaksi.*, 
                              provinsi.nama as provinsi_nama, 
                              kota_kabupaten.nama as kota_nama, 
                              kecamatan.nama as kecamatan_nama, 
                              kelurahan.nama as kelurahan_nama, 
                              kodepos.kodepos,
                              users.nama_lengkap as mitra_nama')
            ->join('provinsi', 'provinsi.id = transaksi.provinsi_id', 'left')
            ->join('kota_kabupaten', 'kota_kabupaten.id = transaksi.kota_id', 'left')
            ->join('kecamatan', 'kecamatan.id = transaksi.kecamatan_id', 'left')
            ->join('kelurahan', 'kelurahan.id = transaksi.kelurahan_id', 'left')
            ->join('kodepos', 'kodepos.id_kelurahan = kelurahan.id', 'left')
            ->join('users', 'users.id = transaksi.mitra_id', 'left')
            ->where('transaksi.id', $id)
            ->first();
    }
}
