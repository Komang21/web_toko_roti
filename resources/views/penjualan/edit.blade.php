<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-3xl mx-auto">
                <h2 class="text-2xl font-semibold mb-6">Edit Penjualan #{{ $penjualan->id }}</h2>

                <form action="{{ route('penjualan.update', $penjualan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Jual</label>
                        <input type="date" name="tgl_jual" value="{{ old('tgl_jual', $penjualan->tgl_jual?->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('tgl_jual') border-red-500 @enderror" required>
                        @error('tgl_jual')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status Pembayaran</label>
                        <select name="status_pembayaran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('status_pembayaran') border-red-500 @enderror" required>
                            <option value="lunas" {{ old('status_pembayaran', $penjualan->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="belum_lunas" {{ old('status_pembayaran', $penjualan->status_pembayaran) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                        @error('status_pembayaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="produk-list">
                        @foreach($penjualan->details as $index => $detail)
                            <div class="produk-row mb-4 p-4 border rounded flex flex-wrap gap-4 items-end">
                                <div class="flex-1">
                                    <label>Produk</label>
                            <select name="produk_id[]" class="produk-select shadow border rounded w-full py-2 px-3" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}" data-stok="{{ $produk->stok }}" {{ $detail->produk_id == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama }} (Stok: {{ $produk->stok }})
                                    </option>
                                @endforeach
                            </select>
                                </div>
                                <div class="w-24">
                                    <label>Qty</label>
                                    <input type="number" name="qty[]" value="{{ $detail->qty }}" min="1" class="qty shadow border rounded w-full py-2 px-3" required>
                                </div>
                                <div class="w-24">
                                    <label>Harga</label>
                                    <input type="number" name="harga[]" value="{{ $detail->harga }}" step="0.01" class="harga shadow border rounded w-full py-2 px-3" required>
                                </div>
                                <div class="w-28">
                                    <label>Subtotal</label>
                                    <input type="number" name="subtotal[]" value="{{ $detail->subtotal }}" class="subtotal shadow border rounded w-full py-2 px-3 bg-gray-100" readonly>
                                </div>
                                <button type="button" class="remove-row bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-produk" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4">
                        + Tambah Produk
                    </button>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-lg font-bold">Total: Rp <span id="grand-total">0</span></label>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                        <a href="{{ route('penjualan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rowIndex = {{ count($penjualan->details ?? []) }};

            function updateSubtotal(row) {
                const qty = row.querySelector('.qty').value;
                const harga = row.querySelector('.harga').value;
                const subtotal = row.querySelector('.subtotal');
                subtotal.value = (qty * harga).toLocaleString('id-ID', {minimumFractionDigits: 0});
                updateGrandTotal();
            }

            function updateGrandTotal() {
                const subtotals = document.querySelectorAll('.subtotal');
                let total = 0;
                subtotals.forEach(sub => total += parseFloat(sub.value.replace(/,/g, '') || 0));
                document.getElementById('grand-total').textContent = total.toLocaleString('id-ID');
            }

            // Event listeners
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
                    updateSubtotal(e.target.closest('.produk-row'));
                }
            });

            document.getElementById('add-produk')?.addEventListener('click', function() {
                const container = document.getElementById('produk-list');
                const row = document.createElement('div');
                row.className = 'produk-row mb-4 p-4 border rounded flex flex-wrap gap-4 items-end';
                row.innerHTML = `
                    <div class="flex-1">
                        <label>Produk</label>
                        <select name="produk_id[]" class="produk-select shadow border rounded w-full py-2 px-3" required>
                            <option value="">Pilih Produk</option>
                            ${document.querySelector('.produk-select').innerHTML}
                        </select>
                    </div>
                    <div class="w-24">
                        <label>Qty</label>
                        <input type="number" name="qty[]" min="1" class="qty shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div class="w-24">
                        <label>Harga</label>
                        <input type="number" name="harga[]" step="0.01" class="harga shadow border rounded w-full py-2 px-3" required>
                    </div>
                    <div class="w-28">
                        <label>Subtotal</label>
                        <input type="number" name="subtotal[]" class="subtotal shadow border rounded w-full py-2 px-3 bg-gray-100" readonly>
                    </div>
                    <button type="button" class="remove-row bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Hapus
                    </button>
                `;
                container.appendChild(row);
                row.querySelector('.qty').addEventListener('input', function() { updateSubtotal(row); });
                row.querySelector('.harga').addEventListener('input', function() { updateSubtotal(row); });
                row.querySelector('.remove-row').addEventListener('click', function() { row.remove(); updateGrandTotal(); });
                row.querySelector('.produk-select').addEventListener('change', function() {
                    const harga = this.options[this.selectedIndex].dataset.harga;
                    if (harga) row.querySelector('.harga').value = harga;
                });
                rowIndex++;
            });

            // Remove row
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.produk-row').remove();
                    updateGrandTotal();
                }
            });

            updateGrandTotal();
        });
    </script>
</x-app-layout>

