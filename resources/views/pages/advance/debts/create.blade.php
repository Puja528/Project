@extends('layouts.advance')

@section('title', 'Tambah Hutang/Piutang - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-400 mb-6">
            <a href="{{ route('advance.debts.index') }}" class="hover:text-purple-400 transition">Hutang & Piutang</a>
            <span class="mx-2">›</span>
            <span class="text-white">Tambah Data</span>
        </div>

        <h1 class="text-3xl font-bold text-white mb-6">Tambah Hutang/Piutang</h1>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <form action="{{ route('advance.debts.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipe -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Tipe *</label>
                        <select id="type" name="type" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="">Pilih Tipe</option>
                            <option value="piutang" {{ old('type') == 'piutang' ? 'selected' : '' }}>Piutang</option>
                            <option value="hutang" {{ old('type') == 'hutang' ? 'selected' : '' }}>Hutang</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Pihak -->
                    <div class="md:col-span-2">
                        <label for="person_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Pihak *</label>
                        <input type="text" id="person_name" name="person_name" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               placeholder="Nama orang/perusahaan"
                               value="{{ old('person_name') }}">
                        @error('person_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Awal -->
                    <div>
                        <label for="initial_amount" class="block text-sm font-medium text-gray-300 mb-2">
                            Jumlah Awal (Rp) *
                            <span class="text-xs text-gray-400">(Sebelum bunga)</span>
                        </label>
                        <input type="number" id="initial_amount" name="amount" required min="0"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               placeholder="1000000"
                               value="{{ old('amount') }}">
                        @error('amount')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">Jumlah pokok sebelum bunga</p>
                    </div>

                    <!-- Bunga -->
                    <div>
                        <label for="interest_rate" class="block text-sm font-medium text-gray-300 mb-2">Bunga (%)</label>
                        <input type="number" id="interest_rate" name="interest_rate" min="0" max="100" step="0.1"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               placeholder="0"
                               value="{{ old('interest_rate', 0) }}">
                        @error('interest_rate')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Jumlah (Auto-calculated) -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-300">Total Jumlah (Termasuk bunga)</p>
                                    <p id="total-amount-display" class="text-lg font-bold text-purple-400 mt-1">
                                        Rp 0
                                    </p>
                                </div>
                                <div class="text-sm text-gray-400">
                                    <span id="interest-amount">+ Rp 0 bunga</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Jumlah ini yang akan disimpan sebagai total hutang/piutang</p>
                    </div>

                    <!-- Jatuh Tempo -->
                    <div class="md:col-span-2">
                        <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">Jatuh Tempo *</label>
                        <input type="date" id="due_date" name="due_date" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               value="{{ old('due_date', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}">
                        @error('due_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                  placeholder="Deskripsi transaksi (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('advance.debts.index') }}"
                       class="w-full sm:w-auto bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Catatan -->
        <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-lg">
            <h3 class="text-sm font-medium text-gray-300 mb-2">Catatan:</h3>
            <ul class="text-sm text-gray-400 space-y-1">
                <li>• <span class="text-green-400">Piutang</span>: Uang yang dipinjamkan kepada pihak lain</li>
                <li>• <span class="text-red-400">Hutang</span>: Uang yang dipinjam dari pihak lain</li>
                <li>• <span class="text-blue-400">Active</span>: Masih berjalan/belum lunas</li>
                <li>• <span class="text-green-400">Paid</span>: Sudah lunas/dibayar</li>
                <li>• <span class="text-red-400">Overdue</span>: Melewati jatuh tempo</li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-calculate total amount with interest
    function calculateTotalAmount() {
        const initialAmount = parseFloat(document.getElementById('initial_amount').value) || 0;
        const interestRate = parseFloat(document.getElementById('interest_rate').value) || 0;

        // Calculate interest amount
        const interestAmount = (initialAmount * interestRate) / 100;
        const totalAmount = initialAmount + interestAmount;

        // Format to Indonesian Rupiah
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        // Update displays
        document.getElementById('total-amount-display').textContent = formatter.format(totalAmount);
        document.getElementById('interest-amount').textContent = `+ ${formatter.format(interestAmount)} bunga`;
    }

    // Add event listeners
    document.getElementById('initial_amount').addEventListener('input', calculateTotalAmount);
    document.getElementById('interest_rate').addEventListener('input', calculateTotalAmount);

    // Initialize calculation on page load
    document.addEventListener('DOMContentLoaded', calculateTotalAmount);

    // Set minimum date for due date to today
    document.getElementById('due_date').min = new Date().toISOString().split('T')[0];

    // Add validation for status based on due date
    document.getElementById('due_date').addEventListener('change', function() {
        const dueDate = new Date(this.value);
        const today = new Date();
        const statusSelect = document.getElementById('status');

        if (dueDate < today && statusSelect.value === 'active') {
            // Suggest changing status to overdue if due date is in the past
            if (confirm('Jatuh tempo sudah lewat. Ubah status menjadi Overdue?')) {
                statusSelect.value = 'overdue';
            }
        }
    });
</script>
@endpush
@endsection

@push('styles')
<style>
    .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 1;
        height: auto;
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
        .md\:col-span-2 {
            grid-column: span 1;
        }
    }
</style>
@endpush
