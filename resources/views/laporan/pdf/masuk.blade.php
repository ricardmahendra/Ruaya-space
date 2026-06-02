<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Masuk</title>
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
        <h1>Laporan Stok Masuk</h1>
        <p>Ruaya Space Coffee</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Supplier</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stokMasuks as $key => $masuk)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $masuk->tanggal_masuk->format('d/m/Y H:i') }}</td>
                <td>{{ $masuk->barang?->nama_barang ?? 'N/A' }}</td>
                <td>{{ $masuk->supplier?->nama_supplier ?? 'N/A' }}</td>
                <td>{{ $masuk->kuantitas }}</td>
                <td>Rp {{ number_format($masuk->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $masuk->user?->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
