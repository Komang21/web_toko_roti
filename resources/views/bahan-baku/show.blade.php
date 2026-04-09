<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Bahan Baku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Nama</h3>
                        <p class="text-gray-700">{{ $bahanBaku->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Stok</h3>
                        <p class="text-gray-700">{{ $bahanBaku->stok }} unit</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Harga</h3>
                        <p class="text-gray-700">Rp {{ number_format($bahanBaku->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Supplier</h3>
                        <p class="text-gray-700">{{ $bahanBaku->supplier->nama ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Pembelian</h3>
                        @if($bahanBaku->pembelianDetails->count() > 0)
                            <ul class="mt-2">
                                @foreach($bahanBaku->pembelianDetails as $detail)
                                    <li>{{ $detail->pembelian->tgl_pembelian }} - {{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Belum ada pembelian</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('bahan-baku.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

