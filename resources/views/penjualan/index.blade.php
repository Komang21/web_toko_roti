@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between">
        <h2 class="text-xl font-semibold">Daftar Penjualan</h2>
        <a href="{{ route('penjualan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Penjualan</a>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualans as $penjualan)
                <tr>
                    <td class="border p-2">{{ $penjualan->tgl_jual->format('d/m/Y') }}</td>
                    <td class="border p-2">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    <td class="border p-2">
                        <a href="{{ route('penjualan.show', $penjualan) }}" class="text-blue-500">Lihat Detail</a> | 
                        <a href="{{ route('penjualan.edit', $penjualan) }}" class="text-yellow-500">Edit</a> | 
                        <form action="{{ route('penjualan.destroy', $penjualan) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus & restore stok?')" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border p-2 text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $penjualans->links() }}
    </div>
</div>
@endsection

