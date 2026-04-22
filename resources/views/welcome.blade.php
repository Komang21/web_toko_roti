<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rantai Pasok - Toko Roti</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-orange-50 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600"><i class="fas fa-bread-slice mr-2"></i>RotiManagement</h1>
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-orange-600 font-semibold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="container mx-auto mt-12 px-6 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2">
            <h2 class="text-5xl font-extrabold text-gray-800 leading-tight">
                Kelola Rantai Pasok <br> <span class="text-orange-600">Produksi Roti</span> Lebih Efisien.
            </h2>
            <p class="mt-4 text-gray-600 text-lg">
                Sistem terintegrasi untuk memantau pengadaan bahan baku, proses produksi harian, hingga distribusi stok ke outlet secara real-time.
            </p>
            <div class="mt-8 flex space-x-4">
                <a href="#modul" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition">Lihat Modul</a>
<a href="#" onclick="openModal()" class="border-2 border-orange-600 text-orange-600 px-8 py-3 rounded-xl font-bold hover:bg-orange-50 transition cursor-pointer">Tentang Sistem</a>
            </div>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
            <!-- Icon besar sebagai pengganti gambar -->
            <i class="fas fa-truck-moving text-[200px] text-orange-200"></i>
        </div>
    </header>

    <!-- Modul Section (Tahapan Rantai Pasok) -->
    <section id="modul" class="container mx-auto py-20 px-6">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-800">Cakupan Sistem (Supply Chain)</h3>
            <div class="w-20 h-1 bg-orange-500 mx-auto mt-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Pengadaan -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-shopping-cart"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Pengadaan</h4>
                <p class="text-gray-500 text-sm cursor-pointer" onclick="toggleDetail(this)">Manajemen pembelian bahan baku ke supplier (Tepung, Gula, Ragi).</p>
                <div class="mt-4 hidden bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400 detail-text">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        <li>CRUD Supplier</li>
                        <li>PembelianDetail dengan qty/harga</li>
                        <li>Update stok bahan otomatis</li>
                        <li>Laporan pembelian per supplier</li>
                    </ul>
                </div>
            </div>

            <!-- Produksi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-mortar-pestle"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Produksi</h4>
                <p class="text-gray-500 text-sm cursor-pointer" onclick="toggleDetail(this)">Monitoring proses pengolahan bahan mentah menjadi roti siap jual.</p>
                <div class="mt-4 hidden bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400 detail-text">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        <li>Konsumsi bahan baku per produksi</li>
                        <li>Update stok bahan & produk</li>
                        <li>Resep produksi per produk</li>
                        <li>Tracking proses harian</li>
                    </ul>
                </div>
            </div>

            <!-- Inventaris -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-warehouse"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Inventaris</h4>
                <p class="text-gray-500 text-sm cursor-pointer" onclick="toggleDetail(this)">Penyimpanan dan kontrol stok untuk menjaga kesegaran produk.</p>
                <div class="mt-4 hidden bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400 detail-text">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        <li>Stok bahan baku & roti real-time</li>
                        <li>Alert stok kritis</li>
                        <li>Tren stok dashboard</li>
                        <li>Distribusi penjualan</li>
                    </ul>
                </div>
            </div>

            <!-- Distribusi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-shipping-fast"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Distribusi</h4>
                <p class="text-gray-500 text-sm cursor-pointer" onclick="toggleDetail(this)">Pelacakan pengiriman roti dari gudang pusat ke berbagai outlet.</p>
                <div class="mt-4 hidden bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400 detail-text">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        <li>Penjualan POS system</li>
                        <li>Update stok otomatis</li>
                        <li>Laporan penjualan harian</li>
                        <li>Distribusi per produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="container mx-auto px-6 text-center text-gray-500">
            <p>&copy; 2026 Web Toko Roti - Laravel 12 Rantai Pasok System.</p>
        </div>
    </footer>

    <!-- Modal Tentang Sistem -->
    <div id="aboutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white animate-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800"><i class="fas fa-info-circle text-orange-500 mr-2"></i>Tentang Sistem Rantai Pasok Toko Roti</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <div class="space-y-6 text-gray-700">
                <p class="text-lg leading-relaxed">Sistem Manajemen Rantai Pasok Toko Roti adalah aplikasi web berbasis Laravel yang <strong>terintegrasi penuh</strong> untuk mengelola seluruh alur bisnis toko roti dari hulu ke hilir.</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-bold text-orange-600 mb-3 text-xl">Fitur Utama:</h4>
                        <ul class="space-y-2 list-disc pl-5">
                            <li>✅ Manajemen Supplier & Pembelian Bahan Baku</li>
                            <li>✅ Tracking Stok Bahan & Produk Roti Real-time</li>
                            <li>✅ Proses Produksi dengan Konsumsi Bahan Otomatis</li>
                            <li>✅ Penjualan & Update Stok Otomatis</li>
                            <li>✅ Dashboard Analitik Tren Stok & Distribusi</li>
                            <li>✅ Laporan Lengkap CRUD Operations</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-orange-600 mb-3 text-xl">Cakupan Supply Chain:</h4>
                        <ul class="space-y-2 list-disc pl-5">
                            <li><strong>Pengadaan:</strong> Tepung, Gula, Ragi → Supplier</li>
                            <li><strong>Produksi:</strong> Bahan → Roti Tawar/Manis/Kering</li>
                            <li><strong>Inventaris:</strong> Kontrol Stok Kritis</li>
                            <li><strong>Penjualan:</strong> POS + Stok Update</li>
                        </ul>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <p class="italic text-gray-500 mb-4">Sistem ini memastikan tidak ada kehabisan stok bahan kritis dan optimalisasi produksi harian.</p>
                    <button onclick="closeModal()" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('aboutModal').classList.remove('hidden');
            document.getElementById('aboutModal').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('aboutModal').classList.add('hidden');
            document.getElementById('aboutModal').classList.remove('flex');
        }

        // Close modal on backdrop click
        document.getElementById('aboutModal').onclick = function(e) {
            if (e.target === this) closeModal();
        }

        function toggleDetail(p) {
            const detail = p.nextElementSibling;
            if (detail.classList.contains('hidden')) {
                detail.classList.remove('hidden');
                p.style.color = '#ea580c';
                p.innerHTML += ' <i class="fas fa-chevron-up"></i>';
            } else {
                detail.classList.add('hidden');
                p.style.color = '';
                p.innerHTML = p.innerHTML.replace(' <i class="fas fa-chevron-up"></i>', '');
            }
        }
    </script>

</body>
</html>
