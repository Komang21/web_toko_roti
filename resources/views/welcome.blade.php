<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rantai Pasok - Toko Roti</title>
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
                <a href="#" class="border-2 border-orange-600 text-orange-600 px-8 py-3 rounded-xl font-bold hover:bg-orange-50 transition">Tentang Sistem</a>
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
                <p class="text-gray-500 text-sm">Manajemen pembelian bahan baku ke supplier (Tepung, Gula, Ragi).</p>
            </div>

            <!-- Produksi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-mortar-pestle"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Produksi</h4>
                <p class="text-gray-500 text-sm">Monitoring proses pengolahan bahan mentah menjadi roti siap jual.</p>
            </div>

            <!-- Inventaris -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-warehouse"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Inventaris</h4>
                <p class="text-gray-500 text-sm">Penyimpanan dan kontrol stok untuk menjaga kesegaran produk.</p>
            </div>

            <!-- Distribusi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-orange-100 hover:shadow-xl transition">
                <div class="text-orange-500 text-3xl mb-4"><i class="fas fa-shipping-fast"></i></div>
                <h4 class="text-xl font-bold mb-2 text-gray-800">Distribusi</h4>
                <p class="text-gray-500 text-sm">Pelacakan pengiriman roti dari gudang pusat ke berbagai outlet.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="container mx-auto px-6 text-center text-gray-500">
            <p>&copy; 2026 Web Toko Roti - Laravel 12 Rantai Pasok System.</p>
        </div>
    </footer>

</body>
</html>