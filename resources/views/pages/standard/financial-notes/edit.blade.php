@extends('layouts.standard')

@section('title', 'Edit Catatan Keuangan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Catatan Keuangan</h1>
            <p class="text-gray-600">Perbarui prioritas pengeluaran</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('standard.financial-notes.update', $financialNote['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="title" id="title"
                               value="{{ $financialNote['title'] }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" name="amount" id="amount"
                               value="{{ $financialNote['amount'] }}" min="0" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Jatuh Tempo</label>
                        <input type="date" name="due_date" id="due_date"
                               value="{{ $financialNote['due_date'] }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Category -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Kategori Eisenhower</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($categories as $key => $category)
                            <label class="flex items-start p-4 border-2 {{ $financialNote['category'] === $key ? 'border-' . $category['color'] . '-500 bg-' . $category['color'] . '-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-{{ $category['color'] }}-500">
                                <input type="radio" name="category" value="{{ $key }}"
                                       {{ $financialNote['category'] === $key ? 'checked' : '' }}
                                       class="text-{{ $category['color'] }}-600 focus:ring-{{ $category['color'] }}-500 mt-1" required>
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-gray-900">{{ $category['name'] }}</span>
                                    <span class="block text-sm text-gray-500 mt-1">{{ $category['description'] }}</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                        <select name="priority" id="priority" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <option value="low" {{ $financialNote['priority'] === 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ $financialNote['priority'] === 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ $financialNote['priority'] === 'high' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <option value="pending" {{ $financialNote['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $financialNote['status'] === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $financialNote['status'] === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">{{ $financialNote['description'] }}</textarea>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('standard.financial-notes.index') }}"
                       class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition">
                        Update Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
