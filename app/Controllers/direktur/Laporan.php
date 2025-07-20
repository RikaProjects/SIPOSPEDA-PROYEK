<?php

namespace App\Controllers\Direktur;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    // Laporan Transaksi
    public function transaksi()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['laporan']    = $this->laporanModel->getLaporanTransaksi($start_date, $end_date);

        return view('direktur/laporan/transaksi', $data);
    }

    public function cetakTransaksi()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        $laporan = $this->laporanModel->getLaporanTransaksi($start_date, $end_date);
        $html    = view('direktur/laporan/cetak_transaksi', ['laporan' => $laporan]);

        return $this->response->setBody($html);
    }

    // Laporan Pergerakan Stok Produk
    public function pergerakanStok()
    {
        $data['log'] = $this->laporanModel->getLogPergerakanStok();
        return view('direktur/laporan/pergerakan_stok', $data);
    }

    public function cetakPergerakanStok()
    {
        $log  = $this->laporanModel->getLogPergerakanStok();
        $html = view('direktur/laporan/cetak_pergerakan_stok', ['log' => $log]);

        return $this->response->setBody($html);
    }
}
