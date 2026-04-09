<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistem Rantai Pasok Toko Roti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Baris Kartu KPI (Grid 4 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Kartu 1: Total Produk -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Total Produk</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $totalProduk }}</div>
                            <div class="text-xs text-green-500 mt-1">+5% dari bulan lalu</div>
                        </div>
                        <div class="text-blue-500 bg-blue-50 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kartu 2: Pesanan Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Pesanan Aktif</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $totalPenjualan }}</div>
                            <div class="text-xs text-green-500 mt-1">+2% dari bulan lalu</div>
                        </div>
                        <div class="text-green-500 bg-green-50 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kartu 3: Pengiriman Tertunda -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Pengiriman Tertunda</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $totalSupplier }}</div>
                            <div class="text-xs text-yellow-600 mt-1">Sesuai jadwal</div>
                        </div>
                        <div class="text-yellow-500 bg-yellow-50 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kartu 4: Total Pendapatan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</div>
                            <div class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                            <div class="text-xs text-purple-500 mt-1">Sesuai target</div>
                        </div>
                        <div class="text-purple-500 bg-purple-50 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Baris Grafik (Charts) -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Line Chart (Mengambil 2 kolom) -->
                <div class="bg-white shadow-sm sm:rounded-lg lg:col-span-2 p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        Tren Stok Bahan & Roti
                    </h3>
                    <div class="relative h-80 w-full">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <!-- Donut Chart (Mengambil 1 kolom) -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        Distribusi Pesanan
                    </h3>
                    <div class="relative h-80 w-full">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Chart.js diletakkan di dalam layout -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Line Chart
            const ctxLine = document.getElementById('lineChart');
            if(ctxLine) {
                new Chart(ctxLine.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Stok Masuk',
                            data: [120, 190, 300, 250, 200, 350, 400],
                            borderColor: '#3b82f6', // Biru
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Stok Keluar',
                            data: [100, 150, 200, 220, 180, 250, 300],
                            borderColor: '#10b981', // Hijau
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.4
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'top' } }
                    }
                });
            }

            // Donut Chart
            const ctxDonut = document.getElementById('donutChart');
            if(ctxDonut) {
                new Chart(ctxDonut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Roti Tawar', 'Roti Manis', 'Kue Kering'],
                        datasets: [{
                            data: [55, 30, 15],
                            backgroundColor: ['#f59e0b', '#10b981', '#3b82f6'],
                            borderWidth: 0
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            }
        });
    </script>
</x-app-layout>