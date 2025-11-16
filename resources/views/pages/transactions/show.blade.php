@extends('layouts.admin')

@section('title', 'Detail Transaksi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center mb-6">
        <a href="{{ route('transactions.index') }}" class="flex items-center text-purple-600 hover:text-purple-700 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Detail Transaksi</h1>
    </div>

    <div class="bg-white rounded-xl card-shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-700">Informasi Transaksi</h2>
            <div class="flex space-x-2">
                <a href="{{ route('transactions.edit', $transaction->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                    ✏️ Edit
                </a>
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">ID Transaksi</label>
                    <p class="text-lg font-semibold text-gray-800">#{{ $transaction->id }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">User</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->user }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jumlah</label>
                    <p class="text-2xl font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tipe Transaksi</label>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $transaction->type === 'income' ? '💰 Income' : '💸 Expense' }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                    <p class="text-lg font-medium text-gray-800">
                        @php
                            $categories = \App\Models\Transaction::getCategories();
                            echo $categories[$transaction->category] ?? $transaction->category;
                        @endphp
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                    <p class="text-lg font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Pada</label>
                <p class="text-sm text-gray-700">
                    {{ $transaction->created_at->format('d F Y H:i') }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Diperbarui Pada</label>
                <p class="text-sm text-gray-700">
                    {{ $transaction->updated_at->format('d F Y H:i') }}
                </p>
            </div>
        </div>

        <!-- Action Buttons Bottom -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
            <a href="{{ route('transactions.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                ← Kembali ke Daftar
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('transactions.edit', $transaction->id) }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    ✏️ Edit Transaksi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
@endsection
