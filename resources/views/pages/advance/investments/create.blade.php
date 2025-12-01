@extends('layouts.advance')

@section('title', 'Tambah Investasi Baru - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('advance.investments.index') }}" class="text-purple-400 hover:text-purple-300 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-white">Tambah Investasi Baru</h1>
    </div>

    <!-- Form Create Investment -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8 max-w-4xl mx-auto">
        <form action="{{ route('advance.investments.store') }}" method="POST">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nama Investasi -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-gray-300 mb-2">Nama Investasi *</label>
                    <input type="text" id="name" name="name"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Contoh: Saham BBCA, Reksadana X"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Investasi -->
                <div>
                    <label for="type" class="block text-gray-300 mb-2">Tipe Investasi *</label>
                    <select id="type" name="type"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                        <option value="">Pilih Tipe</option>
                        @foreach($types as $key => $value)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Level -->
                <div>
                    <label for="risk_level" class="block text-gray-300 mb-2">Risk Level *</label>
                    <select id="risk_level" name="risk_level"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                        <option value="">Pilih Risk Level</option>
                        <option value="low" {{ old('risk_level') == 'low' ? 'selected' : '' }}>Low Risk</option>
                        <option value="medium" {{ old('risk_level') == 'medium' ? 'selected' : '' }}>Medium Risk</option>
                        <option value="high" {{ old('risk_level') == 'high' ? 'selected' : '' }}>High Risk</option>
                    </select>
                    @error('risk_level')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="start_date" class="block text-gray-300 mb-2">Tanggal Mulai *</label>
                    <input type="date" id="start_date" name="start_date"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                           value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Awal -->
                <div>
                    <label for="initial_amount" class="block text-gray-300 mb-2">Jumlah Awal (Rp) *</label>
                    <input type="number" id="initial_amount" name="initial_amount"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                           value="{{ old('initial_amount', 10000000) }}" required>
                    @error('initial_amount')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nilai Saat Ini -->
                <div>
                    <label for="current_value" class="block text-gray-300 mb-2">Nilai Saat Ini (Rp) *</label>
                    <input type="number" id="current_value" name="current_value"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                           value="{{ old('current_value', 12500000) }}" required>
                    @error('current_value')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Panduan Risk Level -->
            <div class="mt-6 p-4 bg-gray-750 rounded-lg border border-gray-600">
                <h3 class="font-semibold text-gray-300 mb-2">Panduan Risk Level:</h3>
                <ul class="text-sm text-gray-400 space-y-1">
                    <li><span class="text-green-400">• Low Risk:</span> Deposito, Obligasi Negara (Return 3-6%)</li>
                    <li><span class="text-yellow-400">• Medium Risk:</span> Reksadana, Saham Blue Chip (Return 6-15%)</li>
                    <li><span class="text-red-400">• High Risk:</span> Saham Growth, Crypto (Return 15%+)</li>
                </ul>
            </div>

            <!-- Preview Data -->
            <div id="previewSection" class="hidden mt-6 p-4 bg-gray-750 rounded-lg border border-gray-600">
                <h3 class="font-semibold text-gray-300 mb-4">Preview Data</h3>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400">Nama Investasi</p>
                        <p id="previewName" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tipe Investasi</p>
                        <p id="previewType" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Risk Level</p>
                        <p id="previewRisk" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tanggal Mulai</p>
                        <p id="previewDate" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Jumlah Awal</p>
                        <p id="previewInitial" class="text-white font-semibold">-</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Nilai Saat Ini</p>
                        <p id="previewCurrent" class="text-white font-semibold">-</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-400">Return</p>
                        <p id="previewReturn" class="text-white font-semibold">-</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('advance.investments.index') }}"
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                    Simpan Investasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Format angka ke format Rupiah
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Format tanggal
    function formatDate(dateString) {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Hitung return persentase
    function calculateReturnPercentage(initial, current) {
        if (!initial || !current) return 0;
        return (((current - initial) / initial) * 100).toFixed(1);
    }

    // Update preview
    function updatePreview() {
        const name = document.getElementById('name').value;
        const type = document.getElementById('type').value;
        const riskLevel = document.getElementById('risk_level').value;
        const initialAmount = parseInt(document.getElementById('initial_amount').value) || 0;
        const currentValue = parseInt(document.getElementById('current_value').value) || 0;
        const startDate = document.getElementById('start_date').value;

        const previewSection = document.getElementById('previewSection');

        if (name && type && riskLevel && startDate) {
            const returnPercentage = calculateReturnPercentage(initialAmount, currentValue);
            const returnAmount = currentValue - initialAmount;

            document.getElementById('previewName').textContent = name;
            document.getElementById('previewType').textContent = document.querySelector(`#type option[value="${type}"]`).textContent;
            document.getElementById('previewRisk').textContent = riskLevel.charAt(0).toUpperCase() + riskLevel.slice(1) + ' Risk';
            document.getElementById('previewDate').textContent = formatDate(startDate);
            document.getElementById('previewInitial').textContent = formatRupiah(initialAmount);
            document.getElementById('previewCurrent').textContent = formatRupiah(currentValue);
            document.getElementById('previewReturn').textContent =
                `${returnPercentage >= 0 ? '+' : ''}${returnPercentage}% (${formatRupiah(returnAmount)})`;
            document.getElementById('previewReturn').className =
                `text-white font-semibold ${returnPercentage >= 0 ? 'text-green-400' : 'text-red-400'}`;

            previewSection.classList.remove('hidden');
        } else {
            previewSection.classList.add('hidden');
        }
    }

    // Event Listeners untuk preview
    document.addEventListener('DOMContentLoaded', function() {
        // Set tanggal default ke hari ini
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('start_date');
        if (!dateInput.value) {
            dateInput.value = today;
        }

        // Add event listeners for preview
        const formInputs = document.querySelectorAll('input, select');
        formInputs.forEach(input => {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        });

        // Initial preview update
        updatePreview();
    });
</script>
@endsection
