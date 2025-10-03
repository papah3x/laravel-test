@if(!request()->ajax())
    @extends('layouts.manager')
    @section('content')
    <div class="max-w-4xl w-full mx-auto py-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('manager.dashboard') }}" class="text-gray-500 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Property</h1>
            </div>
            <p class="text-sm text-gray-600 ml-8">Update the property details below</p>
        </div>
        
        <!-- Form -->
        @include('manager.partials.property-form')
    </div>
    @endsection
@else
    @include('manager.partials.property-form')
@endif
