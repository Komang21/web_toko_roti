<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Pembelian') }}
                </h2>
                <p class="text-gray-600 mt-1">
                    {{ method_exists($pembelians, 'total') ? $pembelians->total() : count($pembelians) }} pembelian
                    tercatat</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('pembelian.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl hover:from-indigo-600 hover:to-blue-700 transform hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>Pembelian Baru</a>
            </div>
        </div>
    </x-slot>

    <style>
        .count-up {
            font-size: clamp(1.1rem, 2.8vw + 0.5rem, 1.85rem);
            line-height: 1.15;
            white-space: nowrap;
        }

        /* FIX utama */
        .stat-number {
            display: flex;
            align-items: baseline;
            justify-content: flex-end;
            gap: 4px;
        }

        /* ini yang bikin angka stabil */
        .number {
            display: inline-block;
            min-width: 140px;
            /* tambah dikit biar rata semua */
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .rp-label {
            flex-shrink: 0;
            /* supaya Rp tidak ikut ketarik */
        }

        .stat-card {
            overflow: hidden;
            position: relative;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="bg-gradient-to-r from-emerald-400 to-teal-500 text-white p-6 rounded-3xl shadow-2xl mb-8 border-l-8 border-emerald-600">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Stats Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = [
                        [
                            'label' => 'Total Pembelian',
                            'value' => $pembelians->total(),
                            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                            'color' => 'from-indigo-500 to-blue-600',
                            'isRp' => false,
                        ],
                        [
                            'label' => 'Total Pengeluaran',
                            'value' => $pembelians->sum('total'),
                            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2',
                            'color' => 'from-emerald-500 to-teal-600',
                            'isRp' => true,
                        ],
                        [
                            'label' => 'Supplier Aktif',
                            'value' => $supplierAktif,
                            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857',
                            'color' => 'from-purple-500 to-violet-600',
                            'isRp' => false,
                        ],
                        [
                            'label' => 'Rata-rata',
                            'value' => $rataRata ?? 0,
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'from-amber-500 to-orange-600',
                            'isRp' => true,
                        ],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div
                        class="bg-gradient-to-br {{ $stat['color'] }} text-white p-6 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 h-[120px] flex items-center">

                        <div class="flex items-center justify-between w-full">

                            <!-- ICON -->
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $stat['icon'] }}"></path>
                                </svg>
                            </div>

                            <!-- TEXT -->
                            <div class="text-right">
                                <p class="text-sm opacity-90">{{ $stat['label'] }}</p>

                                <div class="text-2xl font-bold count-up">
                                    <span class="stat-number" data-target="{{ $stat['value'] }}"
                                        data-rp="{{ $stat['isRp'] ? 'true' : 'false' }}">
                                        @if ($stat['isRp'])
                                            <span class="rp-label">Rp</span>
                                        @endif
                                        <span class="number">0</span>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pembelian Terbaru Table --}}
            <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-4xl border border-white/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-9 h-9 mr-4 text-indigo-500 bg-indigo-100 p-2 rounded-2xl shadow-lg"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Pembelian Terbaru
                        </h3>
                        <div class="flex gap-3">
                            <a href="{{ route('pembelian.index', ['limit' => 'all']) }}"
                                class="px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 text-sm font-semibold rounded-2xl text-gray-700 hover:bg-gray-200 transition-all">Lihat
                                Semua</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-3xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0">
                                <tr>
                                    <th
                                        class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-12">
                                        #</th>
                                    <th
                                        class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Supplier</th>
                                    <th
                                        class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($limit === 'all' ? $pembelians : $pembeliansTerbaru as $index => $pembelian)
                                    @php
                                        $no = $limit === 'all' ? $pembelians->firstItem() + $index : $index + 1;
                                    @endphp
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-indigo-50 transition-all duration-200 group">
                                        <td class="px-8 py-6 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $no }}</td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-sm mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $pembelian->tgl_pembelian->format('d M Y') }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $pembelian->tgl_pembelian->format('H:i') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span
                                                class="px-4 py-2 bg-indigo-100 text-indigo-800 text-sm font-bold rounded-2xl">{{ $pembelian->supplier->nama ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <p class="text-2xl font-black text-emerald-600">Rp
                                                {{ number_format($pembelian->total, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            @if($pembelian->status_pembayaran === 'lunas')
                                                <span class="inline-flex px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-bold rounded-2xl shadow-md">Lunas</span>
                                            @else
                                                <span class="inline-flex px-4 py-2 bg-red-100 text-red-800 text-sm font-bold rounded-2xl shadow-md">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="flex gap-2 justify-end">
                                                <a href="{{ route('pembelian.show', $pembelian) }}"
                                                    class="p-3 bg-blue-100 hover:bg-blue-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 9.751 5.962 9.751 7.458 12c1.296 2.507 1.296 2.517 7.458 2.517 6.468 0 7.458">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('pembelian.edit', $pembelian) }}"
                                                    class="p-3 bg-yellow-100 hover:bg-yellow-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-yellow-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 002 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('pembelian.destroy', $pembelian) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin hapus pembelian #{{ $pembelian->id }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-3 bg-red-100 hover:bg-red-200 rounded-2xl transition-all group-hover:scale-110">
                                                        <svg class="w-5 h-5 text-red-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
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
                                                <div
                                                    class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-8 shadow-xl">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada pembelian
                                                </h3>
                                                <p class="text-xl text-gray-600 mb-10 leading-relaxed">Mulai pembelian
                                                    bahan baku pertama untuk mengisi stok toko roti Anda</p>
                                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                                    <a href="{{ route('pembelian.create') }}"
                                                        class="px-12 py-4 bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:from-indigo-600 hover:to-blue-700 transform hover:-translate-y-2 transition-all duration-500">
                                                        <svg class="w-6 h-6 inline mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                        Buat Pembelian
                                                    </a>
                                                    <a href="{{ route('supplier.index') }}"
                                                        class="px-12 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl hover:from-gray-600 hover:to-gray-700 transform hover:-translate-y-1 transition-all duration-300">
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
                </div>
            </div>

            <div class="mt-16 flex justify-center">
                {{ $pembelians->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.stat-number').forEach(function(wrapper) {
                const numberEl = wrapper.querySelector('.number');
                const target = parseInt(wrapper.dataset.target);
                const isRp = wrapper.dataset.rp === 'true';

                let current = 0;
                const duration = 2000;
                const stepTime = 20;
                const steps = duration / stepTime;
                const increment = target / steps;

                const timer = setInterval(() => {
                    current += increment;

                    if (current >= target) {
                        numberEl.textContent = new Intl.NumberFormat('id-ID').format(target);
                        clearInterval(timer);
                    } else {
                        numberEl.textContent = new Intl.NumberFormat('id-ID').format(Math.floor(
                            current));
                    }
                }, stepTime);
            });
        });
    </script>
</x-app-layout>
