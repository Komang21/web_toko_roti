<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Pembelian') }}
                </h2>
                <p class="text-gray-600 mt-1">{{ $pembelians->total() }} pembelian tercatat</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('pembelian.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl hover:from-indigo-600 hover:to-blue-700 transform hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Pembelian Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-gradient-to-r from-emerald-400 to-teal-500 text-white p-6 rounded-3xl shadow-2xl mb-8 border-l-8 border-emerald-600">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Stats Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-indigo-500 to-blue-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-4 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="opacity-90 text-sm font-medium">Total Pembelian</p>
                            <p class="text-4xl font-black">{{ $pembelians->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-4 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="opacity-90 text-sm font-medium">Total Pengeluaran</p>
                            <p class="text-4xl font-black">Rp {{ number_format($pembelians->sum('total'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-violet-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-4 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.128 0M13.407 15.672a5.002 5.001 0 0111.708 0"></path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="opacity-90 text-sm font-medium">Supplier Aktif</p>
                            <p class="text-4xl font-black">{{ \App\Models\admin\Pembelian::with('supplier')->distinct('supplier_id')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-4 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="opacity-90 text-sm font-medium">Rata-rata per Pembelian</p>
                            <p class="text-4xl font-black">Rp {{ $pembelians->count() > 0 ? number_format($pembelians->avg('total'), 0, ',', '.') : '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Purchases --}}
            <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-4xl border border-white/50 overflow-hidden mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-10 h-10 mr-4 bg-indigo-100 p-3 rounded-3xl shadow-lg text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Pembelian Terbaru
                        </h3>
                        <a href="{{ route('pembelian.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua →</a>
                    </div>

                    <div class="overflow-x-auto rounded-3xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-12">#</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Beli</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Supplier</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Total Bayar</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($pembelians as $index => $pembelian)
                                    @php $no = $pembelians->firstItem() + $index; @endphp
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-indigo-50 transition-all duration-200 group">
                                        <td class="px-8 py-6 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $no }}</td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $pembelian->tgl_pembelian->format('d M Y') }}</p>
                                                    <p class="text-sm text-gray-500">{{ $pembelian->tgl_pembelian->format('H:i') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span class="px-4 py-2 bg-indigo-100 text-indigo-800 text-sm font-bold rounded-2xl">{{ $pembelian->supplier->nama ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <span class="inline-flex px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-bold rounded-2xl shadow-md">Lunas</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="flex gap-2 justify-end">
                                                <a href="{{ route('pembelian.show', $pembelian) }}" class="p-3 bg-blue-100 hover:bg-blue-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 9.751 5.962 9.751 7.458 12c1.296 2.507 1.296 2.517 7.458 2.517 6.468 0 7.458"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('pembelian.edit', $pembelian) }}" class="p-3 bg-yellow-100 hover:bg-yellow-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pembelian #{{ $pembelian->id }}?')">
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
                                                <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada pembelian</h3>
                                                <p class="text-xl text-gray-600 mb-10 leading-relaxed">Mulai pembelian bahan baku pertama untuk mengisi stok toko roti Anda</p>
                                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                                    <a href="{{ route('pembelian.create') }}" class="px-12 py-4 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:from-indigo-600 hover:to-blue-700 transform hover:-translate-y-2 transition-all duration-500">
                                                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                        Buat Pembelian
                                                    </a>
                                                    <a href="{{ route('supplier.index') }}" class="px-12 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl hover:from-gray-600 hover:to-gray-700 transform hover:-translate-y-1 transition-all duration-300">
                                                        Pilih Supplier
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-16 flex justify-center">
                        {{ $pembelians->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
