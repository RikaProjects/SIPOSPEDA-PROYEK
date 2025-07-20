<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $tableTransaksi = 'transaksi';
    protected $tableMitra = 'mitra';
    protected $tableAyamHidup = 'ayam_hidup';

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getTotalPenjualanBulanIni()
    {
        $builder = $this->db->table($this->tableTransaksi);
        $builder->selectSum('total_harga', 'total');
        $builder->where('status_pembayaran', 'dibayar');
        $builder->where('YEAR(tanggal_transaksi)', date('Y'));
        $builder->where('MONTH(tanggal_transaksi)', date('m'));

        $result = $builder->get()->getRow();
        return $result->total ?? 0;
    }

    public function getJumlahMitraAktif()
    {
        $builder = $this->db->table($this->tableMitra);
        $builder->where('status_verifikasi', 'diterima');
        return $builder->countAllResults();
    }

    public function getTotalBeratAyamHidup()
    {
        $builder = $this->db->table($this->tableAyamHidup);
        $builder->selectSum('berat_total_kg', 'total_berat');
        $result = $builder->get()->getRow();
        return $result->total_berat ?? 0;
    }

    public function getTotalEkorAyamHidup()
    {
        $builder = $this->db->table($this->tableAyamHidup);
        $builder->selectSum('jumlah_ekor', 'total_ekor');
        $result = $builder->get()->getRow();
        return $result->total_ekor ?? 0;
    }
}


