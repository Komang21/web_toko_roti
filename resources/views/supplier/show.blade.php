<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Nama</h3>
                        <p class="text-gray-700">{{ $supplier->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Alamat</h3>
                        <p class="text-gray-700">{{ $supplier->alamat }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold">Telepon</h3>
                        <p class="text-gray-700">{{ $supplier->telp ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Pembelian</h3>
                        @if($supplier->pembelians->count() > 0)
                            <ul class="mt-2">
                                @foreach($supplier->pembelians as $pembelian)
                                    <li>{{ $pembelian->tgl_pembelian }} - Rp {{ number_format($pembelian->total, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Belum ada pembelian</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('supplier.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

