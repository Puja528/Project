<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fintrack Admin - Dashboard')</title>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Header -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Fintrack <span class="text-yellow-300">Admin</span></h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.dashboard') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.users') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Users
                        </a>
                        <a href="{{ route('admin.transactions') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.transactions') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Transactions
                        </a>
                        <a href="{{ route('admin.analytics') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.analytics') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Analytics
                        </a>
                        <a href="{{ route('admin.reports') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.reports') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Reports
                        </a>
                        <a href="{{ route('admin.activity-logs') }}" 
                           class="hover:text-pink-200 transition {{ request()->routeIs('admin.activity-logs') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Activity Logs
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-pink-200 text-sm font-semibold">{{ session('username') }}</p>
                        <p class="text-pink-100 text-xs">(System Administrator)</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                               class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
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