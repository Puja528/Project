@extends('layouts.standard')

@section('title', 'Catatan Keuangan - Eisenhower Matrix')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Catatan Keuangan</h1>
            <p class="text-gray-600">Kelola prioritas keuangan dengan Eisenhower Matrix</p>
        </div>
        <a href="{{ route('standard.financial-notes.create') }}"
           class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition">
            + Tambah Catatan
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Export Button -->
    <div class="mb-6">
        <form action="{{ route('standard.export.basic') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="export_type" value="financial_notes">
            <input type="hidden" name="start_date" value="{{ date('Y-m-01') }}">
            <input type="hidden" name="end_date" value="{{ date('Y-m-t') }}">
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                📊 Ekspor Data Catatan
            </button>
        </form>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('standard.financial-notes.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        placeholder="Cari judul, deskripsi...">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $category)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                    <select name="priority" id="priority" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Prioritas</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                        🔍 Terapkan Filter
                    </button>
                    <a href="{{ route('standard.financial-notes.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                        🔄 Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Eisenhower Matrix Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Quadrant 1: Urgent & Important -->
        <div class="bg-white rounded-lg shadow-md urgent-important">
            <div class="bg-red-600 text-white px-4 py-3 rounded-t-lg">
                <h3 class="font-semibold">Mendesak & Penting</h3>
                <p class="text-sm opacity-90">{{ $categories['urgent_important']['description'] }}</p>
            </div>
            <div class="p-4">
                @forelse($financialNotes->where('category', 'urgent_important') as $note)
                <div class="border border-red-200 rounded-lg p-4 mb-3 bg-red-50">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-800">{{ $note->title }}</h4>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Rp {{ number_format($note->amount, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $note->description }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}</span>
                        <span class="capitalize">{{ $note->priority }}</span>
                    </div>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('standard.financial-notes.edit', $note->id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        <form action="{{ route('standard.financial-notes.destroy', $note->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <div class="text-4xl mb-2">⚡</div>
                    <p>Tidak ada item</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quadrant 2: Not Urgent & Important -->
        <div class="bg-white rounded-lg shadow-md not-urgent-important">
            <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg">
                <h3 class="font-semibold">Tidak Mendesak & Penting</h3>
                <p class="text-sm opacity-90">{{ $categories['not_urgent_important']['description'] }}</p>
            </div>
            <div class="p-4">
                @forelse($financialNotes->where('category', 'not_urgent_important') as $note)
                <div class="border border-blue-200 rounded-lg p-4 mb-3 bg-blue-50">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-800">{{ $note->title }}</h4>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Rp {{ number_format($note->amount, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $note->description }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}</span>
                        <span class="capitalize">{{ $note->priority }}</span>
                    </div>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('standard.financial-notes.edit', $note->id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        <form action="{{ route('standard.financial-notes.destroy', $note->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <div class="text-4xl mb-2">📈</div>
                    <p>Tidak ada item</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quadrant 3: Urgent & Not Important -->
        <div class="bg-white rounded-lg shadow-md urgent-not-important">
            <div class="bg-yellow-600 text-white px-4 py-3 rounded-t-lg">
                <h3 class="font-semibold">Mendesak & Tidak Penting</h3>
                <p class="text-sm opacity-90">{{ $categories['urgent_not_important']['description'] }}</p>
            </div>
            <div class="p-4">
                @forelse($financialNotes->where('category', 'urgent_not_important') as $note)
                <div class="border border-yellow-200 rounded-lg p-4 mb-3 bg-yellow-50">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-800">{{ $note->title }}</h4>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Rp {{ number_format($note->amount, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $note->description }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}</span>
                        <span class="capitalize">{{ $note->priority }}</span>
                    </div>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('standard.financial-notes.edit', $note->id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        <form action="{{ route('standard.financial-notes.destroy', $note->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <div class="text-4xl mb-2">🕒</div>
                    <p>Tidak ada item</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quadrant 4: Not Urgent & Not Important -->
        <div class="bg-white rounded-lg shadow-md not-urgent-not-important">
            <div class="bg-green-600 text-white px-4 py-3 rounded-t-lg">
                <h3 class="font-semibold">Tidak Mendesak & Tidak Penting</h3>
                <p class="text-sm opacity-90">{{ $categories['not_urgent_not_important']['description'] }}</p>
            </div>
            <div class="p-4">
                @forelse($financialNotes->where('category', 'not_urgent_not_important') as $note)
                <div class="border border-green-200 rounded-lg p-4 mb-3 bg-green-50">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-800">{{ $note->title }}</h4>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Rp {{ number_format($note->amount, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $note->description }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}</span>
                        <span class="capitalize">{{ $note->priority }}</span>
                    </div>
                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('standard.financial-notes.edit', $note->id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        <form action="{{ route('standard.financial-notes.destroy', $note->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <div class="text-4xl mb-2">🎯</div>
                    <p>Tidak ada item</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
