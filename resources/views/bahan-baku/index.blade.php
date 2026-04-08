@extends('layouts.app')

@section('title', 'Bahan Baku')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between">
        <h2 class="text-xl font-semibold">Daftar Bahan Baku</h2>
        <a href="{{ route('bahan-baku.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Bahan</a>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Supplier</th>
                <th class="border p-2">Stok</th>
                <th class="border p-2">Harga</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bahanBakus as $bahan)
                <tr>
                    <td class="border p-2">{{ $bahan->nama }}</td>
                    <td class="border p-2">{{ $bahan->supplier->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $bahan->stok }}</td>
                    <td class="border p-2">Rp {{ number_format($bahan->harga, 0, ',', '.') }}</td>
                    <td class="border p-2">
                        <a href="{{ route('bahan-baku.show', $bahan) }}" class="text-blue-500">Lihat</a> | 
                        <a href="{{ route('bahan-baku.edit', $bahan) }}" class="text-yellow-500">Edit</a> | 
                        <form action="{{ route('bahan-baku.destroy', $bahan) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border p-2 text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $bahanBakus->links() }}
    </div>
</div>
@endsection

