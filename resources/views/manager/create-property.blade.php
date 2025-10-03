@extends('layouts.manager')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <a href="{{ route('manager.dashboard') }}" class="text-gray-500 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Add New Property</h1>
        </div>
        <p class="text-sm text-gray-600 ml-8">Fill in the details below to create a new property listing</p>
    </div>

    <!-- Form -->
    <div class="max-w-4xl w-full mx-auto">
        <form method="POST" action="{{ route('manager.properties.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow border border-gray-200 p-6 space-y-5">
            @csrf
            
            <!-- Form Actions - Moved to top -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Property Details</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('manager.dashboard') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center space-x-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Create Property</span>
                    </button>
                </div>
            </div>

            <!-- Property Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
Property Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="e.g., Luxury Beach Villa"
                    >
                </div>
                @error('name') 
                    <p class="mt-1.5 text-xs text-red-600 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    required 
                    rows="4"
                    class="block w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                    placeholder="Describe your property, its features, amenities, and what makes it special..."
                >{{ old('description') }}</textarea>
                @error('description') 
                    <p class="mt-1.5 text-xs text-red-600 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price_per_night" class="block text-sm font-semibold text-gray-900 mb-2">
                    Price per Night <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-600 font-semibold text-sm">€</span>
                    </div>
                    <input 
                        type="number" 
                        name="price_per_night" 
                        id="price_per_night" 
                        value="{{ old('price_per_night') }}" 
                        required 
                        min="0"
                        step="0.01"
                        class="block w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="0.00"
                    >
                </div>
                @error('price_per_night') 
                    <p class="mt-1.5 text-xs text-red-600 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-900 mb-2">
                    Property Image
                </label>
                <div x-data="{ preview: null, filename: '' }" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md px-2 py-1 font-medium text-primary-600 hover:text-primary-700">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*"
                                       @change="const f=$event.target.files[0]; if(f){ preview=URL.createObjectURL(f); filename=f.name } else { preview=null; filename='' }">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        <p class="text-xs text-gray-500" x-show="filename" x-text="filename"></p>
                        <div class="mt-4" x-show="preview" x-cloak>
                            <img :src="preview" alt="Image preview" class="mx-auto h-40 w-auto rounded-lg border border-gray-200 object-contain">
                        </div>
                    </div>
                </div>
                @error('image') 
                    <p class="mt-1.5 text-xs text-red-600 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Form actions are now at the top -->
        </form>
    </div>
@endsection