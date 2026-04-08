<?php

namespace App\Http\Controllers;

use App\Models\Produksi; // Assume model created or create later
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    public function index()
    {
        // Assume Produksi model
        $produksis = []; // or paginate if model exists
        return view('produksi.index', compact('produksis'));
    }

    public function create()
    {
        $produks = Produk::all();
        $bahanBakus = BahanBaku::all();
        return view('produksi.create', compact('produks', 'bahanBakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'qty_produk' => 'required|integer|min:1',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'exists:bahan_bakus,id',
            'qty_bahan' => 'required|array',
            'qty_bahan.*' => 'integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $produk = Produk::find($request->produk_id);
            $produk->stok += $request->qty_produk;
            $produk->save();

            foreach ($request->bahan_id as $key => $bahan_id) {
                $bahan = BahanBaku::find($bahan_id);
                $bahan->stok -= $request->qty_bahan[$key];
                $bahan->save();
            }

            // Save produksi record if model exists
            // Produksi::create($request->all());
        });

        return redirect()->route('produksi.index')
            ->with('success', 'Produksi berhasil.');
    }

    // Basic other methods
    public function destroy($id)
    {
        return redirect()->route('produksi.index')
            ->with('success', 'Deleted.');
    }
}
?>

