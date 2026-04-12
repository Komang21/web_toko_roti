<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin\Produk;
use App\Models\admin\Supplier;
use App\Models\admin\Penjualan;
use App\Models\admin\Pembelian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Totals (existing)
        $totalProduk = Produk::count();
        $totalSupplier = Supplier::count();
        $totalPenjualan = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total');

        // Labels
        $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        // Trends: Last 30 days, weekly totals (sum qty per weekday)
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(30);

        // Stok Masuk: Sum qty PembelianDetail by DAYOFWEEK(tgl_pembelian)
        $masukRaw = Pembelian::whereBetween('tgl_pembelian', [$startDate, $endDate])
            ->join('pembelian_details', 'pembelians.id', '=', 'pembelian_details.pembelian_id')
            ->select(DB::raw('DAYOFWEEK(tgl_pembelian) as dayofweek'), DB::raw('SUM(pembelian_details.qty) as total_qty'))
            ->groupBy('dayofweek')
            ->pluck('total_qty', 'dayofweek');

        $dataStokMasuk = [];
        for ($i = 1; $i <= 7; $i++) {
            $dataStokMasuk[] = $masukRaw->get($i, 0);
        }

        // Stok Keluar: Sum qty PenjualanDetail by DAYOFWEEK(tgl_jual)
        $keluarRaw = Penjualan::whereBetween('tgl_jual', [$startDate, $endDate])
            ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->select(DB::raw('DAYOFWEEK(tgl_jual) as dayofweek'), DB::raw('SUM(penjualan_details.qty) as total_qty'))
            ->groupBy('dayofweek')
            ->pluck('total_qty', 'dayofweek');

        $dataStokKeluar = [];
        for ($i = 1; $i <= 7; $i++) {
            $dataStokKeluar[] = $keluarRaw->get($i, 0);
        }

        // Distribusi Pesanan: Sum qty per produk from last 30 days PenjualanDetail
        $distribusiRaw = Penjualan::whereBetween('tgl_jual', [$startDate, $endDate])
            ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->join('produks', 'penjualan_details.produk_id', '=', 'produks.id')
            ->select('produks.nama', DB::raw('SUM(penjualan_details.qty) as total_qty'))
            ->groupBy('produks.id', 'produks.nama')
            ->orderBy('total_qty', 'desc')
            ->get();

        $distribusiLabels = $distribusiRaw->pluck('nama')->toArray();
        $dataDistribusi = $distribusiRaw->pluck('total_qty')->toArray();

        // Fallback if no data
        if (empty($distribusiLabels)) {
            $distribusiLabels = ['No Data'];
            $dataDistribusi = [0];
        }

        return view('dashboard', compact(
            'totalProduk', 'totalSupplier', 'totalPenjualan', 'totalPendapatan',
            'labels', 'dataStokMasuk', 'dataStokKeluar',
            'distribusiLabels', 'dataDistribusi'
        ));
    }
}
?>


