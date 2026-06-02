<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Keluar</title>
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
        <h1>Laporan Stok Keluar</h1>
        <p>Ruaya Space Coffee</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Kuantitas</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stokKeluars as $key => $keluar)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $keluar->tanggal_keluar->format('d/m/Y H:i') }}</td>
                <td>{{ $keluar->barang?->nama_barang ?? 'N/A' }}</td>
                <td>{{ $keluar->kuantitas }}</td>
                <td>{{ $keluar->keterangan ?? '-' }}</td>
                <td>{{ $keluar->user?->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
