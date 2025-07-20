<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use Dompdf\Dompdf;

class LaporanController extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    // ===========================
    // Laporan Transaksi
    // ===========================
    public function index()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        if ($startDate && $endDate) {
            $laporan = $this->laporanModel->getLaporanTransaksiByTanggal($startDate, $endDate);
        } else {
            $laporan = $this->laporanModel->getLaporanTransaksiLengkap();
        }

        return view('admin/laporan/index', [
            'laporan'     => $laporan,
            'start_date'  => $startDate,
            'end_date'    => $endDate
        ]);
    }

    public function cetak()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        if ($startDate && $endDate) {
            $laporan = $this->laporanModel->getLaporanTransaksiByTanggal($startDate, $endDate);
        } else {
            $laporan = $this->laporanModel->getLaporanTransaksiLengkap();
        }

        $html = view('admin/laporan/cetak', [
            'laporan'     => $laporan,
            'start_date'  => $startDate,
            'end_date'    => $endDate
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_transaksi.pdf', ['Attachment' => false]);
        exit;
    }

    // ===========================
    // Laporan Pergerakan Stok
    // ===========================
    public function pergerakanStok()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        if ($startDate && $endDate) {
            $log = $this->laporanModel->getLogStokByTanggal($startDate, $endDate);
        } else {
            $log = $this->laporanModel->getLogPergerakanStok();
        }

        return view('admin/laporan/pergerakan_stok', [
            'log'         => $log,
            'start_date'  => $startDate,
            'end_date'    => $endDate
        ]);
    }

    public function cetakPergerakanStok()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        if ($startDate && $endDate) {
            $log = $this->laporanModel->getLogStokByTanggal($startDate, $endDate);
        } else {
            $log = $this->laporanModel->getLogPergerakanStok();
        }

        $html = view('admin/laporan/cetak_pergerakan_stok', [
            'log'         => $log,
            'start_date'  => $startDate,
            'end_date'    => $endDate
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_pergerakan_stok.pdf', ['Attachment' => false]);
        exit;
    }
}
