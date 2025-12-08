@extends('layouts.advance')

@section('title', 'Manajemen Transaksi - Fintrack')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Manajemen Transaksi</h1>
            <a href="{{ route('advance.transactions.create') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                + Tambah Transaksi
            </a>
        </div>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan Eisenhower Matrix --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <h3 class="font-semibold text-gray-400">Penting & Mendesak</h3>
                <p class="text-2xl font-bold text-red-400">
                    {{ $counts['urgent_important'] ?? 0 }}
                </p>
                <p class="text-sm text-red-400">Transaksi</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <h3 class="font-semibold text-gray-400">Penting & Tidak Mendesak</h3>
                <p class="text-2xl font-bold text-blue-400">
                    {{ $counts['not_urgent_important'] ?? 0 }}
                </p>
                <p class="text-sm text-blue-400">Transaksi</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <h3 class="font-semibold text-gray-400">Mendesak & Tidak Penting</h3>
                <p class="text-2xl font-bold text-yellow-400">
                    {{ $counts['urgent_not_important'] ?? 0 }}
                </p>
                <p class="text-sm text-yellow-400">Transaksi</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <h3 class="font-semibold text-gray-400">Tidak Mendesak & Tidak Penting</h3>
                <p class="text-2xl font-bold text-green-400">
                    {{ $counts['not_urgent_not_important'] ?? 0 }}
                </p>
                <p class="text-sm text-green-400">Transaksi</p>
            </div>

        </div>

        {{-- Tabel transaksi --}}
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8">
            <h2 class="text-xl font-bold text-white mb-6">Daftar Transaksi</h2>

            {{-- Info jumlah data --}}
            <div class="mb-4 text-sm text-gray-400">
                Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Prioritas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-750">

                                {{-- Judul & deskripsi --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-white">{{ $transaction->title }}</div>
                                    @if($transaction->description)
                                        <div class="text-sm text-gray-400">{{ $transaction->description }}</div>
                                    @endif
                                </td>

                                {{-- Jumlah --}}
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                                    {{ $transaction->type === 'pemasukan' ? 'text-green-400' : 'text-red-400' }}">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($transaction->type === 'pemasukan')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-200">Pemasukan</span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-200">Pengeluaran</span>
                                    @endif
                                </td>

                                {{-- Kategori --}}
                                <td class="px-6 py-4 text-sm text-gray-300">
                                    {{ $categories[$transaction->category] ?? ucfirst($transaction->category) }}
                                </td>

                                {{-- Prioritas --}}
                                <td class="px-6 py-4">
                                    @if($transaction->priority === 'tinggi')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-200">
                                            Penting & Mendesak
                                        </span>

                                    @elseif($transaction->priority === 'sedang')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-200">
                                            Penting & Tidak Mendesak
                                        </span>

                                    @elseif($transaction->priority === 'rendah')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-200">
                                            Mendesak & Tidak Penting
                                        </span>

                                    @elseif($transaction->priority === 'tidak_penting')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-200">
                                            Tidak Mendesak & Tidak Penting
                                        </span>
                                    @endif
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-6 py-4 text-sm text-gray-400">
                                    {{ $transaction->date }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    Tidak ada transaksi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions->hasPages())
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

        {{-- Export --}}
        <div class="mt-6 flex justify-end">
            <form action="{{ route('export.basic') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition border border-gray-600">
                    📊 Ekspor Data
                </button>
            </form>
        </div>

    </div>
@endsection
