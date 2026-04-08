@extends('layouts.app')

@section('title', 'Pembelian')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between">
        <h2 class="text-xl font-semibold">Daftar Pembelian</h2>
        <a href="{{ route('pembelian.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Pembelian</a>
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
                <th class="border p-2">Supplier</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembelians as $pembelian)
                <tr>
                    <td class="border p-2">{{ $pembelian->tgl_pembelian->format('d/m/Y') }}</td>
                    <td class="border p-2">{{ $pembelian->supplier->nama ?? '-' }}</td>
                    <td class="border p-2">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                    <td class="border p-2">
                        <a href="{{ route('pembelian.show', $pembelian) }}" class="text-blue-500">Lihat Detail</a> | 
                        <a href="{{ route('pembelian.edit', $pembelian) }}" class="text-yellow-500">Edit</a> | 
                        <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus & rollback stok?')" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border p-2 text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $pembelians->links() }}
    </div>
</div>
@endsection

