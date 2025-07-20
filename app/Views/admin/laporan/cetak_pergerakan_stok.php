<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pergerakan Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <h3>Laporan Pergerakan Stok Produk</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Tipe</th>
                <th>Jumlah (Kg)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($log)): ?>
                <?php foreach ($log as $row): ?>
                    <tr>
                        <td><?= esc($row['id']) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($row['tanggal'])) ?></td>
                        <td><?= esc($row['nama_produk']) ?></td>
                        <td><?= esc(ucfirst($row['tipe'])) ?></td>
                        <td><?= number_format($row['jumlah_kg'], 2, ',', '.') ?></td>
                        <td><?= esc($row['keterangan']) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada data</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</body>
</html>
