@extends('layouts.standard')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Transaksi Baru</h1>
            <p class="text-gray-600">Catat pemasukan atau pengeluaran Anda</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('standard.transactions.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="type" value="income" class="text-purple-600 focus:ring-purple-500" required>
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-gray-900">Pemasukan</span>
                                    <span class="block text-sm text-gray-500">Uang masuk</span>
                                </span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="type" value="expense" class="text-purple-600 focus:ring-purple-500" required>
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-gray-900">Pengeluaran</span>
                                    <span class="block text-sm text-gray-500">Uang keluar</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" name="description" id="description" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" name="amount" id="amount" min="0" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Pilih Kategori</option>
                            <optgroup label="Pemasukan">
                                @foreach($categories['income'] as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Pengeluaran">
                                @foreach($categories['expense'] as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" id="date" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                               value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('standard.transactions.index') }}"
                       class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update kategori berdasarkan tipe transaksi
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const type = this.value;
            const categorySelect = document.getElementById('category');
            const currentValue = categorySelect.value;

            categorySelect.innerHTML = '<option value="">Pilih Kategori</option>';

            if (type === 'income') {
                categorySelect.innerHTML += '<optgroup label="Pemasukan">';
                @foreach($categories['income'] as $category)
                categorySelect.innerHTML += '<option value="{{ $category }}">{{ $category }}</option>';
                @endforeach
            } else {
                categorySelect.innerHTML += '<optgroup label="Pengeluaran">';
                @foreach($categories['expense'] as $category)
                categorySelect.innerHTML += '<option value="{{ $category }}">{{ $category }}</option>';
                @endforeach
            }

            // Restore previous value if it exists in the new options
            if (currentValue) {
                const options = Array.from(categorySelect.options);
                const exists = options.some(option => option.value === currentValue);
                if (exists) {
                    categorySelect.value = currentValue;
                }
            }
        });
    });
</script>
@endsection
