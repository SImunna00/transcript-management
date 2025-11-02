<!-- 1. CREATE ADMIN LAYOUT COMPONENT - resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        .sidebar-link {
            transition: all 0.3s ease;
        }
        .sidebar-link:hover {
            background-color: #f3f4f6;
            transform: translateX(4px);
        }
        .sidebar-link.active {
            background-color: #3b82f6;
            color: white;
        }
        .sidebar-link.active:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation Header -->
        <nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full top-0 z-50">
            <div class="max-w-full mx-auto px-4">
                <div class="flex justify-between h-16">
                    <!-- Left side - Logo and Title -->
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="flex-shrink-0 flex items-center ml-4 lg:ml-0">
                            <h1 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                                NSTU Admin Panel
                            </h1>
                        </div>
                    </div>

                    <!-- Center - Page Header -->
                    <div class="hidden lg:flex items-center">
                        @isset($header)
                            <div class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <!-- Right side - User menu and notifications -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="flex items-center text-gray-600 hover:text-gray-800 p-2 rounded-md hover:bg-gray-100">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">3</span>
                            </button>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 p-2 rounded-md hover:bg-gray-100">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                                <span class="hidden lg:block text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex pt-16">
            <!-- Sidebar -->
            <div id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out mt-16 lg:mt-0">
                <div class="flex flex-col h-full">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 lg:hidden">
                        <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                        <button id="sidebar-close" class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Sidebar Navigation -->
                    <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.transcript-requests.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.transcript-requests.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-file-alt mr-3 w-5"></i>
                            Transcript Requests
                        </a>

                        <a href="{{ route('admin.marksheets.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.marksheets.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-scroll mr-3 w-5"></i>
                            Marksheets
                        </a>

                        <a href="{{ route('admin.students.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.students.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-users mr-3 w-5"></i>
                            Students
                        </a>

                        <a href="{{ route('admin.courses.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.courses.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-book mr-3 w-5"></i>
                            Courses
                        </a>

                        <a href="{{ route('admin.marksheets.create') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.marksheets.create') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-chart-line mr-3 w-5"></i>
                            Marks Management
                        </a>

                        <a href="{{ route('admin.teachers.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.teachers.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-chalkboard-teacher mr-3 w-5"></i>
                            Teachers
                        </a>

                        <!-- Divider -->
                        <hr class="my-4 border-gray-200">

                        <!-- Reports Section -->
                        <div class="pt-4">
                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</h3>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.reports.transcripts') }}" 
                                   class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.reports.transcripts') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                                    <i class="fas fa-chart-bar mr-3 w-5"></i>
                                    Transcript Reports
                                </a>

                                <a href="{{ route('admin.reports.analytics') }}" 
                                   class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.reports.analytics') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                                    <i class="fas fa-analytics mr-3 w-5"></i>
                                    Analytics
                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="my-4 border-gray-200">

                        <!-- Settings Section -->
                        <div class="pt-4">
                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.settings.general') }}" 
                                   class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.general') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                                    <i class="fas fa-cog mr-3 w-5"></i>
                                    General Settings
                                </a>

                                <a href="{{ route('admin.settings.academic') }}" 
                                   class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.academic') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                                    <i class="fas fa-university mr-3 w-5"></i>
                                    Academic Settings
                                </a>

                                <a href="{{ route('admin.settings.permissions') }}" 
                                   class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.permissions') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                                    <i class="fas fa-shield-alt mr-3 w-5"></i>
                                    Permissions
                                </a>
                            </div>
                        </div>
                    </nav>

                    <!-- Sidebar Footer -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-university text-white"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">NSTU</p>
                                <p class="text-xs text-gray-500">Admin Panel v2.0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Overlay for Mobile -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 lg:hidden hidden z-30"></div>

            <!-- Main Content -->
            <main class="flex-1 lg:ml-0">
                <!-- Page Content -->
                <div class="min-h-screen">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on links in mobile
            const sidebarLinks = document.querySelectorAll('#sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>

<!-- 2. ALTERNATIVE SIMPLER VERSION - resources/views/layouts/admin.blade.php -->

