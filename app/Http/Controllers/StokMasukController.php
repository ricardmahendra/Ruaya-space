<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStokMasukRequest;
use App\Models\Barang;
use App\Models\StokMasuk;
use App\Models\Supplier;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index(Request $request)
    {
        $stokMasuks = StokMasuk::with(['barang', 'supplier', 'user'])
            ->orderBy('tanggal_masuk', 'desc')
            ->paginate(12);

        return view('stok-masuk.index', compact('stokMasuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('stok-masuk.create', compact('barangs', 'suppliers'));
    }

    public function store(StoreStokMasukRequest $request)
    {
        $data = $request->validated();
        $data['sisa_stok'] = $data['jumlah'];
        $data['user_id'] = auth()->id();

        DB::transaction(function () use ($data) {
            $stokMasuk = StokMasuk::create($data);
            $barang = Barang::find($data['barang_id']);
            $barang->increment('stok', $data['jumlah']);
            ActivityLogService::log('STOCK_IN', "Stok masuk: {$barang->nama_barang} {$data['jumlah']} {$barang->satuan}", StokMasuk::class, $stokMasuk->id);
        });

        return redirect()->route('stok-masuk.index')->with('success', 'Stok masuk berhasil dicatat.');
    }
}
