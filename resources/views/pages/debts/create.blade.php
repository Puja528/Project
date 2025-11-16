@extends('layouts.advance')

@section('title', 'Tambah Hutang/Piutang - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Tambah Hutang/Piutang</h1>
            <p class="text-gray-400">Catat transaksi hutang atau piutang bisnis</p>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <form action="{{ route('debts.store') }}" method="POST">
                @csrf

                <div class="grid gap-6">
                    <!-- Tipe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tipe *</label>
                        <select name="type" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                            <option value="">Pilih Tipe</option>
                            <option value="hutang">Hutang (Kita berhutang)</option>
                            <option value="piutang">Piutang (Orang berhutang ke kita)</option>
                        </select>
                    </div>

                    <!-- Nama dan Jumlah -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nama Pihak *</label>
                            <input type="text" name="person_name" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="Nama orang/perusahaan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah (Rp) *</label>
                            <input type="number" name="amount" required min="0"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="5000000">
                        </div>
                    </div>

                    <!-- Tanggal Jatuh Tempo dan Bunga -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jatuh Tempo *</label>
                            <input type="date" name="due_date" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Bunga (%)</label>
                            <input type="number" name="interest_rate" min="0" step="0.1"
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                   placeholder="0">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition text-white"
                                  placeholder="Deskripsi transaksi (opsional)"></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('debts.index') }}"
                       class="px-6 py-3 border border-gray-600 text-gray-300 rounded-lg font-semibold hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Management -->
        <div class="mt-6 bg-purple-900 border border-purple-700 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-purple-300 mb-2">Tips Kelola Hutang & Piutang:</h3>
            <ul class="text-sm text-purple-200 space-y-1">
                <li>• Selalu catat jatuh tempo untuk menghindari denda</li>
                <li>• Negosiasi bunga yang kompetitif untuk hutang</li>
                <li>• Follow up piutang yang mendekati jatuh tempo</li>
                <li>• Pisahkan antara hutang jangka pendek dan panjang</li>
            </ul>
        </div>
    </div>
</div>
@endsection
