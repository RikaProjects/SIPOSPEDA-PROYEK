<?php

namespace App\Models;

use CodeIgniter\Model;

class AyamHidupModel extends Model
{
    protected $table = 'ayam_hidup';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'tanggal_masuk',
        'jumlah_ekor',
        'berat_total_kg',
        'tanggal_keluar',
        'status',
        'catatan'
    ];

    /**
     * Mengambil total stok ayam hidup dalam kg yang tersedia.
     * Hanya menghitung yang belum memiliki tanggal_keluar dan status 'tersedia'.
     */
    public function getSisaStokKg(): float
    {
        $totalRow = $this->where('status', 'tersedia')
                         ->where('tanggal_keluar IS NULL', null, false)
                         ->selectSum('berat_total_kg')
                         ->get()
                         ->getRow();

        return isset($totalRow->berat_total_kg) ? (float) $totalRow->berat_total_kg : 0.0;
    }

    /**
     * Kurangi stok ayam hidup berdasarkan kebutuhan kg.
     * Akan mengurangi dari entri paling awal (FIFO).
     *
     * @param float $jumlahKg Jumlah yang ingin dikurangi.
     * @return bool True jika berhasil, false jika stok tidak cukup.
     */
    public function kurangiStokAyamHidup(float $jumlahKg): bool
    {
        $stokTersedia = $this->where('status', 'tersedia')
                             ->where('tanggal_keluar IS NULL', null, false)
                             ->orderBy('tanggal_masuk', 'ASC')
                             ->findAll();

        $sisa = $jumlahKg;

        foreach ($stokTersedia as $baris) {
            if ($sisa <= 0) break;

            if ($baris['berat_total_kg'] <= $sisa) {
                // Kurangi seluruh stok dari baris ini
                $sisa -= $baris['berat_total_kg'];
                $this->update($baris['id'], [
                    'tanggal_keluar' => date('Y-m-d'),
                    'status' => 'dipotong'
                ]);
            } else {
                // Hanya kurangi sebagian
                $sisaSisaKg = $baris['berat_total_kg'] - $sisa;
                // Update baris sekarang menjadi keluar
                $this->update($baris['id'], [
                    'berat_total_kg' => $sisaSisaKg
                ]);
                // Tambahkan satu baris baru sebagai "terpakai"
                $this->insert([
                    'tanggal_masuk'   => $baris['tanggal_masuk'],
                    'jumlah_ekor'     => 0, // Tidak diketahui
                    'berat_total_kg'  => $sisa,
                    'tanggal_keluar'  => date('Y-m-d'),
                    'status'          => 'dipotong',
                    'catatan'         => 'Sebagian digunakan untuk produksi'
                ]);
                $sisa = 0;
            }
        }

        return $sisa <= 0;
    }
}
