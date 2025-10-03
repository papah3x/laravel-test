<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
    <body class="bg-gray-100 antialiased">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-sidebar flex flex-col">
                <!-- Brand / Logo -->
                <div class="p-6 border-b border-sidebar-border">
                    <a href="{{ route('manager.dashboard') }}" class="flex items-center justify-center">
                        <x-application-logo class="h-18" />
                    </a>
                </div>
                <!-- Profile Section -->
                <div class="p-6 border-b border-sidebar-border">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-white text-sm truncate">{{ Auth::user()->name ?? 'Manager' }}</div>
                            <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('manager.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('manager.dashboard') ? 'bg-primary-500 text-white' : 'text-gray-300 hover:bg-sidebar-light hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>All Properties</span>
                </a>
                <a href="{{ route('manager.properties.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('manager.properties.create') ? 'bg-primary-500 text-white' : 'text-gray-300 hover:bg-sidebar-light hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add Property</span>
                </a>
                
                <!-- Bookings Section -->
                <div class="pt-4 pb-2">
                    <div class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bookings</div>
                </div>
                <a href="{{ route('manager.bookings.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('manager.bookings.index') ? 'bg-primary-500 text-white' : 'text-gray-300 hover:bg-sidebar-light hover:text-white' }} transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            @php
                                $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="absolute -top-1 -right-2 min-w-[1rem] h-4 px-1 rounded-full bg-red-500 text-white text-[10px] leading-4 text-center">{{ $pendingCount }}</span>
                            @endif
                        </div>
                        <span>All Bookings</span>
                    </div>
                </a>
                <a href="{{ route('manager.bookings.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('manager.bookings.create') ? 'bg-primary-500 text-white' : 'text-gray-300 hover:bg-sidebar-light hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Create Booking</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-sidebar-border">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-red-600 hover:text-white transition-colors w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <div class="h-full">
                <div class="max-w-7xl mx-auto px-6 py-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>