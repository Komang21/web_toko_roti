<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Toko Roti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Sistem Rantai Pasok Toko Roti</h2>
                    <p class="mb-8 text-lg">Gunakan menu navbar di atas untuk mengakses semua modul.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@php
    $supplierCount = \DB::table('suppliers')->count();
    $produkCount = \DB::table('produks')->count();
    $pembelianCount = \DB::table('pembelians')->count();
    $bahanCount = 0;
    $penjualanCount = \DB::table('penjualans')->count();
@endphp
                        
                        <div class="bg-blue-100 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <h3 class="text-2xl font-bold text-blue-800 mb-2">Supplier</h3>
                            <p class="text-4xl font-black text-blue-600 mb-4">{{ number_format($supplierCount) }}</p>
                            <a href="{{ route('supplier.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Kelola Supplier →
                            </a>
                        </div>
                        
                        <div class="bg-green-100 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <h3 class="text-2xl font-bold text-green-800 mb-2">Produk</h3>
                            <p class="text-4xl font-black text-green-600 mb-4">{{ number_format($produkCount) }}</p>
                            <a href="{{ route('produk.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Kelola Produk →
                            </a>
                        </div>
                        
                        <div class="bg-purple-100 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <h3 class="text-2xl font-bold text-purple-800 mb-2">Pembelian</h3>
                            <p class="text-4xl font-black text-purple-600 mb-4">{{ number_format($pembelianCount) }}</p>
                            <a href="{{ route('pembelian.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Kelola Pembelian →
                            </a>
                        </div>
                        
                        <div class="bg-indigo-100 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <h3 class="text-2xl font-bold text-indigo-800 mb-2">Bahan Baku</h3>
                            <p class="text-4xl font-black text-indigo-600 mb-4">{{ number_format($bahanCount) }}</p>
                            <a href="{{ route('bahan-baku.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Kelola Bahan Baku →
                            </a>
                        </div>
                        
                        <div class="bg-orange-100 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <h3 class="text-2xl font-bold text-orange-800 mb-2">Penjualan</h3>
                            <p class="text-4xl font-black text-orange-600 mb-4">{{ number_format($penjualanCount) }}</p>
                            <a href="{{ route('penjualan.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Kelola Penjualan →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

