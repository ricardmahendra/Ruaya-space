<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $chartStok = Kategori::withSum('barangs as total_stok', 'stok')->get();
        $monthLabels = collect(range(0, 11))->map(fn ($i) => now()->subMonths(11 - $i)->format('M'));
        $transaksiData = collect(range(0, 11))->map(fn ($i) => StokKeluar::whereMonth('tanggal_keluar', now()->subMonths(11 - $i))->whereYear('tanggal_keluar', now()->subMonths(11 - $i))->sum('jumlah'));

        return view('dashboard.index', [
            'total_barang' => Barang::count(),
            'total_stok' => Barang::sum('stok'),
            'barang_menipis' => Barang::whereColumn('stok', '<=', 'reorder_point')->count(),
            'barang_masuk_hari' => StokMasuk::whereDate('tanggal_masuk', today())->sum('jumlah'),
            'barang_keluar_hari' => StokKeluar::whereDate('tanggal_keluar', today())->sum('jumlah'),
            'chart_stok_data' => $chartStok->map(fn ($kategori) => ['label' => $kategori->nama_kategori, 'value' => $kategori->total_stok])->values(),
            'chart_transaksi' => [
                'labels' => $monthLabels,
                'values' => $transaksiData,
            ],
            'recent_activity' => ActivityLog::with('user')->latest()->take(10)->get(),
            'inventory_focus' => Barang::with('kategori')->orderBy('stok')->take(8)->get(),
            'alert_reorder' => Barang::whereColumn('stok', '<=', 'reorder_point')->get(),
        ]);
    }
}
