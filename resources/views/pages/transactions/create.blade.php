@extends('layouts.admin')

@section('title', 'Tambah Transaksi Baru - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center mb-6">
        <a href="{{ route('transactions.index') }}" class="flex items-center text-purple-600 hover:text-purple-700 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Transaksi Baru</h1>
    </div>

    <div class="bg-white rounded-xl card-shadow p-6">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-red-800 font-semibold">Terjadi kesalahan:</h3>
                </div>
                <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- User -->
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-2">
                        User *
                    </label>
                    <input type="text"
                           id="user"
                           name="user"
                           value="{{ old('user') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                           placeholder="Masukkan nama user"
                           required>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Amount (Rp) *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                               placeholder="0"
                               required>
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type *
                    </label>
                    <select id="type"
                            name="type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                            required>
                        <option value="">Pilih Type</option>
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category *
                    </label>
                    <select id="category"
                            name="category"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                            required>
                        <option value="">Pilih Category</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Date *
                    </label>
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ old('date', date('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                           required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('transactions.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium text-center">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
@endsection
