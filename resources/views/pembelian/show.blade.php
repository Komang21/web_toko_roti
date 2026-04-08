@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-semibold">Detail Pembelian #{{ $pembelian->id }}</h2>
        <a href="{{ route('pembelian.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Informasi Pembelian</h3>
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Tanggal:</strong> {{ $pembelian->tgl_pembelian->format('d/m/Y H:i') }}</div>
            <div><strong>Supplier:</strong> {{ $pembelian->supplier->nama ?? 'N/A' }}</div>
            <div><strong>Total:</strong> Rp {{ number_format($pembelian->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Detail Bahan</h3>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Bahan</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian->details as $detail)
                    <tr>
                        <td class="border p-2">{{ $detail->bahan->nama }}</td>
                        <td class="border p-2">{{ $detail->qty }}</td>
                        <td class="border p-2">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="border p-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

