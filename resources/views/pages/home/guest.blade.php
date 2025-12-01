<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintrack - Kelola Keuangan dengan Mudah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --gradient-start: #8B5CF6;
            --gradient-end: #EC4899;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Fintrack</h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('home.guest') }}" class="hover:text-pink-200 transition">Home</a>
                        <a href="{{ route('features') }}" class="hover:text-pink-200 transition">Fitur</a>
                        <a href="{{ route('testimonial') }}" class="hover:text-pink-200 transition">Testimoni</a>
                        <a href="{{ route('about') }}" class="hover:text-pink-200 transition">Tentang</a>
                        <a href="{{ route('contact') }}" class="hover:text-pink-200 transition">Kontak</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @if(session('logged_in'))
                        <!-- Jika user sudah login -->
                        <div class="text-right">
                            <p class="text-pink-200 text-sm font-semibold">{{ session('username') ?? 'User' }}</p>
                            <p class="text-pink-100 text-xs">
                                @if(session('user_type') === 'admin')
                                    Administrator
                                @elseif(session('user_type') === 'advance')
                                    Advance User
                                @else
                                    Standard User
                                @endif
                            </p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <!-- Jika user belum login -->
                        <a href="{{ route('login.index') }}" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
                            Login
                        </a>
                        <a href="{{ route('signup.index') }}" class="bg-transparent border border-white text-white px-4 py-2 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition text-sm">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="gradient-bg text-white py-20">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Kelola Keuangan dengan Lebih Bijak</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Fintrack membantu Anda mengatur keuangan pribadi dan bisnis dengan fitur lengkap dan analisis mendalam.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('signup.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition text-lg">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('features') }}" class="bg-transparent border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition text-lg">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Preview -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Fitur Unggulan</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">📊</div>
                        <h3 class="text-xl font-semibold mb-2">Analisis Keuangan</h3>
                        <p class="text-gray-600">Dapatkan insight lengkap tentang kondisi keuangan Anda</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">🎯</div>
                        <h3 class="text-xl font-semibold mb-2">Prioritas Eisenhower</h3>
                        <p class="text-gray-600">Kelola pengeluaran berdasarkan skala prioritas</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-4xl mb-4">💰</div>
                        <h3 class="text-xl font-semibold mb-2">Manajemen Budget</h3>
                        <p class="text-gray-600">Atur anggaran dan pantau pengeluaran dengan mudah</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gray-800 text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Siap Mengelola Keuangan Anda?</h2>
                <p class="text-xl mb-8">Bergabung dengan ribuan pengguna yang telah memperbaiki kondisi keuangan mereka</p>
                <a href="{{ route('signup.index') }}" class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition text-lg">
                    Daftar Gratis
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Fintrack. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
