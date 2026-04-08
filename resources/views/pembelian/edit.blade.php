@extends('layouts.app')

@section('title', 'Edit Pembelian')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Pembelian #{{ $pembelian->id }}</h2>

    <form action="{{ route('pembelian.update', $pembelian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Supplier</label>
            <select name="supplier_id" class="shadow appearance-none border rounded w-full py-2 px-3 @error('supplier_id') border-red-500 @enderror" required>
                <option value="">Pilih Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $pembelian->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
            <input type="date" name="tgl_pembelian" value="{{ old('tgl_pembelian', $pembelian->tgl_pembelian->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 @error('tgl_pembelian') border-red-500 @enderror" required>
            @error('tgl_pembelian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <h3 class="text-lg font-semibold mb-4">Detail Bahan (Edit akan replace semua detail lama)</h3>
        <table id="details-table" class="w-full border-collapse border mb-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Bahan Baku</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Harga per Unit</th>
                    <th class="border p-2">Subtotal</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="details-tbody">
                <tr class="detail-row">
                    <td class="border p-2">
                        <select name="bahan_id[]" class="form-control" required>
                            <option value="">Pilih Bahan</option>
                            @foreach ($bahanBakus as $bahan)
                                <option value="{{ $bahan->id }}" data-harga="{{ $bahan->harga }}">{{ $bahan->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border p-2">
                        <input type="number" name="qty[]" min="1" class="form-control qty" required>
                    </td>
                    <td class="border p-2">
                        <input type="number" name="harga[]" step="0.01" class="form-control harga" required>
                    </td>
                    <td class="border p-2 subtotal">Rp 0</td>
                    <td class="border p-2">
                        <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" id="add-row" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Tambah Baris</button>

        <div class="text-right mb-6">
            <strong>Total: Rp <span id="grand-total">0</span></strong>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Pembelian
            </button>
            <a href="{{ route('pembelian.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
// Same JS as create.blade.php
let rowIndex = 1;
document.getElementById('add-row').addEventListener('click', function() {
    // ... same as pembelian/create JS
});

document.addEventListener('change', function(e) {
    // ... same calculation logic
});

function calculateTotal() {
    // ... same
}

// remove-row listeners
document.querySelectorAll('.remove-row').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('tr').remove();
        calculateTotal();
    });
});
</script>
@endsection

