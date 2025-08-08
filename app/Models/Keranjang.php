<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel
{
    // Mengambil isi keranjang dari session
    public function getKeranjangByMitra($mitraId)
    {
        return session()->get('keranjang_' . $mitraId) ?? [];
    }

    // Menyimpan keranjang ke session
    public function setKeranjang($mitraId, $keranjang)
    {
        session()->set('keranjang_' . $mitraId, $keranjang);
    }

    // Menghapus keranjang
    public function hapusKeranjang($mitraId)
    {
        session()->remove('keranjang_' . $mitraId);
    }
}
