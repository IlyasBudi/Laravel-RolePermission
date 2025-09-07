<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Heroicons -->
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/index.js" type="module"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Include Sidebar Component -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Include Navbar Component -->
            <x-navbar />

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    @if (session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Include Footer Component -->
            <x-footer />
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-25 lg:hidden"></div>
</body>
</html>