<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-4xl mx-auto">
                <h2 class="text-2xl font-bold mb-6">Pembelian #{{ $pembelian->id }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Informasi Pembelian</h3>
                        <p><strong>Tanggal:</strong> {{ $pembelian->tgl_pembelian->format('d/m/Y') }}</p>
                        <p><strong>Supplier:</strong> {{ $pembelian->supplier->nama }}</p>
                        <p><strong>Total:</strong> Rp {{ number_format($pembelian->total, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-4">Detail Bahan Baku</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Bahan</th>
                                <th class="border px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Qty</th>
                                <th class="border px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga Unit</th>
                                <th class="border px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelian->details as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-6 py-4">{{ $detail->bahan->nama }}</td>
                                    <td class="border px-6 py-4">{{ $detail->qty }}</td>
                                    <td class="border px-6 py-4">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="border px-6 py-4 text-right font-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-6 py-8 text-center text-gray-500">Tidak ada detail pembelian</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="border px-6 py-4 text-right font-bold">Grand Total:</td>
                                <td class="border px-6 py-4 text-right font-bold text-lg">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('pembelian.edit', $pembelian) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Edit
                    </a>
                    <a href="{{ route('pembelian.index', ['limit' => 'all']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all">
                        ← Kembali ke Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

