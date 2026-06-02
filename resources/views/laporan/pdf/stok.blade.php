<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; border: 1px solid #ddd; padding: 8px; text-align: left; }
        td { border: 1px solid #ddd; padding: 8px; }
        h1 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Stok</h1>
        <p>Ruaya Space Coffee</p>
        <p>{{ $periodLabel ?? now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Sisa</th>
                <th>% Pemakaian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $key => $barang)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori?->nama_kategori ?? 'N/A' }}</td>
                <td>{{ $barang->total_masuk ?? 0 }}</td>
                <td>{{ $barang->total_keluar ?? 0 }}</td>
                <td>{{ $barang->stok }}</td>
                <td>{{ $barang->usage_percentage ?? 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
