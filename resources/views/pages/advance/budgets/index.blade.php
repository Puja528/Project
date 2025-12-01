@extends('layouts.advance')

@section('title', 'Daftar Anggaran - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Daftar Anggaran</h1>
        <a href="{{ route('advance.budgets.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Anggaran
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Convert array to collection untuk perhitungan -->
    @php
        $budgetsCollection = collect($budgets);
    @endphp

    <!-- Summary Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-sm font-medium">Total Anggaran</h3>
                    <p class="text-2xl font-bold text-white mt-2">
                        Rp {{ number_format($budgetsCollection->sum('allocated_amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-purple-400">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-sm font-medium">Jumlah Anggaran</h3>
                    <p class="text-2xl font-bold text-white mt-2">
                        {{ $budgetsCollection->count() }}
                    </p>
                </div>
                <div class="text-blue-400">
                    <i class="fas fa-list-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-sm font-medium">Kategori</h3>
                    <p class="text-2xl font-bold text-white mt-2">
                        {{ $budgetsCollection->pluck('category')->unique()->count() }}
                    </p>
                </div>
                <div class="text-green-400">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-sm font-medium">Periode Aktif</h3>
                    <p class="text-2xl font-bold text-white mt-2">
                        {{ $budgetsCollection->pluck('period')->unique()->count() }}
                    </p>
                </div>
                <div class="text-yellow-400">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Anggaran -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Daftar Anggaran</h2>

            <!-- Filter Options -->
            <div class="flex space-x-4">
                <select id="categoryFilter" class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>

                <input type="month" id="periodFilter" class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-750 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Anggaran</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">Jumlah Alokasi</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($budgets as $b)
                    <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-750 transition duration-200 budget-row"
                        data-category="{{ $b['category'] }}"
                        data-period="{{ $b['period'] }}">
                        <td class="px-6 py-4 font-medium text-white whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                {{ $b['budget_name'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($b['category'] === 'makanan') bg-green-900 text-green-200
                                @elseif($b['category'] === 'transportasi') bg-blue-900 text-blue-200
                                @elseif($b['category'] === 'hiburan') bg-yellow-900 text-yellow-200
                                @elseif($b['category'] === 'kesehatan') bg-red-900 text-red-200
                                @elseif($b['category'] === 'pendidikan') bg-indigo-900 text-indigo-200
                                @else bg-gray-700 text-gray-300
                                @endif">
                                {{ $categories[$b['category']] ?? ucfirst($b['category']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-700 text-gray-300">
                                {{ \Carbon\Carbon::parse($b['period'] . '-01')->format('M Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-white">
                            Rp {{ number_format($b['allocated_amount'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-gray-300 truncate" title="{{ $b['description'] ?? '-' }}">
                                    {{ $b['description'] ? Str::limit($b['description'], 50) : '-' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('advance.budgets.edit', $b['id']) }}"
                                   class="text-blue-400 hover:text-blue-300 transition duration-200 p-2 rounded-lg hover:bg-blue-900/20"
                                   title="Edit Anggaran">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('advance.budgets.destroy', $b['id']) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggaran {{ $b['budget_name'] }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-300 transition duration-200 p-2 rounded-lg hover:bg-red-900/20"
                                            title="Hapus Anggaran">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="text-center py-8">
                                <i class="fas fa-wallet text-5xl text-gray-600 mb-4"></i>
                                <p class="text-gray-400 text-lg mb-2">Belum ada anggaran</p>
                                <p class="text-gray-500 text-sm">Mulai dengan membuat anggaran pertama Anda</p>
                                <a href="{{ route('advance.budgets.create') }}"
                                   class="inline-block mt-4 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                                    Buat Anggaran Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats -->
    @if($budgetsCollection->count() > 0)
    <div class="grid md:grid-cols-2 gap-6 mt-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">Distribusi Kategori</h3>
            <div class="space-y-3">
                @php
                    $categoryTotals = [];
                    foreach($budgets as $b) {
                        $categoryTotals[$b['category']] = ($categoryTotals[$b['category']] ?? 0) + $b['allocated_amount'];
                    }
                    arsort($categoryTotals);
                @endphp
                @foreach($categoryTotals as $category => $total)
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">{{ $categories[$category] ?? ucfirst($category) }}</span>
                    <span class="text-white font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">Anggaran per Periode</h3>
            <div class="space-y-3">
                @php
                    $periodTotals = [];
                    foreach($budgets as $b) {
                        $periodTotals[$b['period']] = ($periodTotals[$b['period']] ?? 0) + $b['allocated_amount'];
                    }
                    krsort($periodTotals);
                @endphp
                @foreach($periodTotals as $period => $total)
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">{{ \Carbon\Carbon::parse($period . '-01')->format('F Y') }}</span>
                    <span class="text-white font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.card-shadow {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.budget-row {
    transition: all 0.2s ease-in-out;
}

.budget-row:hover {
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const periodFilter = document.getElementById('periodFilter');
    const budgetRows = document.querySelectorAll('.budget-row');

    function filterBudgets() {
        const selectedCategory = categoryFilter.value;
        const selectedPeriod = periodFilter.value;

        budgetRows.forEach(row => {
            const rowCategory = row.getAttribute('data-category');
            const rowPeriod = row.getAttribute('data-period');

            const categoryMatch = !selectedCategory || rowCategory === selectedCategory;
            const periodMatch = !selectedPeriod || rowPeriod === selectedPeriod;

            if (categoryMatch && periodMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', filterBudgets);
    periodFilter.addEventListener('change', filterBudgets);
});
</script>
@endsection
