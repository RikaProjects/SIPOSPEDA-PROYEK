<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\ProdukModel;
use App\Models\StokLogModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $detailTransaksiModel;
    protected $produkModel;
    protected $stokLogModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->produkModel = new ProdukModel();
        $this->stokLogModel = new StokLogModel();
    }

    // Halaman utama transaksi
    public function index()
    {
        $data = [
            'title'     => 'Data Transaksi',
            'transaksi' => $this->transaksiModel
                ->orderBy('tanggal_transaksi', 'DESC')
                ->findAll()
        ];

        return view('admin/transaksi/index', $data);
    }

    // Detail transaksi + update status + input resi & pengirim
    public function detail($id)
    {
        // Ambil data transaksi lengkap dengan alamat (menggunakan method di model)
        $transaksi = $this->transaksiModel->getWithWilayah($id);

        if (!$transaksi) {
            throw new PageNotFoundException("Transaksi dengan ID $id tidak ditemukan");
        }

        if ($this->request->getMethod() === 'post') {
            $statusPembayaran = $this->request->getPost('status_pembayaran');
            $statusPengiriman = $this->request->getPost('status_pengiriman');
            $nomorResi        = $this->request->getPost('nomor_resi');
            $namaPengirim     = $this->request->getPost('nama_pengirim');
            $tanggalDikirimInput = $this->request->getPost('tanggal_dikirim');

            // Validasi status (sesuaikan dengan nilai yang digunakan di form)
            $validStatusPembayaran = ['belum_dibayar', 'dibayar'];
            $validStatusPengiriman = ['belum_dikirim', 'dikirim', 'selesai'];

            if (!in_array($statusPembayaran, $validStatusPembayaran) ||
                !in_array($statusPengiriman, $validStatusPengiriman)) {
                return redirect()->back()->with('error', 'Status tidak valid.');
            }

            // Validasi resi wajib saat status pengiriman dikirim
            if ($statusPengiriman === 'dikirim' && (empty($nomorResi) || empty($namaPengirim))) {
                return redirect()->back()->with('error', 'Nomor resi dan nama pengirim wajib diisi jika dikirim.');
            }

            $dataUpdate = [
                'status_pembayaran' => $statusPembayaran,
                'status_pengiriman' => $statusPengiriman,
                'nomor_resi'        => $nomorResi,
                'nama_pengirim'     => $namaPengirim,
            ];

            $statusPembayaranSebelumnya = $transaksi['status_pembayaran'];

            if ($statusPembayaran === 'dibayar' && $statusPembayaranSebelumnya !== 'dibayar') {
                $dataUpdate['tanggal_dibayar'] = date('Y-m-d H:i:s');
            }

            if ($statusPengiriman === 'dikirim') {
                if (!empty($tanggalDikirimInput)) {
                    $dataUpdate['tanggal_dikirim'] = date('Y-m-d H:i:s', strtotime($tanggalDikirimInput));
                } elseif ($transaksi['status_pengiriman'] !== 'dikirim') {
                    $dataUpdate['tanggal_dikirim'] = date('Y-m-d H:i:s');
                }
            }

            // Update transaksi dulu
            $this->transaksiModel->update($id, $dataUpdate);

            // ** LOGIKA PENGURANGAN STOK & STOK LOG **
            if ($statusPembayaran === 'dibayar' && $statusPembayaranSebelumnya !== 'dibayar') {
                // Ambil detail transaksi
                $detailTransaksi = $this->detailTransaksiModel->where('transaksi_id', $id)->findAll();

                foreach ($detailTransaksi as $item) {
                    $produk = $this->produkModel->find($item['produk_id']);
                    if (!$produk) continue;

                    $stokBaru = $produk['stok_kg'] - $item['jumlah_kg'];

                    if ($stokBaru < 0) {
                        // Batalkan update stok jika stok kurang
                        // Bisa ganti dengan rollback transaksi atau error handling sesuai kebutuhan
                        session()->setFlashdata('error', 'Stok produk "' . $produk['nama_produk'] . '" tidak mencukupi.');
                        return redirect()->back();
                    }

                    // Update stok produk
                    $this->produkModel->update($produk['id'], [
                        'stok_kg' => $stokBaru,
                    ]);

                    // Insert stok log
                    $this->stokLogModel->insert([
                        'produk_id' => $produk['id'],
                        'tanggal' => date('Y-m-d H:i:s'),
                        'tipe' => 'keluar',
                        'jumlah_kg' => $item['jumlah_kg'],
                        'keterangan' => 'Pengurangan stok untuk transaksi ID ' . $id,
                    ]);
                }
            }

            return redirect()
                ->to("/admin/transaksi/detail/$id")
                ->with('success', 'Status dan pengiriman berhasil diperbarui.');
        }

        // GET: Tampilkan halaman detail
        $data = [
            'title'     => 'Detail Transaksi',
            'transaksi' => $transaksi,
        ];

        return view('admin/transaksi/detail', $data);
    }

    // Fungsi updateStatus jika dibutuhkan untuk endpoint ajax atau form terpisah
    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $statusPembayaran = $this->request->getPost('status_pembayaran');
        $statusPengiriman = $this->request->getPost('status_pengiriman');
        $nomorResi        = $this->request->getPost('nomor_resi');
        $namaPengirim     = $this->request->getPost('nama_pengirim');
        $tanggalDikirimInput = $this->request->getPost('tanggal_dikirim');

        $data = [
            'status_pembayaran' => $statusPembayaran,
            'status_pengiriman' => $statusPengiriman,
            'nomor_resi'        => $nomorResi,
            'nama_pengirim'     => $namaPengirim,
        ];

        $statusPembayaranSebelumnya = $transaksi['status_pembayaran'];

        if ($statusPembayaran === 'dibayar' && $statusPembayaranSebelumnya !== 'dibayar') {
            $data['tanggal_dibayar'] = date('Y-m-d H:i:s');
        }

        if ($statusPengiriman === 'dikirim') {
            if (!empty($tanggalDikirimInput)) {
                $data['tanggal_dikirim'] = date('Y-m-d H:i:s', strtotime($tanggalDikirimInput));
            } elseif ($transaksi['status_pengiriman'] !== 'dikirim') {
                $data['tanggal_dikirim'] = date('Y-m-d H:i:s');
            }
        }

        $this->transaksiModel->update($id, $data);

        // ** LOGIKA PENGURANGAN STOK & STOK LOG DI UPDATE STATUS JUGA **
        if ($statusPembayaran === 'dibayar' && $statusPembayaranSebelumnya !== 'dibayar') {
            $detailTransaksi = $this->detailTransaksiModel->where('transaksi_id', $id)->findAll();

            foreach ($detailTransaksi as $item) {
                $produk = $this->produkModel->find($item['produk_id']);
                if (!$produk) continue;

                $stokBaru = $produk['stok_kg'] - $item['jumlah_kg'];

                if ($stokBaru < 0) {
                    session()->setFlashdata('error', 'Stok produk "' . $produk['nama_produk'] . '" tidak mencukupi.');
                    return redirect()->back();
                }

                $this->produkModel->update($produk['id'], [
                    'stok_kg' => $stokBaru,
                ]);

                $this->stokLogModel->insert([
                    'produk_id' => $produk['id'],
                    'tanggal' => date('Y-m-d H:i:s'),
                    'tipe' => 'keluar',
                    'jumlah_kg' => $item['jumlah_kg'],
                    'keterangan' => 'Pengurangan stok untuk transaksi ID ' . $id,
                ]);
            }
        }

        return redirect()->to('/admin/transaksi')->with('success', 'Status dan data pengiriman berhasil diperbarui.');
    }
}
