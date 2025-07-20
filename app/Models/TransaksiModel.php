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
     * Ambil transaksi beserta nama mitra.
     * Jika $mitraId null, ambil semua transaksi.
     */
    public function getWithMitra($mitraId = null)
    {
        $builder = $this->select('transaksi.*, mitra.nama_lengkap')
                        ->join('mitra', 'mitra.mitra_id = transaksi.mitra_id', 'left');

        if ($mitraId !== null) {
            $builder->where('transaksi.mitra_id', $mitraId);
        }

        return $builder->orderBy('tanggal_transaksi', 'DESC')->findAll();
    }

    /**
     * Ambil transaksi lengkap dengan detail wilayah yang tersimpan di transaksi.
     */
    public function getWithWilayah($id)
    {
        return $this->select('transaksi.*, 
                              provinsi.nama as provinsi_nama, 
                              kota_kabupaten.nama as kota_nama, 
                              kecamatan.nama as kecamatan_nama, 
                              kelurahan.nama as kelurahan_nama, 
                              kodepos.kodepos')
            ->join('provinsi', 'provinsi.id = transaksi.provinsi_id', 'left')
            ->join('kota_kabupaten', 'kota_kabupaten.id = transaksi.kota_id', 'left')
            ->join('kecamatan', 'kecamatan.id = transaksi.kecamatan_id', 'left')
            ->join('kelurahan', 'kelurahan.id = transaksi.kelurahan_id', 'left')
            ->join('kodepos', 'kodepos.id_kelurahan = kelurahan.id', 'left')
            ->where('transaksi.id', $id)
            ->first();
    }

    /**
     * Ambil transaksi dengan alamat diambil langsung dari data mitra yang terkait.
     */
  public function getWithAlamatMitra($id)
{
    return $this->select('transaksi.*, 
                          mitra.alamat_jalan as alamat_jalan,
                          provinsi.nama as provinsi_nama, 
                          kota_kabupaten.nama as kota_nama, 
                          kecamatan.nama as kecamatan_nama, 
                          kelurahan.nama as kelurahan_nama,
                          kodepos.kodepos,
                          mitra.nama_lengkap as mitra_nama')
        ->join('mitra', 'mitra.mitra_id = transaksi.mitra_id', 'left')
        ->join('provinsi', 'provinsi.id = mitra.provinsi_id', 'left')
        ->join('kota_kabupaten', 'kota_kabupaten.id = mitra.kota_id', 'left')
        ->join('kecamatan', 'kecamatan.id = mitra.kecamatan_id', 'left')
        ->join('kelurahan', 'kelurahan.id = mitra.kelurahan_id', 'left')
        ->join('kodepos', 'kodepos.id_kelurahan = mitra.kelurahan_id', 'left')
        ->where('transaksi.id', $id)
        ->first();
}

}
