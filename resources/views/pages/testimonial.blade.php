@extends('layouts.guest')

@section('title', 'Testimoni - Fintrack')

@section('content')
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Pengguna Fintrack</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Dengarkan pengalaman langsung dari pengguna yang telah merasakan manfaat
                menggunakan Fintrack dalam mengelola keuangan mereka.
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach($testimonials as $testimonial)
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 card-shadow hover:shadow-xl transition-all duration-300 border border-gray-100">
                <!-- Rating Stars -->
                <div class="flex mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial['rating'])
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                </div>

                <!-- Testimonial Text -->
                <p class="text-gray-600 mb-6 leading-relaxed italic">
                    "{{ $testimonial['content'] }}"
                </p>

                <!-- User Info -->
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-semibold">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                        <p class="text-gray-500 text-sm">{{ $testimonial['position'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Stats Section -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-12 text-white card-shadow mb-16">
            <div class="grid md:grid-cols-4 gap-8 text-center">
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

        <!-- Video Testimonials Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Testimoni Video</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 card-shadow">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Video testimoni dari Budi Santoso</p>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Budi Santoso - Freelancer</h3>
                    <p class="text-gray-600">"Fintrack membantu saya mengatur cash flow dengan sangat baik!"</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-8 card-shadow">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Video testimoni dari Sari Dewi</p>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sari Dewi - Business Owner</h3>
                    <p class="text-gray-600">"Platform yang sangat membantu untuk pengambilan keputusan bisnis."</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Bergabunglah dengan Komunitas Fintrack</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Mulai perjalanan finansial Anda hari ini dan rasakan perbedaannya
            </p>
            <div class="space-x-4">
                <a href="{{ route('signup.index') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition inline-block">
                    Daftar Sekarang
                </a>
                <a href="{{ route('contact') }}"
                   class="border-2 border-purple-600 text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-purple-600 hover:text-white transition inline-block">
                    Tanya-tanya Dulu
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
