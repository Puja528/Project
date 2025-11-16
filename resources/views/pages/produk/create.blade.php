@extends('layouts.app')

@section('title', 'Tambah Produk - Fintrack')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('produk.index') }}" class="flex items-center text-purple-600 hover:text-purple-700 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Nama Produk -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk *
                    </label>
                    <input type="text"
                           id="nama"
                           name="nama"
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                           placeholder="Masukkan nama produk"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                              placeholder="Tambahkan deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga (Rp) *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number"
                                   id="harga"
                                   name="harga"
                                   value="{{ old('harga') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                            Stok *
                        </label>
                        <input type="number"
                               id="stok"
                               name="stok"
                               value="{{ old('stok', 0) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                               placeholder="0"
                               required>
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori *
                        </label>
                        <select id="kategori"
                                name="kategori"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategories as $key => $value)
                                <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan *
                        </label>
                        <select id="satuan"
                                name="satuan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                required>
                            <option value="">Pilih Satuan</option>
                            @foreach($satuans as $key => $value)
                                <option value="{{ $key }}" {{ old('satuan') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Barcode -->
                <div>
                    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
                        Barcode
                    </label>
                    <input type="text"
                           id="barcode"
                           name="barcode"
                           value="{{ old('barcode') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                           placeholder="Kode barcode (opsional)">
                    @error('barcode')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="status"
                               value="1"
                               {{ old('status', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Produk Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('produk.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium text-center">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
