<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fintrack - Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .urgent-important { border-left: 4px solid #ef4444; }
        .not-urgent-important { border-left: 4px solid #3b82f6; }
        .urgent-not-important { border-left: 4px solid #f59e0b; }
        .not-urgent-not-important { border-left: 4px solid #10b981; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Single Navigation Header -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Main Navigation -->
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

                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4">
                    @if(session('logged_in'))
                        <div class="text-right">
                            <p class="text-pink-200 text-sm font-semibold">{{ session('username') }}</p>
                            <p class="text-pink-100 text-xs">({{ session('user_type') }} user)</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                   class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.index') }}" class="hover:text-pink-200 transition">Login</a>
                        <a href="{{ route('signup.index') }}"
                           class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>

            <!-- Welcome Message (hanya untuk dashboard) -->
            @if(request()->routeIs('home.*') && session('logged_in'))
            <div class="border-t border-pink-300 pt-3 pb-2">
                <p class="text-pink-200 text-sm">
                    Selamat datang, <strong>{{ session('username') }}</strong>!
                    @if(session('user_type') === 'standard')
                        Nikmati fitur dasar pengelolaan keuangan.
                    @else
                        Nikmati fitur lengkap advance untuk bisnis Anda.
                    @endif
                </p>
            </div>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- WhatsApp Button -->
    @include('components.whatsapp-button')

    @stack('scripts')
</body>
</html>
