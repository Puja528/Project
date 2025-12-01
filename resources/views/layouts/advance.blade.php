<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fintrack Advance - Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --gradient-start: #8B5CF6;
            --gradient-end: #EC4899;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        }

        .dark-bg {
            background: #0F172A;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .urgent-important {
            border-left: 4px solid #EF4444;
        }

        .not-urgent-important {
            border-left: 4px solid #8B5CF6;
        }

        .urgent-not-important {
            border-left: 4px solid #F59E0B;
        }

        .not-urgent-not-important {
            border-left: 4px solid #10B981;
        }
    </style>
</head>

<body class="dark-bg">
    <!-- Navigation Header -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Fintrack <span class="text-pink-200">Advance</span></h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('home.advance') }}"
                            class="hover:text-pink-200 transition {{ request()->routeIs('home.advance') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('advance.budgets.index') }}"
                            class="hover:text-pink-200 transition {{ request()->routeIs('budgets.*') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Anggaran
                        </a>
                        <a href="{{ route('advance.investments.index') }}"
                            class="hover:text-pink-200 transition {{ request()->routeIs('investments.*') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Investasi
                        </a>
                        <a href="{{ route('advance.debts.index') }}"
                            class="hover:text-pink-200 transition {{ request()->routeIs('debts.*') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Hutang & Piutang
                        </a>
                        <a href="{{ route('advance.reports.index') }}"
                            class="hover:text-pink-200 transition {{ request()->routeIs('reports.*') ? 'text-pink-200 font-semibold border-b-2 border-pink-200' : '' }}">
                            Laporan
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-pink-200 text-sm font-semibold">{{ session('username') }}</p>
                        <p class="text-pink-100 text-xs">(Advance Business)</p>
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
    <main class="min-h-screen text-white">
        @yield('content')
    </main>

    <!-- WhatsApp Button -->
    @include('components.whatsapp-button')

    @stack('scripts')
</body>

</html>
