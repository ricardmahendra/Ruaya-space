<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Menipis</title>
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
        <h1>Laporan Stok Menipis</h1>
        <p>Ruaya Space Coffee</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok Saat Ini</th>
                <th>Minimum Stok</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $key => $barang)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori?->nama_kategori ?? 'N/A' }}</td>
                <td>{{ $barang->stok }}</td>
                <td>{{ $barang->reorder_point }}</td>
                <td>
                    @if($barang->stok <= 0)
                        Stok Habis
                    @else
                        Pesan {{ $barang->reorder_point - $barang->stok }} unit
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
