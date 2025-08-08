<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        echo "▶ Mulai seeding kelurahan & kodepos...\n";

        $filePath = WRITEPATH . 'uploads/kodepos.extended.json';
        if (!file_exists($filePath)) {
            echo "❌ File kodepos.extended.json tidak ditemukan di WRITEPATH/uploads/\n";
            return;
        }

        $kodeposJson = file_get_contents($filePath);
        $kodeposData = json_decode($kodeposJson, true);

        $jumlahKelurahan = 0;
        $jumlahKodepos = 0;
        $kelurahanInserted = [];

        foreach ($kodeposData as $provinsi) {
            foreach ($provinsi['Kabupaten/Kota'] ?? [] as $kabupaten) {
                foreach ($kabupaten['Kecamatan'] ?? [] as $kecamatan) {
                    foreach ($kecamatan['Kelurahan/Desa'] ?? [] as $namaKelurahan => $data) {
                        $id_raw = $data['ID'] ?? null;
                        $kodepos = $data['Kode Pos'] ?? null;

                        if (!$id_raw || !$kodepos) continue;

                        $id_kelurahan = str_replace('.', '', $id_raw);         // contoh: 32.01.01.0001 → 3201010001
                        $id_kecamatan = substr($id_kelurahan, 0, 7);           // 7 digit pertama = id kecamatan

                        // ✅ Cek apakah kecamatan tersedia
                        $cekKecamatan = $db->table('kecamatan')
                            ->where('id', $id_kecamatan)
                            ->countAllResults();

                        if ($cekKecamatan === 0) {
                            echo "⚠️ Lewati kelurahan '$namaKelurahan' karena kecamatan_id '$id_kecamatan' tidak ditemukan.\n";
                            continue;
                        }

                        // ✅ Insert kelurahan jika belum
                        if (!in_array($id_kelurahan, $kelurahanInserted)) {
                            $db->table('kelurahan')->insert([
                                'id' => $id_kelurahan,
                                'kecamatan_id' => $id_kecamatan,
                                'nama' => $namaKelurahan,
                            ]);
                            $kelurahanInserted[] = $id_kelurahan;
                            $jumlahKelurahan++;
                        }

                        // ✅ Insert kodepos jika belum
                        $exists = $db->table('kodepos')->where('id_kelurahan', $id_kelurahan)->countAllResults();
                        if (!$exists) {
                            $db->table('kodepos')->insert([
                                'id_kelurahan' => $id_kelurahan,
                                'kodepos' => $kodepos,
                            ]);
                            $jumlahKodepos++;
                        }
                    }
                }
            }
        }

        echo "✅ Kelurahan berhasil dimasukkan: $jumlahKelurahan data\n";
        echo "✅ Kodepos berhasil dimasukkan: $jumlahKodepos data\n";
        echo "🎉 Seeder wilayah selesai dengan sukses!\n";
    }
}
