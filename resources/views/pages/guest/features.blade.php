@extends('layouts.guest')

@section('title', 'Fitur - Fintrack')

@section('content')
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan Fintrack</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan semua fitur powerful yang akan membantu Anda mengelola keuangan
                dengan lebih efektif dan mencapai tujuan finansial dengan mudah.
            </p>
        </div>

        <!-- Main Features -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach($features as $feature)
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 card-shadow hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Feature Comparison -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 card-shadow mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Perbandingan Paket</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Standard Plan -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Standard</h3>
                        <div class="text-4xl font-bold text-purple-600">Free</div>
                        <p class="text-gray-600">Selamanya gratis</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Dashboard keuangan dasar</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Grafik pemasukan & pengeluaran</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Matriks Eisenhower</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Laporan keuangan detail</span>
                        </li>
                    </ul>
                    <button class="w-full bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-300 transition">
                        Mulai Sekarang
                    </button>
                </div>

                <!-- Advance Plan -->
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-6 text-white relative card-shadow">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 px-4 py-1 rounded-bl-lg rounded-tr-xl text-sm font-semibold">
                        Recommended
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Advance</h3>
                        <div class="text-4xl font-bold">Rp 99k<span class="text-lg">/bulan</span></div>
                        <p>Untuk bisnis yang serius</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Semua fitur Standard</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Laporan keuangan detail</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Analisis prediktif</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Support priority 24/7</span>
                        </li>
                    </ul>
                    <button class="w-full bg-white text-purple-600 font-semibold py-3 rounded-lg hover:bg-gray-100 transition">
                        Upgrade Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Feature Highlights -->
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Dashboard yang Powerful</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Kelola semua aspek keuangan Anda dalam satu dashboard yang intuitif.
                    Pantau pemasukan, pengeluaran, investasi, dan tabungan dengan visualisasi
                    yang mudah dipahami.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Real-time financial tracking</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Customizable financial goals</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Multi-currency support</span>
                    </li>
                </ul>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 card-shadow">
                <div class="text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Visualisasi Data Real-time</h3>
                    <p class="text-gray-600">Lihat perkembangan keuangan Anda dengan grafik interaktif dan laporan detail</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-12 text-white card-shadow">
            <h2 class="text-3xl font-bold mb-4">Siap Mengubah Cara Anda Mengelola Keuangan?</h2>
            <p class="text-xl mb-8 opacity-90">Bergabung dengan ribuan pengguna yang telah mempercayai Fintrack</p>
            <div class="space-x-4">
                <a href="{{ route('signup.index') }}"
                   class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition inline-block">
                    Mulai Gratis
                </a>
                <a href="{{ route('contact') }}"
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-purple-600 transition inline-block">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
