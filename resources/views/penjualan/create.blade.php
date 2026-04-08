@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Buat Penjualan Baru</h2>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
            <input type="date" name="tgl_jual" value="{{ old('tgl_jual') }}" class="shadow appearance-none border rounded w-full py-2 px-3 @error('tgl_jual') border-red-500 @enderror" required>
            @error('tgl_jual')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <h3 class="text-lg font-semibold mb-4">Detail Produk</h3>
        <table id="details-table" class="w-full border-collapse border mb-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Produk</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Harga Jual</th>
                    <th class="border p-2">Subtotal</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="details-tbody">
                <tr class="detail-row">
                    <td class="border p-2">
                        <select name="produk_id[]" class="form-control" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}" data-stok="{{ $produk->stok }}">{{ $produk->nama }} (Stok: {{ $produk->stok }})</option>
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
                Simpan Penjualan
            </button>
            <a href="{{ route('penjualan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
let rowIndex = 1;
document.getElementById('add-row').addEventListener('click', function() {
    const tbody = document.getElementById('details-tbody');
    const newRow = tbody.insertRow();
    newRow.className = 'detail-row';
    newRow.innerHTML = `
        <td class="border p-2">
            <select name="produk_id[]" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}" data-stok="{{ $produk->stok }}">{{ $produk->nama }} (Stok: {{ $produk->stok }})</option>
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
    `;
    rowIndex++;
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
        const row = e.target.closest('tr');
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const harga = parseFloat(row.querySelector('.harga').value) || 0;
        row.querySelector('.subtotal').textContent = 'Rp ' + (qty * harga).toLocaleString('id-ID');
        calculateTotal();
    } else if (e.target.classList.contains('produk_id')) {
        const harga = e.target.options[e.target.selectedIndex].dataset.harga;
        const stok = parseInt(e.target.options[e.target.selectedIndex].dataset.stok);
        e.target.closest('tr').querySelector('.harga').value = harga || '';
        // Warn if qty > stok
    }
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(sub => {
        const val = sub.textContent.replace(/[^0-9]/g, '');
        total += parseFloat(val) || 0;
    });
    document.getElementById('grand-total').textContent = total.toLocaleString('id-ID');
}

document.querySelectorAll('.remove-row').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('tr').remove();
        calculateTotal();
    });
});
</script>
@endsection

