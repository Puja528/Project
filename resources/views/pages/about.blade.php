@extends('layouts.guest')

@section('title', 'Tentang Kami - Fintrack')

@section('content')
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Tentang Fintrack</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Platform pengelolaan keuangan modern yang membantu UMKM dan individu
                mencapai stabilitas finansial dengan tools yang powerful dan mudah digunakan.
            </p>
        </div>

        <!-- Visi Misi -->
        <div class="grid md:grid-cols-2 gap-12 mb-16">
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 card-shadow">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi platform terdepan dalam membantu masyarakat Indonesia
                    mencapai kemandirian finansial melalui teknologi yang inovatif
                    dan mudah diakses oleh semua kalangan.
                </p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 card-shadow">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>• Menyediakan tools pengelolaan keuangan yang mudah digunakan</li>
                    <li>• Edukasi literasi finansial untuk semua usia</li>
                    <li>• Inovasi terus menerus dalam fitur dan teknologi</li>
                    <li>• Membangun komunitas yang saling mendukung</li>
                </ul>
            </div>
        </div>

        <!-- Timeline Perkembangan -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Perjalanan Kami</h2>
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-purple-200 h-full"></div>

                <!-- Timeline Items -->
                <div class="space-y-12">
                    <div class="flex items-center">
                        <div class="w-1/2 pr-8 text-right">
                            <h3 class="text-xl font-bold text-gray-900">2022</h3>
                            <p class="text-gray-600">Ide awal Fintrack terbentuk</p>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-600 rounded-full"></div>
                        <div class="w-1/2 pl-8"></div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-1/2 pr-8"></div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-600 rounded-full"></div>
                        <div class="w-1/2 pl-8">
                            <h3 class="text-xl font-bold text-gray-900">Q1 2023</h3>
                            <p class="text-gray-600">Pengembangan platform pertama</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-1/2 pr-8 text-right">
                            <h3 class="text-xl font-bold text-gray-900">Q3 2023</h3>
                            <p class="text-gray-600">Launch versi beta dengan 1000+ users</p>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-600 rounded-full"></div>
                        <div class="w-1/2 pl-8"></div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-1/2 pr-8"></div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-600 rounded-full"></div>
                        <div class="w-1/2 pl-8">
                            <h3 class="text-xl font-bold text-gray-900">2024</h3>
                            <p class="text-gray-600">Ekspansi fitur dan peningkatan user experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-gray-50 rounded-2xl p-12">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Tim Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">BS</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Budi Santoso</h3>
                    <p class="text-purple-600 font-semibold">CEO & Founder</p>
                    <p class="text-gray-600 mt-2">Pengalaman 10+ tahun di fintech dan financial planning</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">SD</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Sari Dewi</h3>
                    <p class="text-purple-600 font-semibold">CTO</p>
                    <p class="text-gray-600 mt-2">Expert dalam software architecture dan system development</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-teal-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">AR</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Ahmad Rizki</h3>
                    <p class="text-purple-600 font-semibold">Head of Product</p>
                    <p class="text-gray-600 mt-2">Fokus pada user experience dan product innovation</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
