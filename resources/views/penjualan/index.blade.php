<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Penjualan') }}
                </h2>
                <p class="text-gray-600 mt-1">{{ $penjualans->total() }} transaksi penjualan</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('penjualan.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl hover:from-rose-600 hover:to-pink-700 transform hover:-translate-y-0.5 transition-all duration-300 whitespace-nowrap">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Transaksi Baru
                </a>
            </div>
        </div>
        <style>
            .count-up {
                font-size: clamp(2rem, 5vw, 4rem);
                line-height: 1;
            }
            .number {
                display: inline-block;
                min-width: 160px;
                text-align: right;
                font-variant-numeric: tabular-nums;
            }
            .tabular-nums {
                font-variant-numeric: tabular-nums;
            }
            .stat-card {
                position: relative;
                overflow: hidden;
            }
            .rp-prefix, .text-value, .number {
                text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div
                    class="bg-gradient-to-r from-emerald-400 to-green-500 text-white p-6 rounded-3xl shadow-2xl mb-8 border-l-8 border-emerald-600 animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Berhasil!</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Modern Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach($stats as $stat)
                    <div class="group bg-white/80 backdrop-blur-xl rounded-3xl p-6 shadow-lg border border-white/50 hover:shadow-2xl hover:-translate-y-2 hover:bg-white/95 transition-all duration-500 overflow-hidden stat-card relative">
                        {{-- Gradient background effect --}}
                        <div class="absolute inset-0 bg-gradient-to-br {{ $stat['color'] }} opacity-5 group-hover:opacity-10 transition-opacity duration-500"></div>
                        
                        <div class="relative flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 rounded-2xl bg-gradient-to-br {{ $stat['color'] }} shadow-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-end">
                                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2 group-hover:text-gray-700 transition-colors">{{ $stat['label'] }}</p>
                                
                                <div class="count-up" data-target="{{ $stat['value'] }}" data-type="{{ $stat['type'] }}">
                                    @if($stat['type'] === 'money')
                                        <span class="rp-prefix text-xl font-semibold text-gray-700">Rp</span>
                                    @endif
                                    <span class="number font-black text-3xl lg:text-4xl text-gray-900 leading-tight min-w-[160px] tabular-nums text-right"></span>
                                    @if($stat['type'] === 'text')
                                        <span class="text-value text-base font-semibold text-gray-800">{{ $stat['value'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>



        {{-- Recent Sales Table --}}
        <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-4xl border border-white/50 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                        <svg class="w-9 h-9 mr-4 text-rose-500 bg-rose-100 p-2 rounded-2xl shadow-lg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Transaksi Terbaru
                    </h3>
                    <div class="flex gap-3">
                        <span
                            class="px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 text-sm font-semibold rounded-2xl text-gray-700">Lihat
                            Semua</span>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Item</th>
                                <th
                                    class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-8 py-6 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($penjualans as $penjualan)
                                <tr
                                    class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-emerald-50 transition-all duration-200 group">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $penjualan->tgl_jual->format('d M Y') }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $penjualan->tgl_jual->format('H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-right">
                                            <p class="text-2xl font-black text-emerald-600">Rp
                                                {{ number_format($penjualan->total, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">{{ $penjualan->details->count() }}
                                                item</p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($penjualan->details->take(3) as $detail)
                                                <span
                                                    class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">
                                                    {{ $detail->produk->nama ?? 'Produk Tidak Ada' }}
                                                </span>
                                            @endforeach
                                            @if ($penjualan->details->count() > 3)
                                                <span
                                                    class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">+{{ $penjualan->details->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <span
                                            class="inline-flex px-4 py-2 bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl shadow-md">Lunas</span>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <div class="flex gap-2 justify-end">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('penjualan.show', $penjualan) }}"
                                                class="p-3 bg-blue-100 hover:bg-blue-200 rounded-2xl transition-all group-hover:scale-110">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('penjualan.edit', $penjualan) }}"
                                                class="p-3 bg-yellow-100 hover:bg-yellow-200 rounded-2xl transition-all group-hover:scale-110">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('penjualan.destroy', $penjualan) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Yakin hapus penjualan {{ $penjualan->id }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-3 bg-red-100 hover:bg-red-200 rounded-2xl transition-all group-hover:scale-110">
                                                    <svg class="w-5 h-5 text-red-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="max-w-md mx-auto">
                                            <div
                                                class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-8 shadow-xl">
                                                <svg class="w-12 h-12 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada penjualan
                                            </h3>
                                            <p class="text-xl text-gray-600 mb-10 leading-relaxed">Mulai transaksi
                                                penjualan pertama untuk melihat data di sini</p>
                                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                                <a href="{{ route('penjualan.create') }}"
                                                    class="px-12 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl hover:from-rose-600 hover:to-pink-700 transform hover:-translate-y-2 transition-all duration-500">
                                                    <svg class="w-6 h-6 inline mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                    Buat Penjualan
                                                </a>
                                                <a href="{{ route('produk.index') }}"
                                                    class="px-12 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl hover:from-gray-600 hover:to-gray-700 transform hover:-translate-y-1 transition-all duration-300">
                                                    Cek Stok Produk
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
            {{ $penjualans->appends(request()->query())->links() }}
        </div>
    </div>
    <script>
        function animateStats() {
            document.querySelectorAll('.count-up').forEach(el => {
                const target = parseFloat(el.dataset.target) || 0;
                const type = el.dataset.type || 'number';
                const numberEl = el.querySelector('.number');
                const textEl = el.querySelector('.text-value');
                
                if (type === 'text' || !numberEl) {
                    if (textEl) textEl.style.opacity = '1';
                    return;
                }
                
                let current = 0;
                const duration = 2500;
                const increment = target / (duration / 16);
                
                const update = () => {
                    current += increment;
                    if (current >= target) {
                        numberEl.textContent = new Intl.NumberFormat('id-ID', { 
                            style: type === 'money' ? 'currency' : 'decimal',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: type === 'money' ? 0 : 2 
                        }).format(target);
                    } else {
                        numberEl.textContent = new Intl.NumberFormat('id-ID').format(Math.floor(current));
                        requestAnimationFrame(update);
                    }
                };
                requestAnimationFrame(update);
            });
        }
        document.addEventListener('DOMContentLoaded', animateStats);
    </script>
</x-app-layout>
