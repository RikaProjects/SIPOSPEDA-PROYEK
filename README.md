# 🐔 SIPOSPEDA- Sistem Informasi Pengelolaan Stok dan Penjualan Daging Ayam

SIPOSPEDA adalah sistem informasi berbasis web yang dirancang untuk membantu pelaku usaha dalam mengelola stok dan penjualan daging ayam secara efisien dan terorganisir. Sistem ini dibangun menggunakan CodeIgniter 4 dan MySQL.

## 📌 Fitur Utama

- 🔐 Autentikasi pengguna (admin gudang, admin produksi, admin sales, dll.)
- 📦 Pengelolaan stok masuk dan keluar
- 📊 Laporan penjualan dan Pergerakan Stok
- 📁 Manajemen data user, mitra, Ayam Hidup, Hasil Produksi, Produk, kategori, dan transaksi
- 🗂️ Riwayat transaksi
- 📆 Filter dan pencarian data laporan berdasarkan tanggal
- 🖨️ Export laporan ke PDF

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP (CodeIgniter 4)
- **Frontend:** HTML, CSS, Bootstrap, AdminLTE
- **Database:** MySQL
- **Library tambahan:** DomPDF (export PDF), jQuery, Chart.js

## 🚀 Instalasi Lokal

1. Clone repository ini:
   ```bash
   git clone https://github.com/RikaProjects/]SIPOSPEDA-PROYEK.git

2. Jalankan di folder XAMPP htdocs
   ```bash
   cd /c/xampp/htdocs/Sukahati-Daging_Ayam

3. Import database dari file database/sukahati.sql ke phpMyAdmin
4. Ubah konfigurasi database di:
    ```bash
    app/Config/Database.php
5. Jalankan di browser
 ```bash
   http://localhost/Sukahati-Daging_Ayam/public
```

👤 Role Pengguna
Admin Gudang: Mengelola stok masuk dan keluar

Admin Produksi: Input hasil produksi

Admin Sales: Input transaksi penjualan

Direktur/Admin Utama: Melihat laporan dan manajemen keseluruhan

Mitra : Melihat Produk dan bertransaksi

Calon Mitra : mendaftarkan diri menjadi mitra

🧠 Tujuan Proyek
Membantu digitalisasi proses pencatatan stok dan penjualan daging ayam pada usaha kecil hingga menengah, mengurangi kesalahan manusia dan kehilangan data, serta meningkatkan efisiensi dan akurasi laporan.

   
