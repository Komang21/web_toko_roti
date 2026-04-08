<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('details.produk')->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $produks = Produk::has('stok > 0')->get(); // Only in-stock
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
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

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->produk_id as $key => $produk_id) {
                $total += $request->qty[$key] * $request->harga[$key];
            }

            $penjualan = Penjualan::create([
                'tgl_jual' => $request->tgl_jual,
                'total' => $total,
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
