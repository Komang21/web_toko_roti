<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-3xl mx-auto">
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
                        <input type="date" name="tgl_pembelian" value="{{ old('tgl_pembelian', $pembelian->tgl_pembelian?->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 @error('tgl_pembelian') border-red-500 @enderror" required>
                        @error('tgl_pembelian')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Detail Bahan</h3>
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
                            @foreach($pembelian->details as $detail)
                                <tr class="detail-row">
                                    <td class="border p-2">
                                        <select name="bahan_id[]" class="bahan-select form-control" required>
                                            <option value="">Pilih Bahan</option>
                                            @foreach ($bahanBakus as $bahan)
                                                <option value="{{ $bahan->id }}" data-harga="{{ $bahan->harga }}" {{ $detail->bahan_id == $bahan->id ? 'selected' : '' }}>{{ $bahan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border p-2">
                                        <input type="number" name="qty[]" value="{{ $detail->qty }}" min="1" class="form-control qty" required>
                                    </td>
                                    <td class="border p-2">
                                        <input type="number" name="harga[]" value="{{ $detail->harga }}" step="0.01" class="form-control harga" required>
                                    </td>
                                    <td class="border p-2 subtotal">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    <td class="border p-2">
                                        <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                            @if($pembelian->details->isEmpty())
                                <tr class="detail-row">
                                    <td class="border p-2">
                                        <select name="bahan_id[]" class="bahan-select form-control" required>
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
                            @endif
                        </tbody>
                    </table>
                    <button type="button" id="add-row" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Tambah Baris</button>

                    <div class="text-right mb-6">
                        <strong>Total: Rp <span id="grand-total">{{ $pembelian->total }}</span></strong>
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
        </div>
    </div>

    <script>
        let rowIndex = {{ $pembelian->details->count() }};
        function updateSubtotal(row) {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const harga = parseFloat(row.querySelector('.harga').value) || 0;
            row.querySelector('.subtotal').textContent = 'Rp ' + (qty * harga).toLocaleString('id-ID');
            calculateTotal();
        }
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(sub => {
                const val = sub.textContent.replace(/[^0-9]/g, '');
                total += parseFloat(val) || 0;
            });
            document.getElementById('grand-total').textContent = total.toLocaleString('id-ID');
        }
        document.addEventListener('change', function(e) {
            if (e.target.matches('.qty, .harga')) {
                updateSubtotal(e.target.closest('tr'));
            } else if (e.target.matches('.bahan-select')) {
                const harga = e.target.options[e.target.selectedIndex].dataset.harga;
                e.target.closest('tr').querySelector('.harga').value = harga || '';
            }
        });
        document.getElementById('add-row')?.addEventListener('click', function() {
            const tbody = document.getElementById('details-tbody');
            const newRow = tbody.insertRow();
            newRow.className = 'detail-row';
            newRow.innerHTML = `
                <td class="border p-2">
                    <select name="bahan_id[]" class="bahan-select form-control" required>
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
                </td>`;
            newRow.querySelector('.bahan-select').addEventListener('change', function() {
                const harga = this.options[this.selectedIndex].dataset.harga;
                this.closest('tr').querySelector('.harga').value = harga || '';
            });
            newRow.querySelector('.qty').addEventListener('input', () => updateSubtotal(newRow));
            newRow.querySelector('.harga').addEventListener('input', () => updateSubtotal(newRow));
            newRow.querySelector('.remove-row').addEventListener('click', () => {
                newRow.remove();
                calculateTotal();
            });
        });
        document.querySelectorAll('.remove-row').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal();
            });
        });
        calculateTotal();
    </script>
</x-app-layout>

