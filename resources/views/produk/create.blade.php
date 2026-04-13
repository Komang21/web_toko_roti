<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 max-w-md mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-2xl font-semibold mb-6">Tambah Produk Baru</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <select name="kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('kategori') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga Jual</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('harga_jual') border-red-500 @enderror" required>
                        @error('harga_jual')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('stok') border-red-500 @enderror" required>
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                        <a href="{{ route('produk.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

