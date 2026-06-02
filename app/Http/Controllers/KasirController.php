<?php

namespace App\Http\Controllers;

use App\Models\CashierShift;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = today();
        $totalSales = Sale::where('user_id', auth()->id())->whereDate('tanggal_transaksi', $today)->sum('total');
        $transactionCount = Sale::where('user_id', auth()->id())->whereDate('tanggal_transaksi', $today)->count();
        $activeShift = CashierShift::where('user_id', auth()->id())->whereNull('closed_at')->first();
        $latestSales = Sale::with('saleDetails.menu')->where('user_id', auth()->id())->latest()->take(5)->get();
        $cart = session('pos_cart', []);
        $cartCount = array_sum(array_column($cart, 'qty'));

        return view('kasir.dashboard', compact('totalSales', 'transactionCount', 'activeShift', 'latestSales', 'cartCount'));
    }

    public function pos(Request $request)
    {
        $menus = Menu::with(['recipes.barang'])->get();
        $cart = session('pos_cart', []);
        $cartTotal = collect($cart)->sum(fn ($item) => $item['subtotal']);
        $cartCount = array_sum(array_column($cart, 'qty'));
        $cartItems = array_values($cart);

        return view('kasir.pos', compact('menus', 'cart', 'cartTotal', 'cartCount', 'cartItems'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1',
        ]);

        $menu = Menu::with('recipes.barang')->findOrFail($validated['menu_id']);

        $cart = session('pos_cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['qty'] += $validated['qty'];
            $cart[$menu->id]['subtotal'] = $cart[$menu->id]['qty'] * $cart[$menu->id]['harga'];
        } else {
            $cart[$menu->id] = [
                'menu_id' => $menu->id,
                'nama_menu' => $menu->nama_menu,
                'qty' => $validated['qty'],
                'harga' => $menu->harga,
                'subtotal' => $validated['qty'] * $menu->harga,
            ];
        }

        session(['pos_cart' => $cart]);

        return redirect()->route('kasir.pos');
    }

    public function removeFromCart(Menu $menu)
    {
        $cart = session('pos_cart', []);

        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
            session(['pos_cart' => $cart]);
        }

        return redirect()->route('kasir.pos');
    }

    public function updateCart(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('pos_cart', []);

        if (! isset($cart[$menu->id])) {
            return redirect()->route('kasir.pos')->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $cart[$menu->id]['qty'] = $validated['qty'];
        $cart[$menu->id]['subtotal'] = $validated['qty'] * $cart[$menu->id]['harga'];
        session(['pos_cart' => $cart]);

        return redirect()->route('kasir.pos');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'bayar' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:tunai,transfer,kartu',
        ]);

        $cart = session('pos_cart', []);

        if (empty($cart)) {
            return redirect()->route('kasir.pos')->with('error', 'Keranjang kosong. Tambahkan menu terlebih dahulu.');
        }

        $menus = Menu::with(['recipes.barang'])->whereIn('id', array_keys($cart))->get()->keyBy('id');
        $requiredIngredients = [];

        foreach ($cart as $menuId => $item) {
            $menu = $menus[$menuId] ?? null;

            if (! $menu) {
                return redirect()->route('kasir.pos')->with('error', 'Menu tidak ditemukan.');
            }

            foreach ($menu->recipes as $recipe) {
                $required = $recipe->qty * $item['qty'];
                $requiredIngredients[$recipe->barang_id] = ($requiredIngredients[$recipe->barang_id] ?? 0) + $required;
            }
        }

        $insufficient = [];
        foreach ($requiredIngredients as $barangId => $needed) {
            $barang = null;

            foreach ($menus as $menu) {
                $recipe = $menu->recipes->firstWhere('barang_id', $barangId);
                if ($recipe) {
                    $barang = $recipe->barang;
                    break;
                }
            }

            if (! $barang) {
                continue;
            }
            if ($barang->stok < $needed) {
                $insufficient[] = "{$barang->nama_barang} (dibutuhkan: {$needed} {$barang->satuan}, tersedia: {$barang->stok} {$barang->satuan})";
            }
        }

        if (! empty($insufficient)) {
            return redirect()->route('kasir.pos')->with('error', 'Stok bahan kurang: ' . implode(', ', $insufficient));
        }

        $total = collect($cart)->sum(fn ($item) => $item['subtotal']);
        $bayar = $validated['bayar'];
        $kembalian = $bayar - $total;

        if ($kembalian < 0) {
            return redirect()->route('kasir.pos')->with('error', 'Uang bayar tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            $nomorTransaksi = $this->generateTransactionNumber();
            $sale = Sale::create([
                'nomor_transaksi' => $nomorTransaksi,
                'user_id' => auth()->id(),
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'metode_bayar' => $validated['metode_bayar'],
                'catatan' => $request->input('catatan'),
                'tanggal_transaksi' => Carbon::now(),
            ]);

            foreach ($cart as $menuId => $item) {
                $menu = $menus[$menuId];
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'menu_id' => $menu->id,
                    'qty' => $item['qty'],
                    'harga' => $menu->harga,
                    'subtotal' => $item['subtotal'],
                ]);

                foreach ($menu->recipes as $recipe) {
                    $recipe->barang->decrement('stok', $recipe->qty * $item['qty']);
                }
            }

            $activeShift = CashierShift::where('user_id', auth()->id())->whereNull('closed_at')->first();
            if ($activeShift) {
                $activeShift->increment('total_penjualan', $total);
                $activeShift->kas_akhir = $activeShift->kas_awal + $activeShift->total_penjualan + $activeShift->total_setor - $activeShift->total_tarik;
                $activeShift->save();
            }

            DB::commit();
            session()->forget('pos_cart');

            return redirect()->route('kasir.receipt', $sale)->with('success', 'Transaksi berhasil dicatat.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('kasir.pos')->with('error', 'Terjadi kesalahan saat memproses transaksi.');
        }
    }

    public function menuStock()
    {
        $menus = Menu::with(['recipes.barang'])->get();

        return view('kasir.menu-stock', compact('menus'));
    }

    public function history()
    {
        $sales = Sale::with('saleDetails.menu')->where('user_id', auth()->id())->latest()->paginate(12);

        return view('kasir.history', compact('sales'));
    }

    public function receipt(Sale $sale)
    {
        abort_unless($sale->user_id === auth()->id() || auth()->user()->role === 'admin', 403);

        $sale->load('saleDetails.menu');

        return view('kasir.receipt', compact('sale'));
    }

    protected function generateTransactionNumber(): string
    {
        $datePart = now()->format('Ymd');
        $count = Sale::whereDate('created_at', today())->count() + 1;

        return sprintf('TRX-%s-%03d', $datePart, $count);
    }
}
