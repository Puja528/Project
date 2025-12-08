@extends('layouts.standard')

@section('title', 'Edit Target Tabungan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Target Tabungan</h1>
            <p class="text-gray-600">Perbarui informasi target tabungan</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('standard.savings.update', $saving['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Target</label>
                        <input type="text" name="name" id="name"
                               value="{{ $saving['name'] }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Target Amount -->
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700">Target Jumlah (Rp)</label>
                        <input type="number" name="target_amount" id="target_amount"
                               value="{{ $saving['target_amount'] }}" min="0" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Current Amount -->
                    <div>
                        <label for="current_amount" class="block text-sm font-medium text-gray-700">Jumlah Saat Ini (Rp)</label>
                        <input type="number" name="current_amount" id="current_amount"
                               value="{{ $saving['current_amount'] }}" min="0" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Target Date -->
                    <div>
                        <label for="target_date" class="block text-sm font-medium text-gray-700">Target Tanggal</label>
                        <input type="date" name="target_date" id="target_date"
                               value="{{ $saving['target_date'] }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">{{ $saving['description'] ?? '' }}</textarea>
                    </div>

                    <!-- Current Progress -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-2">Progress Saat Ini</h4>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress</span>
                            <span>{{ number_format($saving['progress_percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full"
                                 style="width: {{ $saving['progress_percentage'] }}%"></div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">
                            Rp {{ number_format($saving['current_amount'], 0, ',', '.') }} dari Rp {{ number_format($saving['target_amount'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('standard.savings.index') }}"
                       class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition">
                        Update Target
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Calculate and show progress preview
    function updateProgressPreview() {
        const targetAmount = parseFloat(document.getElementById('target_amount').value) || 0;
        const currentAmount = parseFloat(document.getElementById('current_amount').value) || 0;
        const progressPercentage = document.querySelector('.bg-gradient-to-r');

        if (targetAmount > 0) {
            const percentage = Math.min((currentAmount / targetAmount) * 100, 100);
            progressPercentage.style.width = percentage + '%';
            progressPercentage.parentElement.nextElementSibling.textContent =
                'Rp ' + currentAmount.toLocaleString('id-ID') + ' dari Rp ' + targetAmount.toLocaleString('id-ID');
        }
    }

    document.getElementById('target_amount').addEventListener('input', updateProgressPreview);
    document.getElementById('current_amount').addEventListener('input', updateProgressPreview);
</script>
@endsection
