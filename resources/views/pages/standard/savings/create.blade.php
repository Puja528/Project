@extends('layouts.standard')

@section('title', 'Buat Target Tabungan - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Target Tabungan Baru</h1>
            <p class="text-gray-600">Rencanakan tujuan finansial Anda</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <form action="{{ route('savings.store') }}" method="POST">
                @csrf
                
                <div class="grid gap-6">
                    <!-- Nama Target -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Target *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                               placeholder="Contoh: Tabungan Rumah, Dana Pendidikan">
                    </div>

                    <!-- Jumlah Target dan Saat Ini -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Jumlah (Rp) *</label>
                            <input type="number" name="target_amount" required min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                   placeholder="10000000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Saat Ini (Rp) *</label>
                            <input type="number" name="current_amount" required min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                   placeholder="0">
                        </div>
                    </div>

                    <!-- Tanggal Target -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Target Tanggal *</label>
                        <input type="date" name="target_date" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                  placeholder="Deskripsi tujuan tabungan (opsional)"></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('savings.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Target
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-800">Tips Menabung</h3>
                    <p class="text-sm text-yellow-600 mt-1">
                        Tetapkan target yang realistis dan bagi menjadi target bulanan. 
                        Review progress secara berkala dan sesuaikan jika diperlukan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection