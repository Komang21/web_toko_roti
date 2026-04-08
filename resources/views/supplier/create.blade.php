@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Tambah Supplier Baru</h2>

    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="shadow appearance-none border rounded w-full py-2 px-3 @error('nama') border-red-500 @enderror" required>
            @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea name="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Telepon</label>
            <input type="text" name="telp" value="{{ old('telp') }}" class="shadow appearance-none border rounded w-full py-2 px-3 @error('telp') border-red-500 @enderror">
            @error('telp')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan
            </button>
            <a href="{{ route('supplier.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

