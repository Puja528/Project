<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fintrack - Kelola Keuangan Anda')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --gradient-start: #9146ff;
            --gradient-end: #c454e5;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Single Navigation untuk Guest -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Navigation -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Fintrack</h1>
                    <div class="hidden md:flex space-x-6">
                        <!-- Dashboard Link -->
                        <a href="{{ session('user_type') === 'standard' ? route('home.standard') : route('home.advance') }}"
                           class="hover:text-pink-200 transition {{ request()->routeIs('home.*') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Beranda
                        </a>
                        <!-- Public Pages -->
                        <a href="{{ route('features') }}"
                           class="hover:text-pink-200 transition {{ request()->routeIs('features') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Fitur
                        </a>
                        <a href="{{ route('about') }}"
                           class="hover:text-pink-200 transition {{ request()->routeIs('about') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Tentang
                        </a>
                        <a href="{{ route('testimonial') }}"
                           class="hover:text-pink-200 transition {{ request()->routeIs('testimonial') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Testimoni
                        </a>
                        <a href="{{ route('contact') }}"
                           class="hover:text-pink-200 transition {{ request()->routeIs('contact') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Kontak
                        </a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login.index') }}"
                       class="hover:text-pink-200 transition {{ request()->routeIs('login.*') ? 'text-pink-200 font-semibold' : '' }}">
                        Login
                    </a>
                    <a href="{{ route('signup.index') }}"
                       class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Button -->
    @include('components.whatsapp-button')

    @stack('scripts')
</body>
</html>
