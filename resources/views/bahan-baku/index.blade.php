<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Bahan Baku') }}
                </h2>
                <p class="text-gray-600 mt-1">{{ $bahanBakus->total() }} bahan tersedia</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('bahan-baku.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl hover:from-amber-600 hover:to-orange-700 transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Bahan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-gradient-to-r from-emerald-400 to-teal-500 text-white p-4 rounded-2xl shadow-lg mb-8 border-l-4 border-emerald-400 animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Stats Row --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-amber-100 text-sm font-medium">Total Bahan</p>
                            <p class="text-3xl font-bold mt-1">{{ $bahanBakus->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-emerald-100 text-sm font-medium">Total Stok</p>
                            <p class="text-3xl font-bold mt-1">{{ $bahanBakus->sum('stok') }} kg</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-indigo-100 text-sm font-medium">Supplier Aktif</p>
{{ \App\Models\admin\BahanBaku::whereHas('supplier')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Advanced Filter --}}
            <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-3xl p-8 mb-8 border border-white/50">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter Bahan Baku
                </h3>
                <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bahan</label>
                        <input type="text" name="nama" value="{{ request('nama') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-200 focus:border-amber-400 transition-all shadow-sm" placeholder="Tepung, gula...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier</label>
                        <select name="supplier_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-200 focus:border-emerald-400 transition-all shadow-sm">
                            <option value="">Semua Supplier</option>
                            @foreach(App\Models\admin\Supplier::all() as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Minimum</label>
                        <input type="number" name="stok_min" value="{{ request('stok_min') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-400 transition-all shadow-sm" placeholder="0">
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-amber-600 hover:to-orange-700 transition-all duration-200">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('bahan-baku.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-200">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Bahan Baku Cards --}}
            <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-4xl border border-white/50 overflow-hidden mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-9 h-9 mr-4 text-amber-500 bg-amber-100 p-2 rounded-2xl shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Daftar Bahan Baku
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
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Bahan</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Satuan</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Stok</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Supplier</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($bahanBakus as $index => $bahanBaku)
                                    @php $no = $bahanBakus->firstItem() + $index; @endphp
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-amber-50 transition-all duration-200 group">
                                        <td class="px-8 py-6 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $no }}</td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 {{ $bahanBaku->stok > 50 ? 'bg-emerald-100' : ($bahanBaku->stok > 20 ? 'bg-amber-100' : 'bg-red-100') }} rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                                    <svg class="w-6 h-6 {{ $bahanBaku->stok > 50 ? 'text-emerald-600' : ($bahanBaku->stok > 20 ? 'text-amber-600' : 'text-red-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900 text-lg">{{ $bahanBaku->nama }}</p>
                                                    <p class="text-sm text-gray-500">Rp {{ number_format($bahanBaku->harga, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span class="inline-flex px-4 py-2 bg-gray-100 text-gray-800 text-sm font-bold rounded-2xl shadow-sm">{{ $bahanBaku->satuan ?? 'Kg' }}</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="text-right">
                                                <p class="text-2xl font-black {{ $bahanBaku->stok > 50 ? 'text-emerald-600' : ($bahanBaku->stok > 20 ? 'text-amber-600' : 'text-red-600') }}">{{ $bahanBaku->stok }} {{ $bahanBaku->satuan ?? 'kg' }}</p>
                                                <div class="w-24 bg-gray-200 rounded-full h-2 mt-2 mx-auto">
                                                    <div class="bg-gradient-to-r {{ $bahanBaku->stok > 50 ? 'from-emerald-400 to-emerald-500' : ($bahanBaku->stok > 20 ? 'from-amber-400 to-orange-500' : 'from-red-400 to-rose-500') }} h-2 rounded-full transition-all" style="width: {{ min(100, ($bahanBaku->stok / 100) * 100) }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full">{{ $bahanBaku->supplier->nama ?? 'Independen' }}</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="flex gap-2 justify-end">
                                                <a href="{{ route('bahan-baku.show', $bahanBaku) }}" class="p-3 bg-blue-100 hover:bg-blue-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 9.751 5.962 9.751 7.458 12c1.296 2.507 1.296 2.517 7.458 2.517 6.468 0 7.458"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('bahan-baku.edit', $bahanBaku) }}" class="p-3 bg-yellow-100 hover:bg-yellow-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('bahan-baku.destroy', $bahanBaku) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus bahan baku {{ $bahanBaku->nama }}?')">
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
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada bahan baku</h3>
                                                <p class="text-xl text-gray-600 mb-10 leading-relaxed">Tambahkan bahan baku pertama untuk memulai proses produksi roti Anda</p>
                                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                                    <a href="{{ route('bahan-baku.create') }}" class="px-12 py-4 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:from-amber-600 hover:to-orange-700 transform hover:-translate-y-2 transition-all duration-500">
                                                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                        Tambah Bahan
                                                    </a>
                                                    <a href="{{ route('supplier.index') }}" class="px-12 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl hover:from-gray-600 hover:to-gray-700 transform hover:-translate-y-1 transition-all duration-300">
                                                        Lihat Supplier
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

            <div class="mt-20 flex justify-center">
                {{ $bahanBakus->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>
</x-app-layout>
