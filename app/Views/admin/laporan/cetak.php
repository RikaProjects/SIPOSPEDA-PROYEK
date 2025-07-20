<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #f0f0f0;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Laporan Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Mitra</th>
                <th>Produk</th>
                <th>Jumlah (kg)</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $row): ?>
            <tr>
                <td><?= esc($row['id']) ?></td>
                <td><?= esc($row['tanggal_transaksi']) ?></td>
                <td><?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= esc($row['nama_lengkap']) ?></td>
                <td><?= esc($row['nama_produk']) ?></td>
                <td><?= esc($row['jumlah_kg']) ?></td>
                <td><?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= number_format($row['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
