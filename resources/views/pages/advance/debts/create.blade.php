@extends('layouts.advance')

@section('title', 'Tambah Hutang/Piutang - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-6">Tambah Hutang/Piutang</h1>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <form action="{{ route('advance.debts.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Tipe -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Tipe *</label>
                        <select id="type" name="type" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih Tipe</option>
                            <option value="piutang" {{ old('type') == 'piutang' ? 'selected' : '' }}>Piutang</option>
                            <option value="hutang" {{ old('type') == 'hutang' ? 'selected' : '' }}>Hutang</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Pihak -->
                    <div>
                        <label for="person_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Pihak *</label>
                        <input type="text" id="person_name" name="person_name" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Nama orang/perusahaan"
                               value="{{ old('person_name') }}">
                        @error('person_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Jumlah (Rp) *</label>
                        <input type="number" id="amount" name="amount" required min="0"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="1000000"
                               value="{{ old('amount') }}">
                        @error('amount')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jatuh Tempo -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">Jatuh Tempo *</label>
                        <input type="date" id="due_date" name="due_date" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               value="{{ old('due_date') }}">
                        @error('due_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bunga -->
                    <div>
                        <label for="interest_rate" class="block text-sm font-medium text-gray-300 mb-2">Bunga (%)</label>
                        <input type="number" id="interest_rate" name="interest_rate" min="0" max="100" step="0.1"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="0"
                               value="{{ old('interest_rate', 0) }}">
                        @error('interest_rate')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Deskripsi transaksi (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('advance.debts.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
