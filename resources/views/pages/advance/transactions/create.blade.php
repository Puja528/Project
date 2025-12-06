@extends('layouts.advance')

@section('title', 'Tambah Transaksi - Fintrack')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('advance.transactions.index') }}" class="text-purple-400 hover:text-purple-300 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-white mb-2">Tambah Transaksi Baru</h1>
                <p class="text-gray-400">Isi form berikut untuk mencatat transaksi baru</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
                <form action="{{ route('advance.transactions.store') }}" method="POST">
                    @if ($errors->any())
                        <div class="bg-red-600 text-white p-3 rounded-lg mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf

                    <div class="grid gap-6">

                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Judul Transaksi *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Contoh: Belanja Bulanan">
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Contoh: Belanja kebutuhan dapur"></textarea>
                        </div>

                        {{-- Jumlah & Tipe --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah (Rp) *</label>
                                <input type="number" name="amount" value="{{ old('amount') }}" required min="0"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                    placeholder="0">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Tipe *</label>
                                <select name="type" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Pilih Tipe</option>
                                    <option value="pemasukan">Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                        </div>

                        {{-- Kategori & Prioritas --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Kategori *</label>
                                <select name="category" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent">

                                    <option value="">Pilih Kategori</option>
                                    <option value="makanan">Makanan</option>
                                    <option value="transportasi">Transportasi</option>
                                    <option value="hiburan">Hiburan</option>
                                    <option value="kesehatan">Kesehatan</option>
                                    <option value="pendidikan">Pendidikan</option>
                                    <option value="belanja">Belanja</option>
                                    <option value="tagihan">Tagihan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Prioritas *</label>
                                <select name="priority" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Pilih Prioritas</option>
                                    <option value="rendah">Rendah</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="tinggi">Tinggi</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal *</label>
                            <input type="date" name="date" value="{{ old('date') }}" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        </div>

                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('advance.transactions.index') }}"
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
    </div>
@endsection
