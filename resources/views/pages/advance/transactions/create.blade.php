@extends('layouts.advance')

@section('title', 'Tambah Transaksi - Fintrack')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            {{-- Header dengan breadcrumb --}}
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('advance.transactions.index') }}"
                               class="inline-flex items-center text-sm text-gray-400 hover:text-white">
                                <i class="fas fa-list mr-2"></i>
                                Daftar Transaksi
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm text-white">Tambah Transaksi</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-3xl font-bold text-white mb-2">Tambah Transaksi Baru</h1>
                <p class="text-gray-400">Isi form berikut untuk mencatat transaksi baru</p>
            </div>

            {{-- Form --}}
            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <form action="{{ route('advance.transactions.store') }}" method="POST" id="transactionForm">
                    @csrf

                    {{-- Error messages --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-900/30 border border-red-700 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                                <h3 class="text-red-300 font-semibold">Periksa kembali form berikut:</h3>
                            </div>
                            <ul class="list-disc pl-5 text-red-300 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-6">

                        {{-- Judul Transaksi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Judul Transaksi *
                                <span class="text-xs text-gray-500 ml-1">(Maks. 255 karakter)</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required
                                   maxlength="255"
                                   class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                   placeholder="Contoh: Belanja Bulanan, Gaji Januari, Bayar Listrik">
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Deskripsi (Opsional)
                                <span class="text-xs text-gray-500 ml-1">(Tambahkan catatan penting)</span>
                            </label>
                            <textarea name="description"
                                      rows="3"
                                      class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                      placeholder="Contoh: Belanja kebutuhan dapur untuk 2 minggu">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jumlah & Tipe --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Jumlah --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Jumlah (Rp) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                                    <input type="text"
                                           name="amount_display"
                                           id="amount_display"
                                           value="{{ old('amount_display', old('amount')) }}"
                                           required
                                           class="w-full pl-10 pr-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                           placeholder="0">
                                    <input type="hidden"
                                           name="amount"
                                           id="amount"
                                           value="{{ old('amount') }}">
                                </div>
                                @error('amount')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Masukkan angka tanpa titik atau koma</p>
                            </div>

                            {{-- Tipe --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Tipe Transaksi *
                                </label>
                                <select name="type"
                                        required
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih Tipe</option>
                                    <option value="pemasukan" {{ old('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="pengeluaran" {{ old('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kategori & Prioritas --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Kategori --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Kategori *
                                </label>
                                <select name="category"
                                        required
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                                    <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>🍔 Makanan</option>
                                    <option value="transportasi" {{ old('category') == 'transportasi' ? 'selected' : '' }}>🚗 Transportasi</option>
                                    <option value="hiburan" {{ old('category') == 'hiburan' ? 'selected' : '' }}>🎬 Hiburan</option>
                                    <option value="kesehatan" {{ old('category') == 'kesehatan' ? 'selected' : '' }}>🏥 Kesehatan</option>
                                    <option value="pendidikan" {{ old('category') == 'pendidikan' ? 'selected' : '' }}>📚 Pendidikan</option>
                                    <option value="belanja" {{ old('category') == 'belanja' ? 'selected' : '' }}>🛒 Belanja</option>
                                    <option value="tagihan" {{ old('category') == 'tagihan' ? 'selected' : '' }}>💳 Tagihan</option>
                                    <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                </select>
                                @error('category')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Prioritas --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Prioritas (Eisenhower Matrix) *
                                    <span class="text-xs text-gray-500 ml-1">Tentukan tingkat urgensi</span>
                                </label>
                                <select name="priority"
                                        required
                                        class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                    <option value="" disabled {{ old('priority') ? '' : 'selected' }}>Pilih Prioritas</option>
                                    <option value="tinggi" {{ old('priority') == 'tinggi' ? 'selected' : '' }}
                                        class="text-red-300">⚠️ Penting & Mendesak</option>
                                    <option value="sedang" {{ old('priority') == 'sedang' ? 'selected' : '' }}
                                        class="text-blue-300">📅 Penting & Tidak Mendesak</option>
                                    <option value="rendah" {{ old('priority') == 'rendah' ? 'selected' : '' }}
                                        class="text-yellow-300">⏰ Mendesak & Tidak Penting</option>
                                    <option value="tidak_penting" {{ old('priority') == 'tidak_penting' ? 'selected' : '' }}
                                        class="text-green-300">💤 Tidak Mendesak & Tidak Penting</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Tanggal Transaksi *
                            </label>
                            <input type="date"
                                   name="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                            @error('date')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Form Actions --}}
                    <div class="flex justify-between items-center pt-8 mt-8 border-t border-gray-700">
                        <div class="text-sm text-gray-400">
                            <i class="fas fa-info-circle mr-2"></i>
                            Field dengan tanda * wajib diisi
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('advance.transactions.index') }}"
                               class="px-6 py-3 border border-gray-600 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg font-semibold transition flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountDisplay = document.getElementById('amount_display');
        const amountHidden = document.getElementById('amount');
        const form = document.getElementById('transactionForm');

        // Format tampilan jumlah dengan titik sebagai pemisah ribuan
        function formatNumber(num) {
            if (!num) return '';
            // Hapus semua karakter non-digit
            num = num.toString().replace(/\D/g, '');
            // Format dengan titik sebagai pemisah ribuan
            return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Ketika user mengetik di amount_display
        amountDisplay.addEventListener('input', function() {
            // Simpan posisi kursor
            const cursorPosition = this.selectionStart;

            // Format angka
            const formatted = formatNumber(this.value);

            // Update tampilan
            this.value = formatted;

            // Kembalikan posisi kursor
            const diff = formatted.length - this.value.length;
            this.setSelectionRange(cursorPosition + diff, cursorPosition + diff);

            // Simpan nilai asli (tanpa format) ke hidden input
            const rawValue = this.value.replace(/\./g, '');
            amountHidden.value = rawValue;
        });

        // Ketika form disubmit, pastikan hidden input memiliki nilai
        form.addEventListener('submit', function(e) {
            // Pastikan hidden input memiliki nilai
            if (amountDisplay.value && !amountHidden.value) {
                const rawValue = amountDisplay.value.replace(/\./g, '');
                amountHidden.value = rawValue;
            }

            // Validasi: pastikan nilai adalah angka
            if (amountHidden.value && isNaN(amountHidden.value)) {
                e.preventDefault();
                alert('Jumlah harus berupa angka');
                amountDisplay.focus();
                return;
            }

            // Validasi: pastikan nilai tidak negatif
            if (parseInt(amountHidden.value) < 0) {
                e.preventDefault();
                alert('Jumlah tidak boleh negatif');
                amountDisplay.focus();
                return;
            }
        });

        // Set min date tidak lebih dari hari ini
        const dateInput = document.querySelector('input[name="date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInput.max = today;

        // Alert jika mencoba memilih tanggal di masa depan
        dateInput.addEventListener('change', function() {
            if (this.value > today) {
                alert('Tanggal tidak boleh lebih dari hari ini');
                this.value = today;
            }
        });

        // Inisialisasi nilai old jika ada
        if (amountHidden.value) {
            amountDisplay.value = formatNumber(amountHidden.value);
        }
    });
</script>
@endpush
