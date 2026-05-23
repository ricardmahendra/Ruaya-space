<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStokKeluarRequest;
use App\Models\Barang;
use App\Models\StokKeluar;
use App\Services\ActivityLogService;
use App\Services\FifoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index(Request $request)
    {
        $stokKeluars = StokKeluar::with('barang', 'user')->orderBy('tanggal_keluar', 'desc')->paginate(12);
        return view('stok-keluar.index', compact('stokKeluars'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('stok-keluar.create', compact('barangs'));
    }

    public function store(StoreStokKeluarRequest $request, FifoService $fifoService)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        DB::transaction(function () use ($data, $fifoService) {
            $barang = Barang::findOrFail($data['barang_id']);
            $stokKeluar = StokKeluar::create($data);
            $fifoService->prosesKeluar($barang->id, $data['jumlah'], $stokKeluar->id);
            $barang->decrement('stok', $data['jumlah']);
            ActivityLogService::log('STOCK_OUT', "Stok keluar: {$barang->nama_barang} -{$data['jumlah']} {$barang->satuan}", StokKeluar::class, $stokKeluar->id);
        });

        return redirect()->route('stok-keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }
}
