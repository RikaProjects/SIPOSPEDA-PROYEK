<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'mitra_id';

    protected $allowedFields = [
        'user_id',
        'nama_lengkap',
        'no_hp',
        'nama_brand',
        'jenis_usaha',
        'kepemilikan_usaha',
        'kebutuhan_per_order_kg',
        'frekuensi_beli_per_bulan',
        'status_verifikasi',
        'catatan_verifikasi',
        'dokumen_ktp',      // ✅ tambahkan ini
        'dokumen_npwp', 
        
        'tanggal_daftar',

        // 🏷️ Kolom alamat & wilayah
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',  // ✅ baru
        'kode_pos',       // ✅ baru
        'alamat_jalan',
    ];
    public function getDetailWithWilayah($userId)
{
    return $this->select('
    mitra.mitra_id, mitra.user_id, mitra.nama_lengkap, mitra.no_hp, mitra.nama_brand,
    mitra.jenis_usaha, mitra.kepemilikan_usaha, mitra.kebutuhan_per_order_kg,
    mitra.frekuensi_beli_per_bulan, mitra.status_verifikasi, mitra.catatan_verifikasi,
    mitra.dokumen_ktp, mitra.dokumen_npwp, mitra.tanggal_daftar, mitra.provinsi_id,
    mitra.kota_id, mitra.kecamatan_id, mitra.kelurahan_id, mitra.kode_pos, mitra.alamat_jalan,
    provinsi.nama AS nama_provinsi,
    kota_kabupaten.nama AS nama_kota,
    kecamatan.nama AS nama_kecamatan,
    kelurahan.nama AS nama_kelurahan
')
->join('provinsi', 'provinsi.id = mitra.provinsi_id', 'left')
->join('kota_kabupaten', 'kota_kabupaten.id = mitra.kota_id', 'left')
->join('kecamatan', 'kecamatan.id = mitra.kecamatan_id', 'left')
->join('kelurahan', 'kelurahan.id = mitra.kelurahan_id', 'left')
->where('mitra.user_id', $userId)
->first();
}
}
