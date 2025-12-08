@extends('layouts.advance')

@section('title', 'Edit Anggaran - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="text-purple-400 hover:text-purple-300 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-white">Edit Anggaran</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Edit Anggaran -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 max-w-2xl mx-auto">
        <form action="{{ route('advance.budgets.update', $budget->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                           value="{{ old('budget_name', $budget->budget_name) }}"
                           placeholder="Masukkan nama anggaran"
                           required>
                    @error('budget_name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
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
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('category', $budget->category) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Periode -->
                <div>
                    <label for="date" class="block text-gray-300 mb-2 font-semibold">
                        Periode *
                    </label>
                    <input type="date"
                           id="date"
                           name="date"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                           value="{{ old('date', $budget->date) }}"
                           required>
                    @error('date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Alokasi -->
                <div>
                    <label for="allocated_amount" class="block text-gray-300 mb-2 font-semibold">
                        Jumlah Alokasi (Rp) *
                    </label>
                    <input type="number"
                           id="allocated_amount"
                           name="allocated_amount"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200"
                           value="{{ old('allocated_amount', $budget->allocated_amount) }}"
                           placeholder="0"
                           min="0"
                           required>
                    @error('allocated_amount')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-gray-300 mb-2 font-semibold">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200 resize-none"
                              placeholder="Tambahkan deskripsi anggaran (opsional)">{{ old('description', $budget->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Anggaran
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 max-w-2xl mx-auto mt-6">
        <h3 class="text-xl font-bold text-white mb-4">Preview Perubahan</h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Nama Anggaran</p>
                <p id="previewName" class="text-white font-semibold">{{ $budget->budget_name }}</p>
            </div>
            <div>
                <p class="text-gray-400">Kategori</p>
                <p id="previewCategory" class="text-white font-semibold">
                    {{ $categories[$budget->category] ?? $budget->category }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Periode</p>
                <p id="previewDate" class="text-white font-semibold">
                    {{ \Carbon\Carbon::parse($budget->date . '-01')->format('F Y') }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Jumlah Alokasi</p>
                <p id="previewAmount" class="text-white font-semibold">
                    Rp {{ number_format($budget->allocated_amount, 0, ',', '.') }}
                </p>
            </div>
            @if($budget->description)
            <div class="md:col-span-2">
                <p class="text-gray-400">Deskripsi</p>
                <p id="previewDescription" class="text-white font-semibold">{{ $budget->description }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.form-control:focus {
    border-color: #8b5cf6;
    box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
}
</style>

<script>
// Real-time preview update
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('input, select, textarea');
    const previewFields = {
        'budget_name': 'previewName',
        'category': 'previewCategory',
        'date': 'previewDate',
        'allocated_amount': 'previewAmount',
        'description': 'previewDescription'
    };

    // Format currency
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Format period
    function formatPeriod(period) {
        if (!period) return '-';
        const date = new Date(period + '-01');
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long'
        });
    }

    // Get category name
    function getCategoryName(categoryKey) {
        const categorySelect = document.getElementById('category');
        const selectedOption = categorySelect.querySelector(`option[value="${categoryKey}"]`);
        return selectedOption ? selectedOption.textContent : categoryKey;
    }

    // Update preview
    function updatePreview() {
        Object.keys(previewFields).forEach(fieldName => {
            const input = document.querySelector(`[name="${fieldName}"]`);
            const previewElement = document.getElementById(previewFields[fieldName]);

            if (input && previewElement) {
                let value = input.value;

                // Format specific fields
                if (fieldName === 'allocated_amount') {
                    value = formatRupiah(value || 0);
                } else if (fieldName === 'period') {
                    value = formatPeriod(value);
                } else if (fieldName === 'category') {
                    value = getCategoryName(value);
                }

                previewElement.textContent = value || '-';
            }
        });
    }

    // Add event listeners
    formInputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Initial preview update
    updatePreview();
});
</script>
@endsection
