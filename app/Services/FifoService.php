<?php

namespace App\Services;

use App\Models\FifoHistory;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Database\Eloquent\Collection;

class FifoService
{
    public function prosesKeluar(int $barangId, int $jumlahKeluar, int $stokKeluarId): void
    {
        $total = $this->getTotalStokTersedia($barangId);

        if ($jumlahKeluar > $total) {
            throw new \Exception('Stok tidak cukup. Total stok tersedia: '. $total);
        }

        $remaining = $jumlahKeluar;
        $batches = StokMasuk::where('barang_id', $barangId)
            ->where('sisa_stok', '>', 0)
            ->orderBy('tanggal_masuk')
            ->orderBy('id')
            ->get();

        /** @var StokMasuk $batch */
        foreach ($batches as $batch) {
            if ($remaining <= 0) {
                break;
            }

            $take = min($batch->sisa_stok, $remaining);
            $batch->decrement('sisa_stok', $take);

            FifoHistory::create([
                'stok_masuk_id' => $batch->id,
                'stok_keluar_id' => $stokKeluarId,
                'barang_id' => $barangId,
                'jumlah_diambil' => $take,
                'tanggal_pengambilan' => now()->toDateString(),
            ]);

            $remaining -= $take;
        }

        if ($remaining > 0) {
            throw new \Exception('Proses FIFO gagal: stok batch tidak mencukupi.');
        }
    }

    public function getTotalStokTersedia(int $barangId): int
    {
        return StokMasuk::where('barang_id', $barangId)->sum('sisa_stok');
    }
}
