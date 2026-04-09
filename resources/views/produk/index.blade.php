<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Produk') }}
                </h2>
                <p class="text-gray-600 mt-1">{{ $produks->total() }} produk tersedia</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('produk.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-emerald-700 transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 text-white p-4 rounded-2xl shadow-lg mb-8 animate-pulse">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 .34.07.68.1 1 .1s.66-.03 1-.1c5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-blue-100">Total Produk</p>
                            <p class="text-3xl font-bold">{{ $produks->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-green-100">Stok Tersedia</p>
                            <p class="text-3xl font-bold">{{ $produks->sum('stok') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-red-600 text-white p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-orange-100">Low Stock Alert</p>
                            <p class="text-3xl font-bold">{{ $produks->where('stok', '<', 10)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-3xl p-6 mb-8 border border-white/50">
                <div class="flex flex-col lg:flex-row gap-4 items-center">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk berdasarkan nama..." class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-emerald-200 focus:border-emerald-400 transition-all duration-300 shadow-inner bg-white/50">
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('produk.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-2xl transition-all duration-200">Reset</a>
                        <button type="submit" form="search-form" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-teal-700 transform hover:-translate-y-0.5 transition-all duration-200">
                            Cari Produk
                        </button>
                    </div>
                </div>
            </div>

            {{-- Products Grid --}}
<div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-4xl border border-white/50 overflow-hidden mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-9 h-9 mr-4 text-emerald-500 bg-emerald-100 p-2 rounded-2xl shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Daftar Produk
                        </h3>
                        <div class="flex gap-3">
                            <span class="px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 text-sm font-semibold rounded-2xl text-gray-700">Lihat Semua</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-3xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-12">#</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Harga Jual</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Stok</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($produks as $index => $produk)
                                    @php $no = $produks->firstItem() + $index; @endphp
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-emerald-50 transition-all duration-200 group">
                                        <td class="px-8 py-6 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $no }}</td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 {{ $produk->stok > 20 ? 'bg-emerald-100' : ($produk->stok > 5 ? 'bg-amber-100' : 'bg-red-100') }} rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                                    <svg class="w-6 h-6 {{ $produk->stok > 20 ? 'text-emerald-600' : ($produk->stok > 5 ? 'text-amber-600' : 'text-red-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900 text-lg">{{ $produk->nama }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full uppercase">{{ $produk->kategori ?? 'Umum' }}</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div>
                                                <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <span class="inline-flex px-4 py-2 {{ $produk->stok > 20 ? 'bg-emerald-100 text-emerald-800' : ($produk->stok > 5 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }} text-sm font-bold rounded-2xl shadow-md">
                                                {{ $produk->stok }} unit
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="flex gap-2 justify-end">
                                                <a href="{{ route('produk.show', $produk) }}" class="p-3 bg-blue-100 hover:bg-blue-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 9.751 5.962 9.751 7.458 12c1.296 2.507 1.296 2.517 7.458 2.517 6.468 0 7.458"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('produk.edit', $produk) }}" class="p-3 bg-yellow-100 hover:bg-yellow-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk {{ $produk->nama }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-3 bg-red-100 hover:bg-red-200 rounded-2xl transition-all group-hover:scale-110">
                                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-20 text-center">
                                            <div class="max-w-md mx-auto">
                                                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-8 shadow-xl">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada produk</h3>
                                                <p class="text-xl text-gray-600 mb-10 leading-relaxed">Tambahkan produk roti pertama untuk memulai penjualan toko roti Anda yang sukses</p>
                                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                                    <a href="{{ route('produk.create') }}" class="px-12 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:from-emerald-600 hover:to-teal-700 transform hover:-translate-y-2 transition-all duration-500">
                                                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                        Tambah Produk
                                                    </a>
                                                    <a href="{{ route('penjualan.index') }}" class="px-12 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl hover:from-gray-600 hover:to-gray-700 transform hover:-translate-y-1 transition-all duration-300">
                                                        Mulai Jual
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-16 flex justify-center">
                {{ $produks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
