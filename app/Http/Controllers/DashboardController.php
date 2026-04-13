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
        // KPI Totals
        $totalProduk = Produk::count();
        $totalSupplier = Supplier::count();
        $totalPenjualan = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total');

        // Weekday labels (DAYOFWEEK 1=Min..7=Sab)
        $labels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        // Current week
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        // Tren Stok Masuk (Pembelian qty this week)
        $masukRaw = DB::table('pembelians')
            ->join('pembelian_details', 'pembelians.id', '=', 'pembelian_details.pembelian_id')
            ->whereBetween('pembelians.tgl_pembelian', [$startDate, $endDate])
            ->select(DB::raw('DAYOFWEEK(pembelians.tgl_pembelian) as hari'), DB::raw('SUM(pembelian_details.qty) as total'))
            ->groupBy('hari')
            ->pluck('total', 'hari');
        $dataStokMasuk = [];
        for ($i = 1; $i <= 7; $i++) {
            $dataStokMasuk[] = $masukRaw->get($i, 0);
        }

        // Tren Stok Keluar (Penjualan qty this week)
        $keluarRaw = DB::table('penjualans')
            ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->whereBetween('penjualans.tgl_jual', [$startDate, $endDate])
            ->select(DB::raw('DAYOFWEEK(penjualans.tgl_jual) as hari'), DB::raw('SUM(penjualan_details.qty) as total'))
            ->groupBy('hari')
            ->pluck('total', 'hari');
        $dataStokKeluar = [];
        for ($i = 1; $i <= 7; $i++) {
            $dataStokKeluar[] = $keluarRaw->get($i, 0);
        }

        // Distribusi Pesanan (produk qty)
        $distribusiRaw = DB::table('penjualans')
            ->join('penjualan_details', 'penjualans.id', '=', 'penjualan_details.penjualan_id')
            ->join('produks', 'penjualan_details.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.tgl_jual', [$startDate, $endDate])
            ->select('produks.nama', DB::raw('SUM(penjualan_details.qty) as total'))
            ->groupBy('produks.id', 'produks.nama')
            ->orderByDesc('total')
            ->limit(7)
            ->get();
        $distribusiLabels = $distribusiRaw->pluck('nama')->toArray();
        $dataDistribusi = $distribusiRaw->pluck('total')->toArray();
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

