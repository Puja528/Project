@extends('layouts.advance')

@section('title', 'Tambah Anggaran Baru - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('advance.budgets.index') }}" class="text-purple-400 hover:text-purple-300 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-white">Tambah Anggaran Baru</h1>
    </div>
    @if ($errors->any())
        <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong>Terjadi kesalahan:</strong>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Create Anggaran -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8 max-w-2xl mx-auto">
        <form action="{{ route('advance.budgets.store') }}" method="POST">
            @csrf

            <div class="grid gap-6">
                <!-- Nama Anggaran -->
                <div>
                    <label for="budget_name" class="block text-gray-300 mb-2 font-semibold">
                        Nama Anggaran *
                    </label>
                    <input type="text"
                           id="budget_name"
                           name="budget_name"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                           value="{{ old('budget_name') }}"
                           placeholder="Contoh: Anggaran Bulanan, Liburan Akhir Tahun, dll."
                           required>
                    @error('budget_name')
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-gray-300 mb-2 font-semibold">
                        Kategori *
                    </label>
                    <select id="category"
                            name="category"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                            required>
                        <option value="">Pilih Kategori</option>
                        @php
                            // Fallback categories jika variabel $categories tidak ada
                            $fallbackCategories = [
                                'makanan' => 'Makanan & Minuman',
                                'transportasi' => 'Transportasi',
                                'hiburan' => 'Hiburan',
                                'kesehatan' => 'Kesehatan',
                                'pendidikan' => 'Pendidikan',
                                'belanja' => 'Belanja',
                                'tagihan' => 'Tagihan & Utilitas',
                                'investasi' => 'Investasi',
                                'lainnya' => 'Lainnya'
                            ];
                            $categories = $categories ?? $fallbackCategories;
                        @endphp
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- date -->
                <div>
                    <label for="date" class="block text-gray-300 mb-2 font-semibold">
                        Date *
                    </label>
                    <input type="date"
                           id="date"
                           name="date"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                           value="{{ old('date') }}"
                           required>
                    <p class="text-gray-400 text-xs mt-1">
                        Pilih bulan dan tahun untuk date anggaran
                    </p>
                    @error('date')
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jumlah Alokasi -->
                <div>
                    <label for="allocated_amount" class="block text-gray-300 mb-2 font-semibold">
                        Jumlah Alokasi (Rp) *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="number"
                               id="allocated_amount"
                               name="allocated_amount"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                               value="{{ old('allocated_amount') }}"
                               placeholder="0"
                               min="1000"
                               step="1000"
                               required>
                    </div>
                    <p class="text-gray-400 text-xs mt-1">
                        Minimum anggaran: Rp 1.000
                    </p>
                    @error('allocated_amount')
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-gray-300 mb-2 font-semibold">
                        Deskripsi
                        <span class="text-gray-400 text-sm font-normal">(Opsional)</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200 resize-none"
                              placeholder="Tambahkan deskripsi atau catatan untuk anggaran ini...">{{ old('description') }}</textarea>
                    <div class="flex justify-between text-gray-400 text-xs mt-1">
                        <span>Maksimal 500 karakter</span>
                        <span id="charCount">0/500</span>
                    </div>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Preview Section -->
            <div id="previewSection" class="hidden mt-8 p-6 bg-gray-750 rounded-lg border border-gray-600">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Preview Anggaran
                </h3>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400">Nama Anggaran</p>
                        <p id="previewName" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Kategori</p>
                        <p id="previewCategory" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Date</p>
                        <p id="previewdate" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Jumlah Alokasi</p>
                        <p id="previewAmount" class="text-white font-semibold">-</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-400">Deskripsi</p>
                        <p id="previewDescription" class="text-white font-semibold">-</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                <a href="{{ route('advance.budgets.index') }}"
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Anggaran
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 max-w-2xl mx-auto">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
            <i class="fas fa-lightbulb mr-2 text-yellow-400"></i>
            Tips Mengatur Anggaran
        </h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-300">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-400 mr-2 mt-1"></i>
                <span>Buat anggaran yang realistis sesuai kemampuan finansial</span>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-400 mr-2 mt-1"></i>
                <span>Pisahkan anggaran berdasarkan kategori kebutuhan</span>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-400 mr-2 mt-1"></i>
                <span>Review anggaran secara berkala setiap bulan</span>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-400 mr-2 mt-1"></i>
                <span>Sisihkan dana untuk kebutuhan tak terduga</span>
            </div>
        </div>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('input, select, textarea');
    const previewSection = document.getElementById('previewSection');
    const charCount = document.getElementById('charCount');
    const descriptionTextarea = document.getElementById('description');

    // Format currency
    function formatRupiah(amount) {
        if (!amount) return 'Rp 0';
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Get category name
    function getCategoryName(categoryKey) {
        const categorySelect = document.getElementById('category');
        const selectedOption = categorySelect.querySelector(`option[value="${categoryKey}"]`);
        return selectedOption ? selectedOption.textContent : categoryKey;
    }

    // Update character count
    function updateCharCount() {
        const count = descriptionTextarea.value.length;
        charCount.textContent = `${count}/500`;

        if (count > 500) {
            charCount.classList.add('text-red-400');
        } else {
            charCount.classList.remove('text-red-400');
        }
    }

    // Update preview
    function updatePreview() {
        const budgetName = document.getElementById('budget_name').value;
        const category = document.getElementById('category').value;
        const date = document.getElementById('date').value;
        const allocatedAmount = document.getElementById('allocated_amount').value;
        const description = document.getElementById('description').value;

        // Check if all required fields have values
        const hasRequiredFields = budgetName && category && date && allocatedAmount;

        if (hasRequiredFields) {
            document.getElementById('previewName').textContent = budgetName || '-';
            document.getElementById('previewCategory').textContent = getCategoryName(category);
            document.getElementById('previewdate').textContent = formatdate(date);
            document.getElementById('previewAmount').textContent = formatRupiah(allocatedAmount);
            document.getElementById('previewDescription').textContent = description || '-';

            previewSection.classList.remove('hidden');
        } else {
            previewSection.classList.add('hidden');
        }
    }

    // Format amount input
    function formatAmountInput() {
        const amountInput = document.getElementById('allocated_amount');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseInt(this.value).toString();
            }
        });
    }


    // Add event listeners
    formInputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    descriptionTextarea.addEventListener('input', function() {
        updateCharCount();
        updatePreview();
    });

    // Initialize
    setDefaultdate();
    formatAmountInput();
    updateCharCount();
    updatePreview();
});
</script>
@endsection
