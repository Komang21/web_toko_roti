<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Tanggal Jual</h3>
                        <p class="text-gray-700">{{ $penjualan->tgl_jual?->format('d-m-Y') }}</p>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-green-600">Total: Rp {{ number_format($penjualan->total, 0, ',', '.') }}</h3>
                    </div>
                    <h3 class="text-lg font-bold mb-4">Detail Items:</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Produk</th>
                                <th class="px-4 py-2 text-left">Qty</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $detail)
                                <tr>
                                    <td class="border px-4 py-2">{{ $detail->produk->nama }}</td>
                                    <td class="border px-4 py-2">{{ $detail->qty }}</td>
                                    <td class="border px-4 py-2">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">
                        <a href="{{ route('penjualan.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
