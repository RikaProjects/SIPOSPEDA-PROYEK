<?php
namespace App\Controllers\Mitra;

use App\Controllers\BaseController;

class Data extends BaseController
{
    public function data()
    {
        // Data contoh (biasanya diambil dari database)
        $data['mitra'] = [
            'mitra_id' => 1,
            'user_id' => 3,
            'nama_lengkap' => 'Deliya Sari Nurjanah',
            'no_hp' => '083169151443',
            'nama_brand' => 'cateringku',
            'jenis_usaha' => 'Catering',
            'kepemilikan_usaha' => 'Keluarga',
            'kebutuhan_per_order_kg' => 25,
            'frekuensi_beli_per_bulan' => 15,
            'status_verifikasi' => 'diterima',
            'catatan_verifikasi' => null,
            'dokumen_ktp' => '1752489228_68ef4828c3a9f185909f.jpeg',
            'dokumen_npwp' => '1752489228_10dde977a0997aff8a0c.jpeg',
            'tanggal_daftar' => '2025-07-14',
            'provinsi_id' => 32,
            'kota_id' => 3278,
            'kecamatan_id' => 3278071,
            'kelurahan_id' => 3278071006,
            'kode_pos' => 46191,
            'alamat_jalan' => 'jalan mulyasari nomor 120',
        ];

        return view('mitra/data', $data);
    }
}
