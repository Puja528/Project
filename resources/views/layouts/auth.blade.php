<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fintrack - Authentication')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --gradient-start: #9146ff;
            --gradient-end: #c454e5;
            --purple: #7e56da;
            --background: #f9f9fb;
            --text-primary: #1f2937;
            --text-muted: #6b7280;
            --input-bg: #fff;
            --input-border: #d1d5db;
            --input-focus: #9146ff;
            --button-bg: #9146ff;
            --button-bg-hover: #7e56da;
            --link-color: #9146ff;
            --error-color: #dc2626;
            --success-color: #16a34a;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        }

        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .auth-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-2xl card-shadow p-8">
        <!-- Logo/Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center mb-4">
                <span class="text-white text-2xl font-bold">F</span>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">
                @yield('page-title')
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                @yield('page-subtitle')
            </p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content -->
        @yield('auth-content')

        <!-- Footer Links -->
        <div class="text-center">
            @yield('auth-footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
