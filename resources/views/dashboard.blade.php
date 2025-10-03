<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar / Drawer -->
        <aside class="w-64 bg-white shadow-md">
            <nav class="p-6 space-y-4">
                <a href="{{ route('manager.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200">All Properties</a>
                <a href="{{ route('manager.properties.create') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Add Property</a>
                <!-- Add more links as needed -->
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('manager-content')
        </main>
    </div>
</x-app-layout>
