@extends('layouts.admin')

@section('title', 'Financial Reports - Fintrack Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Financial Reports</h1>
        <div class="flex space-x-4">
            <select class="border border-gray-300 rounded-lg px-4 py-2">
                <option>All Reports</option>
                <option>Revenue Reports</option>
                <option>User Reports</option>
                <option>System Reports</option>
            </select>
           <form action="{{ route('admin.generateReport') }}" method="POST">
            @csrf
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Generate Report
            </button>
        </form>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Reports</h3>
            {{-- Mengambil total laporan bulan ini --}}
            <p class="text-3xl font-bold text-gray-800">{{ $reportStats['reports_this_month'] ?? 0 }}</p>
            <p class="text-gray-500 text-sm mt-2">Generated this month</p>
        </div>
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Revenue Reports</h3>
            {{-- Mengambil hitungan Revenue Reports --}}
            <p class="text-3xl font-bold text-green-600">{{ $reportStats['revenue_reports_count'] ?? 0 }}</p>
            <p class="text-gray-500 text-sm mt-2">Revenue & Transaction Reports</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl card-shadow overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $report['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report['type'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report['period'] }}
                        </td>
                        {{-- Logika untuk menampilkan Total Amount (kosong jika null) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $report['total_amount'] ? 'text-green-600' : 'text-gray-500' }}">
                            @if ($report['total_amount'] !== null)
                                Rp {{ number_format($report['total_amount'], 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report['generated_at'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
