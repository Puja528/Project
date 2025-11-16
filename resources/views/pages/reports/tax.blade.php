@extends('layouts.advance')

@section('title', 'Perencanaan Pajak - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Tax Planning & Calculation</h1>
        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            💾 Simpan Perhitungan
        </button>
    </div>

    <!-- Tax Summary -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Penghasilan Kena Pajak</h3>
            <p class="text-2xl font-bold text-yellow-400 mt-2">
                Rp {{ number_format($taxData['taxable_income'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">PPh Terutang</h3>
            <p class="text-2xl font-bold text-red-400 mt-2">
                Rp {{ number_format($taxData['tax_owed'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">PPh Dibayar</h3>
            <p class="text-2xl font-bold text-blue-400 mt-2">
                Rp {{ number_format($taxData['tax_paid'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-gray-400 text-sm font-medium">Kurang/Lebih Bayar</h3>
            <p class="text-2xl font-bold
                {{ ($taxData['tax_owed'] - $taxData['tax_paid']) >= 0 ? 'text-red-400' : 'text-green-400' }} mt-2">
                Rp {{ number_format($taxData['tax_owed'] - $taxData['tax_paid'], 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Tax Calculation -->
    <div class="grid md:grid-cols-2 gap-8 mb-8">
        <!-- Income Breakdown -->
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">📊 Penghasilan & Pengurangan</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Penghasilan Bruto</span>
                    <span class="text-green-400 font-semibold">
                        Rp {{ number_format($taxData['annual_income'], 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">Biaya Jabatan (5%)</span>
                    <span class="text-red-400 font-semibold">
                        -Rp {{ number_format($taxData['annual_income'] * 0.05, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">PTKP</span>
                    <span class="text-red-400 font-semibold">-Rp 54,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-yellow-900 rounded-lg border border-yellow-700">
                    <span class="text-yellow-200 font-semibold">Penghasilan Kena Pajak</span>
                    <span class="text-yellow-200 font-semibold">
                        Rp {{ number_format($taxData['taxable_income'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Tax Brackets -->
        <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">🎯 Tarif PPh Pasal 17</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">0 - 60 JT (5%)</span>
                    <span class="text-blue-400 font-semibold">Rp 3,000,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">60 - 250 JT (15%)</span>
                    <span class="text-blue-400 font-semibold">Rp 28,500,000</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">250 - 500 JT (25%)</span>
                    <span class="text-blue-400 font-semibold">Rp 0</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-750 rounded-lg">
                    <span class="text-gray-300">> 500 JT (30%)</span>
                    <span class="text-blue-400 font-semibold">Rp 0</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-900 rounded-lg border border-red-700">
                    <span class="text-red-200 font-semibold">Total PPh Terutang</span>
                    <span class="text-red-200 font-semibold">
                        Rp {{ number_format($taxData['tax_owed'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tax Planning Strategies -->
    <div class="bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">💡 Tax Planning Strategies</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-750 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-green-400 mb-3">✅ Recommended Actions</h3>
                <ul class="text-gray-300 space-y-2">
                    <li>• Maximize business expense deductions</li>
                    <li>• Consider tax-advantaged investments</li>
                    <li>• Optimize depreciation schedules</li>
                    <li>• Utilize tax loss harvesting</li>
                </ul>
            </div>
            <div class="bg-gray-750 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-yellow-400 mb-3">📅 Important Deadlines</h3>
                <ul class="text-gray-300 space-y-2">
                    <li>• PPh 25: Monthly by 15th</li>
                    <li>• PPh 29: Annual by March 31st</li>
                    <li>• VAT: Monthly by end of month</li>
                    <li>• SPT Tahunan: March 31st</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tax Savings Opportunities -->
    <div class="mt-8 bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-700">
        <h2 class="text-xl font-bold text-white mb-6">💰 Tax Savings Opportunities</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Opportunity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Potential Savings</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Implementation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Priority</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 text-sm text-white">Business Expense Optimization</td>
                        <td class="px-6 py-4 text-sm text-green-400">Rp 5,000,000</td>
                        <td class="px-6 py-4 text-sm text-gray-300">Immediate</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-200">High</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-white">Tax-Advantaged Investments</td>
                        <td class="px-6 py-4 text-sm text-green-400">Rp 3,500,000</td>
                        <td class="px-6 py-4 text-sm text-gray-300">Q1 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-200">Medium</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
