@extends('layouts.advance')

@section('title', 'Hutang & Piutang - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Hutang & Piutang</h1>
        <a href="{{ route('advance.debts.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Tambah Data
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Piutang</h3>
            <p class="text-2xl font-bold text-green-400 mt-2">
                Rp {{ number_format($totalPiutang, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Total Hutang</h3>
            <p class="text-2xl font-bold text-red-400 mt-2">
                Rp {{ number_format($totalHutang, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Net Position</h3>
            <p class="text-2xl font-bold {{ $netPosition >= 0 ? 'text-green-400' : 'text-red-400' }} mt-2">
                Rp {{ number_format($netPosition, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Tabel CRUD Hutang & Piutang -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700 mb-8">
        <h2 class="text-xl font-bold text-white mb-4">Daftar Hutang & Piutang</h2>

        @if($debts->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Pihak</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah (Rp)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Bunga (%)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($debts as $debt)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $debt->type === 'piutang' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                                {{ $debt->type === 'piutang' ? 'Piutang' : 'Hutang' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $debt->person_name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold {{ $debt->type === 'piutang' ? 'text-green-400' : 'text-red-400' }}">
                                Rp {{ number_format($debt->amount, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300 {{ $debt->is_overdue ? 'text-red-400 font-semibold' : '' }}">
                                {{ \Carbon\Carbon::parse($debt->due_date)->format('d/m/Y') }}
                                @if($debt->is_overdue)
                                <span class="ml-1 text-xs">(OVERDUE)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">
                                {{ $debt->interest_rate > 0 ? number_format($debt->interest_rate, 1) . '%' : '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $debt->status === 'active' ? 'bg-blue-900 text-blue-200' :
                                   ($debt->status === 'paid' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200') }}">
                                {{ ucfirst($debt->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-300 max-w-xs truncate">
                                {{ $debt->description ?: '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('advance.debts.edit', $debt->id) }}"
                                   class="text-blue-400 hover:text-blue-300 transition">
                                    Edit
                                </a>
                                <form action="{{ route('advance.debts.destroy', $debt->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-300 transition"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $debts->links() }}
        </div>
        @else
        <div class="text-center py-8">
            <div class="text-6xl mb-4">💳</div>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">Belum ada data hutang/piutang</h3>
            <p class="text-gray-500 mb-6">Kelola hutang dan piutang bisnis Anda</p>
            <a href="{{ route('advance.debts.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
                Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
