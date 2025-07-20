<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // =====================================
    // Laporan Transaksi
    // =====================================
    public function getLaporanTransaksiLengkap()
    {
        return $this->db->table('transaksi')
            ->select('
                transaksi.id,
                transaksi.tanggal_transaksi,
                transaksi.total_harga,
                mitra.nama_lengkap,
                produk.nama_produk,
                detail_transaksi.jumlah_kg,
                detail_transaksi.harga_satuan,
                detail_transaksi.subtotal
            ')
            ->join('mitra', 'mitra.mitra_id = transaksi.mitra_id', 'left')
            ->join('detail_transaksi', 'detail_transaksi.transaksi_id = transaksi.id', 'left')
            ->join('produk', 'produk.id = detail_transaksi.produk_id', 'left')
            ->orderBy('transaksi.tanggal_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLaporanTransaksiByTanggal($startDate, $endDate)
    {
        return $this->db->table('transaksi')
            ->select('
                transaksi.id,
                transaksi.tanggal_transaksi,
                transaksi.total_harga,
                mitra.nama_lengkap,
                produk.nama_produk,
                detail_transaksi.jumlah_kg,
                detail_transaksi.harga_satuan,
                detail_transaksi.subtotal
            ')
            ->join('mitra', 'mitra.mitra_id = transaksi.mitra_id', 'left')
            ->join('detail_transaksi', 'detail_transaksi.transaksi_id = transaksi.id', 'left')
            ->join('produk', 'produk.id = detail_transaksi.produk_id', 'left')
            ->where('transaksi.tanggal_transaksi >=', $startDate)
            ->where('transaksi.tanggal_transaksi <=', $endDate)
            ->orderBy('transaksi.tanggal_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    // =====================================
    // Laporan Pergerakan Stok Produk
    // =====================================
    public function getLogPergerakanStok()
    {
        return $this->db->table('stok_log') 
            ->select('
                stok_log.id,
                stok_log.tanggal,
                produk.nama_produk,
                stok_log.tipe,
                stok_log.jumlah_kg,
                stok_log.keterangan
            ')
            ->join('produk', 'produk.id = stok_log.produk_id', 'left')
            ->orderBy('stok_log.tanggal', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLogStokByTanggal($startDate, $endDate)
    {
        return $this->db->table('stok_log') 
            ->select('
                stok_log.id,
                stok_log.tanggal,
                produk.nama_produk,
                stok_log.tipe,
                stok_log.jumlah_kg,
                stok_log.keterangan
            ')
            ->join('produk', 'produk.id = stok_log.produk_id', 'left')
            ->where('stok_log.tanggal >=', $startDate)
            ->where('stok_log.tanggal <=', $endDate)
            ->orderBy('stok_log.tanggal', 'DESC')
            ->get()
            ->getResultArray();
    }
}
