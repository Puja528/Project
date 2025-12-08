@extends('layouts.advance')

@section('title', 'Edit Investasi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="text-purple-400 hover:text-purple-300 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-white">Edit Investasi</h1>
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

    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Edit Investasi -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 max-w-2xl mx-auto">
        <form action="{{ route('advance.investments.update', $investment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6">

                <!-- Nama Investasi -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Nama Investasi *
                    </label>
                    <input type="text"
                           name="name"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                           value="{{ old('name', $investment->name) }}"
                           required>
                </div>

                <!-- Tipe Investasi -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Tipe Investasi *
                    </label>
                    <select name="type"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                            required>
                        <option value="">Pilih Tipe</option>
                        <option value="Saham" {{ old('type', $investment->type) == 'Saham' ? 'selected' : '' }}>Saham</option>
                        <option value="Reksadana" {{ old('type', $investment->type) == 'Reksadana' ? 'selected' : '' }}>Reksadana</option>
                        <option value="Obligasi" {{ old('type', $investment->type) == 'Obligasi' ? 'selected' : '' }}>Obligasi</option>
                        <option value="Crypto" {{ old('type', $investment->type) == 'Crypto' ? 'selected' : '' }}>Crypto</option>
                    </select>
                </div>

                <!-- Level Risiko -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Risk Level *
                    </label>
                    <select name="risk_level"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                            required>
                        <option value="">Pilih</option>
                        <option value="low" {{ old('risk_level', $investment->risk_level) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('risk_level', $investment->risk_level) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('risk_level', $investment->risk_level) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <!-- Jumlah Awal -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Jumlah Awal (Rp) *
                    </label>
                    <input type="number"
                           name="initial_amount"
                           min="0"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                           value="{{ old('initial_amount', $investment->initial_amount) }}"
                           required>
                </div>

                <!-- Nilai Sekarang -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Nilai Saat Ini (Rp) *
                    </label>
                    <input type="number"
                           name="current_value"
                           min="0"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                           value="{{ old('current_value', $investment->current_value) }}"
                           required>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-gray-300 mb-2 font-semibold">
                        Tanggal Mulai *
                    </label>
                    <input type="date"
                           name="start_date"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"
                           value="{{ old('start_date', $investment->start_date) }}"
                           required>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold">
                    <i class="fas fa-save mr-2"></i> Update Investasi
                </button>
            </div>

        </form>
    </div>

    <!-- Preview -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 max-w-2xl mx-auto mt-6">
        <h3 class="text-xl font-bold text-white mb-4">Preview Perubahan</h3>

        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Nama Investasi</p>
                <p id="previewName" class="text-white font-semibold">{{ $investment->name }}</p>
            </div>

            <div>
                <p class="text-gray-400">Tipe</p>
                <p id="previewType" class="text-white font-semibold">{{ $investment->type }}</p>
            </div>

            <div>
                <p class="text-gray-400">Risk Level</p>
                <p id="previewRisk" class="text-white font-semibold">{{ ucfirst($investment->risk_level) }}</p>
            </div>

            <div>
                <p class="text-gray-400">Jumlah Awal</p>
                <p id="previewInitial" class="text-white font-semibold">
                    Rp {{ number_format($investment->initial_amount) }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Nilai Sekarang</p>
                <p id="previewCurrent" class="text-white font-semibold">
                    Rp {{ number_format($investment->current_value) }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Tanggal Mulai</p>
                <p id="previewStartDate" class="text-white font-semibold">
                    {{ \Carbon\Carbon::parse($investment->start_date)->format('d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fields = {
        name: 'previewName',
        type: 'previewType',
        risk_level: 'previewRisk',
        initial_amount: 'previewInitial',
        current_value: 'previewCurrent',
        start_date: 'previewStartDate'
    };

    function formatRupiah(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    Object.keys(fields).forEach(field => {
        document.querySelector(`[name="${field}"]`)?.addEventListener('input', function() {
            let value = this.value;

            if (field === 'initial_amount' || field === 'current_value') {
                value = 'Rp ' + formatRupiah(value);
            }
            if (field === 'risk_level') {
                value = value.charAt(0).toUpperCase() + value.slice(1);
            }
            if (field === 'start_date') {
                const date = new Date(value);
                value = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            }

            document.getElementById(fields[field]).textContent = value;
        });
    });
});
</script>
@endsection
