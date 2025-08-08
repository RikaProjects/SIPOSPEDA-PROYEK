<?php

namespace App\Controllers\Mitra;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\MitraModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;


class Keranjang extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $keranjang = session()->get('keranjang') ?? [];
        $totalHarga = array_sum(array_column($keranjang, 'subtotal'));

        // Ambil data provinsi untuk dropdown
        $provinsiModel = new ProvinsiModel();
        $provinsi = $provinsiModel->findAll();

        return view('mitra/keranjang', [
            'keranjang'    => $keranjang,
            'total_harga'  => $totalHarga,
            'provinsi'     => $provinsi // kirim ke view
        ]);
    }

    public function tambah($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to(base_url('mitra/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $keranjang = session()->get('keranjang') ?? [];
        $found = false;

        foreach ($keranjang as &$item) {
            if ($item['produk_id'] == $id) {
                $item['jumlah_kg'] += 1;
                $item['subtotal'] = $item['jumlah_kg'] * $item['harga_satuan'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $keranjang[] = [
                'produk_id'     => $produk['id'],
                'nama_produk'   => $produk['nama_produk'],
                'harga_satuan'  => $produk['harga'],
                'jumlah_kg'     => 1,
                'subtotal'      => $produk['harga'],
                'foto_produk'   => $produk['foto_produk'] ?? ''
            ];
        }

        session()->set('keranjang', $keranjang);
        return redirect()->to(base_url('mitra/keranjang'))->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update()
    {
        $ids  = $this->request->getPost('id');
        $qtys = $this->request->getPost('qty');
        $keranjang = session()->get('keranjang') ?? [];

        if ($ids && $qtys && count($ids) === count($qtys)) {
            foreach ($keranjang as &$item) {
                foreach ($ids as $i => $id) {
                    if ($item['produk_id'] == $id) {
                        $item['jumlah_kg'] = max(1, (int) $qtys[$i]);
                        $item['subtotal'] = $item['jumlah_kg'] * $item['harga_satuan'];
                        break;
                    }
                }
            }
            session()->set('keranjang', $keranjang);
        }

        return redirect()->to(base_url('mitra/keranjang'))->with('success', 'Keranjang diperbarui.');
    }

    public function hapus($id)
    {
        $keranjang = session()->get('keranjang') ?? [];
        $keranjang = array_filter($keranjang, fn($item) => $item['produk_id'] != $id);
        session()->set('keranjang', array_values($keranjang));

        return redirect()->to(base_url('mitra/keranjang'))->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $keranjang = session()->get('keranjang') ?? [];
        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $userId = session()->get('user_id');
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where('user_id', $userId)->first();

        if (!$mitra) {
            return redirect()->to('/mitra/dashboard')->with('error', 'Mitra tidak ditemukan.');
        }

        // Ambil input alamat dari form
        $provinsi_id   = $this->request->getPost('provinsi_id');
        $kota_id       = $this->request->getPost('kota_id');
        $kecamatan_id  = $this->request->getPost('kecamatan_id');
        $kelurahan_id  = $this->request->getPost('kelurahan_id');
        $kode_pos      = $this->request->getPost('kode_pos');
        $alamat_jalan  = $this->request->getPost('alamat_jalan');

        if (!$provinsi_id || !$kota_id || !$kecamatan_id || !$kelurahan_id || !$kode_pos || !$alamat_jalan) {
            return redirect()->back()->with('error', 'Alamat lengkap harus diisi.');
        }

        $totalBerat = array_sum(array_column($keranjang, 'jumlah_kg'));
        $totalHarga = array_sum(array_column($keranjang, 'subtotal'));
        $kotaModel = new KotaModel();
$kota = $kotaModel->find($kota_id);
$namaKota = $kota['nama'] ?? '';

        $wilayahKhusus = ['KOTA TASIKMALAYA', 'KOTA BANDUNG'];

if (in_array($namaKota, $wilayahKhusus)) {
    if ($totalBerat < 10) {
        return redirect()->back()->with('error', 'Minimal pemesanan untuk wilayah Tasikmalaya dan Bandung adalah 10 kg.');
    }
} else {
    if ($totalBerat < 50) {
        return redirect()->back()->with('error', 'Minimal pemesanan untuk wilayah lain adalah 50 kg.');
    }
}


        foreach ($keranjang as $item) {
            $produk = $this->produkModel->find($item['produk_id']);
            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
            if ($item['jumlah_kg'] > $produk['stok_kg']) {
                return redirect()->back()->with('error', 'Stok produk "' . $produk['nama_produk'] . '" tidak mencukupi.');
            }
        }

        $transaksiModel = new TransaksiModel();
        $transaksiModel->insert([
            'mitra_id'            => $mitra['mitra_id'],
            'tanggal_transaksi'   => date('Y-m-d'),
            'status_pembayaran'   => 'pending',
            'status_pengiriman'   => 'diproses',
            'total_harga'         => $totalHarga,
            'metode_pembayaran'   => 'cod',

            // Alamat dari input user
            'provinsi_id'         => $provinsi_id,
            'kota_id'             => $kota_id,
            'kecamatan_id'        => $kecamatan_id,
            'kelurahan_id'        => $kelurahan_id,
            'kode_pos'            => $kode_pos,
            'alamat_jalan'        => $alamat_jalan
        ]);

        $transaksiId = $transaksiModel->insertID();

        $detailModel = new DetailTransaksiModel();
        foreach ($keranjang as $item) {
            $detailModel->insert([
                'transaksi_id'  => $transaksiId,
                'produk_id'     => $item['produk_id'],
                'jumlah_kg'     => $item['jumlah_kg'],
                'harga_satuan'  => $item['harga_satuan'],
                'subtotal'      => $item['subtotal'],
            ]);
        }

        // Kurangi stok
        foreach ($keranjang as $item) {
            $produk = $this->produkModel->find($item['produk_id']);
            $stokBaru = $produk['stok_kg'] - $item['jumlah_kg'];
            $this->produkModel->update($item['produk_id'], [
                'stok_kg' => $stokBaru
            ]);
        }

        session()->remove('keranjang');

        return redirect()->to('/mitra/transaksi/konfirmasi/' . $transaksiId)
                         ->with('success', 'Checkout berhasil, silakan lakukan pembayaran.');
    }
}
