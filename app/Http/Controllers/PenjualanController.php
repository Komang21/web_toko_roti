<?php

namespace App\Http\Controllers;

use App\Models\admin\Penjualan;
use App\Models\admin\PenjualanDetail;
use App\Models\admin\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('details.produk')->latest()->paginate(10);
        $totalTransaksi = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total');
        $rataRata = Penjualan::avg('total') ?? 0;

        $firstDate = Penjualan::min('tgl_jual');
        $lastDate = Penjualan::max('tgl_jual');
        $periode = 'Belum ada data';
        if ($firstDate && $lastDate) {
            $firstCarbon = new \DateTime($firstDate);
            $lastCarbon = new \DateTime($lastDate);
            $periode = $firstCarbon->format('d M Y') . ' - ' . $lastCarbon->format('d M Y');
        }

        $stats = [
            ['label' => 'Total Transaksi', 'value' => $totalTransaksi, 'type' => 'number', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'from-indigo-500 to-blue-600'],
            ['label' => 'Total Pendapatan', 'value' => $totalPendapatan, 'type' => 'money', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2', 'color' => 'from-emerald-500 to-teal-600'],
            ['label' => 'Rata-rata/Transaksi', 'value' => $rataRata, 'type' => 'money', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-purple-500 to-violet-600'],
            ['label' => 'Periode Data', 'value' => $periode, 'type' => 'text', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857', 'color' => 'from-amber-500 to-orange-600'],
        ];
        return view('penjualan.index', compact('penjualans', 'stats'));
    }
    public function create()
    {
        $produks = \App\Models\admin\Produk::where('stok', '>', 0)->get();
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            // ...validasi lain...
            'tgl_jual' => 'required|date',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'numeric|min:0',          
        ]);
        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->produk_id as $key => $produk_id) {
                $total += $request->qty[$key] * $request->harga[$key];
            }

            $penjualan = Penjualan::create([
                'tgl_jual' => $request->tgl_jual,
                'total' => $total,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            foreach ($request->produk_id as $key => $produk_id) {
                $qty = $request->qty[$key];
                $produk = Produk::find($produk_id);
                if ($produk && $produk->stok >= $qty) {
                    PenjualanDetail::create([
                        'penjualan_id' => $penjualan->id,
                        'produk_id' => $produk_id,
                        'qty' => $qty,
                        'harga' => $request->harga[$key],
                        'subtotal' => $qty * $request->harga[$key],
                    ]);

                    $produk->stok -= $qty;
                    $produk->save();
                }
            }
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil dibuat.');
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load('details.produk');
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('penjualan.edit', compact('penjualan', 'produks'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tgl_jual' => 'required|date',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $penjualan) {
            $penjualan->details()->delete(); // Simplified

            $total = 0;
            foreach ($request->produk_id as $key => $produk_id) {
                $total += $request->qty[$key] * $request->harga[$key];
            }

            $penjualan->update([
                'tgl_jual' => $request->tgl_jual,
                'total' => $total,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            foreach ($request->produk_id as $key => $produk_id) {
                $qty = $request->qty[$key];
                $produk = Produk::find($produk_id);
                if ($produk && $produk->stok >= $qty) {
                    PenjualanDetail::create([
                        'penjualan_id' => $penjualan->id,
                        'produk_id' => $produk_id,
                        'qty' => $qty,
                        'harga' => $request->harga[$key],
                        'subtotal' => $qty * $request->harga[$key],
                    ]);

                    $produk->stok -= $qty;
                    $produk->save();
                }
            }
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil diupdate.');
    }

    public function destroy(Penjualan $penjualan)
    {
        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->details as $detail) {
                $produk = $detail->produk;
                $produk->stok += $detail->qty;
                $produk->save();
            }
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil dihapus.');
    }
}
