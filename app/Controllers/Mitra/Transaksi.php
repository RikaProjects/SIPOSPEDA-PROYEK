<?php

namespace App\Controllers\Mitra;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\KodeposModel;
use App\Models\MitraModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Transaksi extends BaseController
{
    protected $transaksiModel;
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where('user_id', $userId)->first();

        if (!$mitra) {
            return redirect()->to('/dashboard')->with('error', 'Data mitra tidak ditemukan.');
        }

        $data['transaksi'] = $this->transaksiModel
            ->where('mitra_id', $mitra['mitra_id'])
            ->orderBy('tanggal_transaksi', 'DESC')
            ->findAll();

        return view('mitra/transaksi/index', $data);
    }

    public function detail($id)
    {
        $transaksi = $this->transaksiModel->getWithAlamatMitra($id);

        if (!$transaksi) {
            return redirect()->to('/mitra/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detail = $this->detailTransaksiModel
            ->select('detail_transaksi.*, produk.nama_produk')
            ->join('produk', 'produk.id = detail_transaksi.produk_id')
            ->where('transaksi_id', $id)
            ->findAll();

        return view('mitra/transaksi/detail', [
            'transaksi' => $transaksi,
            'detail' => $detail
        ]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('bukti_pembayaran');
        $userId = session()->get('user_id');
        $mitraModel = new MitraModel();
        $mitra = $mitraModel->where('user_id', $userId)->first();

        if (!$mitra) {
            return redirect()->back()->with('error', 'Data mitra tidak ditemukan.');
        }

        // Generate kode_struk 
        $transaksi = $this->transaksiModel->find($id);
        if (empty($transaksi['kode_struk'])) {
            $kodeStruk = 'STRUK-' . strtoupper(uniqid());
        } else {
            $kodeStruk = $transaksi['kode_struk'];
        }

        $updateData = [
            'provinsi_id'       => $mitra['provinsi_id'],
            'kota_id'           => $mitra['kota_id'],
            'kecamatan_id'      => $mitra['kecamatan_id'],
            'kelurahan_id'      => $mitra['kelurahan_id'],
            'kode_pos'          => $mitra['kode_pos'],
            'alamat_jalan'      => $mitra['alamat_jalan'],
            'kode_struk'        => $kodeStruk,
            'status_pembayaran' => 'pending'
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
            }

            $newName = $file->getRandomName();
            $file->move('uploads/bukti/', $newName);
            $updateData['bukti_pembayaran'] = $newName;
            $updateData['tanggal_dibayar'] = date('Y-m-d H:i:s');
        }

        $this->transaksiModel->update($id, $updateData);

        return redirect()->to('/mitra/transaksi')->with('success', 'Transaksi berhasil dikonfirmasi dan menunggu konfirmasi admin.');
    }

    public function cetak($id)
    {
        $transaksi = $this->transaksiModel
            ->select('transaksi.*, mitra.nama_lengkap as mitra_nama')
            ->join('mitra', 'mitra.mitra_id = transaksi.mitra_id')
            ->where('transaksi.id', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->to('/mitra/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaksi['status_pembayaran'] !== 'dibayar') {
            return redirect()->to('/mitra/transaksi/' . $id)->with('error', 'Cetak transaksi hanya tersedia setelah pembayaran diverifikasi.');
        }

        $provinsiModel   = new ProvinsiModel();
        $kotaModel       = new KotaModel();
        $kecamatanModel  = new KecamatanModel();
        $kelurahanModel  = new KelurahanModel();
        $kodeposModel    = new KodeposModel();

        $provinsi  = $provinsiModel->find($transaksi['provinsi_id']);
        $kota      = $kotaModel->find($transaksi['kota_id']);
        $kecamatan = $kecamatanModel->find($transaksi['kecamatan_id']);
        $kelurahan = $kelurahanModel->find($transaksi['kelurahan_id']);
        $kodepos   = $kodeposModel->where('id_kelurahan', $transaksi['kelurahan_id'])->first();

        $detail = $this->detailTransaksiModel
            ->select('detail_transaksi.*, produk.nama_produk')
            ->join('produk', 'produk.id = detail_transaksi.produk_id')
            ->where('transaksi_id', $id)
            ->findAll();

        $html = view('mitra/transaksi/cetak', [
            'transaksi' => $transaksi,
            'provinsi'  => $provinsi,
            'kota'      => $kota,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'kodepos'   => $kodepos['kodepos'] ?? '',
            'detail'    => $detail
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Struk-' . ($transaksi['kode_struk'] ?? $transaksi['id']) . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
        exit;
    }

    public function konfirmasi($id)
    {
        $transaksi = $this->transaksiModel
            ->select('transaksi.*, 
                      provinsi.nama as nama_provinsi, 
                      kota_kabupaten.nama as nama_kota, 
                      kecamatan.nama as nama_kecamatan, 
                      kelurahan.nama as nama_kelurahan, 
                      kodepos.kodepos')
            ->join('provinsi', 'provinsi.id = transaksi.provinsi_id', 'left')
            ->join('kota_kabupaten', 'kota_kabupaten.id = transaksi.kota_id', 'left')
            ->join('kecamatan', 'kecamatan.id = transaksi.kecamatan_id', 'left')
            ->join('kelurahan', 'kelurahan.id = transaksi.kelurahan_id', 'left')
            ->join('kodepos', 'kodepos.id_kelurahan = transaksi.kelurahan_id', 'left')
            ->find($id);

        if (!$transaksi) {
            return redirect()->to('/mitra/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $detail = $this->detailTransaksiModel
            ->where('transaksi_id', $id)
            ->join('produk', 'produk.id = detail_transaksi.produk_id')
            ->findAll();

        return view('mitra/transaksi/konfirmasi', [
            'transaksi' => $transaksi,
            'detail_transaksi' => $detail
        ]);
    }

    public function batal($id)
    {
        $this->transaksiModel->update($id, [
            'status_pembayaran' => 'dibatalkan'
        ]);

        return redirect()->to('/mitra/transaksi')->with('message', 'Transaksi berhasil dibatalkan.');
    }
}
