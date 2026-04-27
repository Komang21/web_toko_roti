<?php

namespace App\Http\Controllers;

use App\Models\admin\Pembelian;
use App\Models\admin\PembelianDetail;
use App\Models\admin\BahanBaku;
use App\Models\admin\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
    {
     public function index(Request $request)
{
    $limit = $request->get('limit') ?? 'limited';
    
    $pembeliansTerbaru = Pembelian::with(['supplier', 'details.bahan'])->latest()->take(5)->get();
    
    $pembeliansQuery = Pembelian::with(['supplier', 'details.bahan'])->latest();
    $pembelians = ($limit === 'all') 
        ? $pembeliansQuery->paginate(15)
        : $pembeliansQuery->paginate(5);
    
    $totalPengeluaran = Pembelian::sum('total');
    $totalPembelian = Pembelian::count();
    $supplierAktif = Pembelian::distinct('supplier_id')->count();
    $rataRata = Pembelian::avg('total') ?? 0;

    return view('pembelian.index', compact(
        'pembelians',
        'pembeliansTerbaru',
        'totalPengeluaran',
        'totalPembelian',
        'supplierAktif',
        'rataRata',
        'limit'
    ));
}

    public function create()
    {
        $bahanBakus = BahanBaku::all();
        $suppliers = Supplier::all();
        return view('pembelian.create', compact('bahanBakus', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tgl_pembelian' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'exists:bahan_bakus,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->bahan_id as $key => $bahan_id) {
                $subtotal = $request->qty[$key] * $request->harga[$key];
                $total += $subtotal;
            }

            $pembelian = Pembelian::create([
                'tgl_pembelian' => $request->tgl_pembelian,
                'total' => $total,
                'supplier_id' => $request->supplier_id,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            foreach ($request->bahan_id as $key => $bahan_id) {
                $detailData = [
                    'pembelian_id' => $pembelian->id,
                    'bahan_id' => $bahan_id,
                    'qty' => $request->qty[$key],
                    'harga' => $request->harga[$key],
                    'subtotal' => $request->qty[$key] * $request->harga[$key],
                ];
                PembelianDetail::create($detailData);

                $bahan = BahanBaku::find($bahan_id);
                $bahan->stok += $request->qty[$key];
                $bahan->save();
            }
        });

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil dibuat.');
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['supplier', 'details.bahan']);
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $bahanBakus = BahanBaku::all();
        $suppliers = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'bahanBakus', 'suppliers'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tgl_pembelian' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'exists:bahan_bakus,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $pembelian) {
            // Rollback stok for old details? Simplified: delete old details, create new
            $pembelian->details()->delete();

            $total = 0;
            foreach ($request->bahan_id as $key => $bahan_id) {
                $total += $request->qty[$key] * $request->harga[$key];
            }

            $pembelian->update([
                'tgl_pembelian' => $request->tgl_pembelian,
                'total' => $total,
                'supplier_id' => $request->supplier_id,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            foreach ($request->bahan_id as $key => $bahan_id) {
                $detailData = [
                    'pembelian_id' => $pembelian->id,
                    'bahan_id' => $bahan_id,
                    'qty' => $request->qty[$key],
                    'harga' => $request->harga[$key],
                    'subtotal' => $request->qty[$key] * $request->harga[$key],
                ];
                $detail = PembelianDetail::create($detailData);

                $bahan = BahanBaku::find($bahan_id);
                $bahan->stok += $request->qty[$key];
                $bahan->save();
            }
        });

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil diupdate.');
    }

    public function destroy(Pembelian $pembelian)
    {
        DB::transaction(function () use ($pembelian) {
            // Rollback stok
            foreach ($pembelian->details as $detail) {
                $bahan = $detail->bahan;
                $bahan->stok -= $detail->qty;
                $bahan->save();
            }
            $pembelian->delete();
        });

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil dihapus.');
    }
    
}
