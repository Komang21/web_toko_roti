@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between">
        <h2 class="text-xl font-semibold">Daftar Supplier</h2>
        <a href="{{ route('supplier.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Supplier</a>
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
                <th class="border p-2">Alamat</th>
                <th class="border p-2">Telp</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td class="border p-2">{{ $supplier->nama }}</td>
                    <td class="border p-2">{{ $supplier->alamat }}</td>
                    <td class="border p-2">{{ $supplier->telp }}</td>
                    <td class="border p-2">
                        <a href="{{ route('supplier.show', $supplier) }}" class="text-blue-500">Lihat</a> | 
                        <a href="{{ route('supplier.edit', $supplier) }}" class="text-yellow-500">Edit</a> | 
                        <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</button>
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
        {{ $suppliers->links() }}
    </div>
</div>
@endsection

