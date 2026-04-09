<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Nama</h3>
                        <p class="text-gray-700">{{ $produk->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Harga Jual</h3>
                        <p class="text-gray-700">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Stok</h3>
                        <p class="text-gray-700">{{ $produk->stok }} unit</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Penjualan</h3>
                        @if($produk->penjualanDetails->count() > 0)
                            <ul class="mt-2">
                                @foreach($produk->penjualanDetails as $detail)
                                    <li>{{ $detail->penjualan->tgl_jual }} - {{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Belum ada penjualan</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('produk.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

