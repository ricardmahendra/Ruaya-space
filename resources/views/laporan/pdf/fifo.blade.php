<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan FIFO</title>
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
        <h1>Laporan FIFO (First In First Out)</h1>
        <p>Ruaya Space Coffee</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengambilan</th>
                <th>Barang</th>
                <th>Kuantitas</th>
                <th>Stok Masuk</th>
                <th>Stok Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $key => $history)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $history->tanggal_pengambilan->format('d/m/Y H:i') }}</td>
                <td>{{ $history->barang?->nama_barang ?? 'N/A' }}</td>
                <td>{{ $history->kuantitas }}</td>
                <td>{{ $history->stokMasuk?->tanggal_masuk->format('d/m/Y') ?? 'N/A' }}</td>
                <td>{{ $history->stokKeluar?->tanggal_keluar->format('d/m/Y') ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
