<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanBakus = BahanBaku::with('supplier')->paginate(10);
        return view('bahan-baku.index', compact('bahanBakus'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('bahan-baku.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        BahanBaku::create($request->all());

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function show(BahanBaku $bahanBaku)
    {
        $bahanBaku->load('supplier');
        return view('bahan-baku.show', compact('bahanBaku'));
    }

    public function edit(BahanBaku $bahanBaku)
    {
        $suppliers = Supplier::all();
        return view('bahan-baku.edit', compact('bahanBaku', 'suppliers'));
    }

    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $bahanBaku->update($request->all());

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan Baku berhasil diupdate.');
    }

    public function destroy(BahanBaku $bahanBaku)
    {
        $bahanBaku->delete();
        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan Baku berhasil dihapus.');
    }
}
