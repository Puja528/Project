@extends('layouts.guest')

@section('title', 'Fintrack - Kelola Keuangan dengan Mudah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50">
    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Kelola Keuangan dengan <span class="text-pink-200">Fintrack</span></h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Platform pengelolaan keuangan modern untuk membantu Anda mencapai tujuan finansial dengan mudah dan efektif.
                Mulai perjalanan menuju kebebasan finansial hari ini!
            </p>
            <div class="flex justify-center space-x-4 flex-wrap gap-4">
                <a href="{{ route('signup.index') }}" 
                   class="bg-white text-purple-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg">
                    🚀 Mulai Sekarang - Gratis
                </a>
                <a href="{{ route('features') }}" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-purple-600 transition">
                    📋 Pelajari Fitur
                </a>
            </div>
            <div class="mt-8 text-pink-200">
                <p>✔️ Tidak perlu kartu kredit • ✔️ Gratis selamanya • ✔️ 10,000+ pengguna</p>
            </div>
        </div>
    </section>

    <!-- Features Preview -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Mengapa Memilih Fintrack?</h2>
            <p class="text-xl text-center text-gray-600 mb-12 max-w-3xl mx-auto">
                Platform all-in-one untuk semua kebutuhan pengelolaan keuangan pribadi dan bisnis Anda
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-xl font-bold mb-3">Analisis Real-time</h3>
                    <p class="text-gray-600">Pantau kondisi keuangan Anda dengan analisis mendalam dan laporan real-time yang akurat</p>
                </div>
                <div class="text-center p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-xl font-bold mb-3">Prioritas Cerdas</h3>
                    <p class="text-gray-600">Kelola pengeluaran dengan sistem prioritas Eisenhower yang terbukti efektif</p>
                </div>
                <div class="text-center p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold mb-3">Target Tabungan</h3>
                    <p class="text-gray-600">Raih tujuan finansial dengan sistem target tabungan yang terstruktur dan termonitor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 gradient-bg text-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <p class="opacity-90">Pengguna Aktif</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">95%</div>
                    <p class="opacity-90">Kepuasan Pengguna</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">50+</div>
                    <p class="opacity-90">Kota di Indonesia</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">4.8/5</div>
                    <p class="opacity-90">Rating Aplikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Cara Kerja Fintrack</h2>
            <p class="text-xl text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Hanya dalam 3 langkah sederhana, kelola keuangan menjadi lebih mudah
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-bold mb-3">Daftar Akun</h3>
                    <p class="text-gray-600">Buat akun gratis dalam 30 detik. Tidak perlu kartu kredit</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-bold mb-3">Input Data Keuangan</h3>
                    <p class="text-gray-600">Masukkan pemasukan, pengeluaran, dan target tabungan Anda</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-bold mb-3">Pantau & Analisis</h3>
                    <p class="text-gray-600">Lihat dashboard dan dapatkan insight untuk keputusan finansial yang lebih baik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Preview -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Apa Kata Pengguna Kami</h2>
            <p class="text-xl text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Ribuan pengguna telah merasakan manfaat Fintrack dalam kehidupan finansial mereka
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @php
                    $featuredTestimonials = [
                        [
                            'name' => 'Ahmad Rizki',
                            'position' => 'Freelancer',
                            'content' => 'Fintrack membantu saya mengelola keuangan dengan sangat baik.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Sari Dewi', 
                            'position' => 'Business Owner',
                            'content' => 'Sebagai pemilik bisnis, Fintrack memberikan insight yang valuable.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Budi Santoso',
                            'position' => 'Karyawan Swasta', 
                            'content' => 'Saya bisa menabung lebih teratur sejak menggunakan Fintrack.',
                            'rating' => 5
                        ]
                    ];
                @endphp
                @foreach($featuredTestimonials as $testimonial)
                <div class="bg-gray-50 rounded-xl p-6 card-shadow">
                    <div class="flex text-yellow-400 mb-4">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                            ⭐
                        @endfor
                    </div>
                    <p class="text-gray-600 italic mb-4">"{{ $testimonial['content'] }}"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-semibold text-sm">{{ substr($testimonial['name'], 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $testimonial['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $testimonial['position'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('testimonial') }}" class="text-purple-600 font-semibold hover:text-purple-700 transition">
                    Lihat Semua Testimoni →
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 gradient-bg text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Mengubah Cara Anda Mengelola Keuangan?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Bergabung dengan ribuan pengguna yang telah memperbaiki kondisi finansial mereka dengan Fintrack
            </p>
            <div class="flex justify-center space-x-4 flex-wrap gap-4">
                <a href="{{ route('signup.index') }}" 
                   class="bg-white text-purple-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg">
                    📝 Daftar Gratis Sekarang
                </a>
                <a href="{{ route('features') }}" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-purple-600 transition">
                    🔍 Lihat Fitur Lengkap
                </a>
            </div>
            <div class="mt-8 text-pink-200 text-sm">
                <p>✅ Setup dalam 2 menit • ✅ Tidak perlu download • ✅ Akses dari mana saja</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Pertanyaan Umum</h2>
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah Fintrack benar-benar gratis?</h3>
                    <p class="text-gray-600">Ya, paket Standard Fintrack gratis selamanya dengan fitur-fitur dasar yang lengkap untuk pengelolaan keuangan pribadi.</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Bagaimana cara mulai menggunakan Fintrack?</h3>
                    <p class="text-gray-600">Cukup daftar akun gratis, input data keuangan Anda, dan langsung bisa menggunakan semua fitur yang tersedia.</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah data saya aman?</h3>
                    <p class="text-gray-600">Sangat aman! Kami menggunakan enkripsi tingkat tinggi dan tidak pernah membagikan data Anda ke pihak ketiga.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection