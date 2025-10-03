<form method="POST" action="{{ isset($property) ? route('manager.properties.update', $property) : route('manager.properties.store') }}" enctype="multipart/form-data" class="space-y-6 p-6">
    @csrf
    @if(isset($property))
        @method('PUT')
    @endif
    
    <!-- Hidden CSRF Token for JavaScript -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- Form Header -->
    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900">Property Details</h2>
        <div class="flex space-x-3">
            <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Cancel
            </button>
            <button type="submit" class="inline-flex items-center space-x-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-all text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ isset($property) ? 'Update' : 'Create' }} Property</span>
            </button>
        </div>
    </div>
    
    <!-- Form Content -->
    <div class="space-y-6 pt-2">

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
                value="{{ old('name', $property->name ?? '') }}" 
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
        >{{ old('description', $property->description ?? '') }}</textarea>
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
                value="{{ old('price_per_night', $property->price_per_night ?? '') }}" 
                required 
                min="0"
                step="0.01"
                class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
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

    <!-- Image -->
    <div>
        <label for="image" class="block text-sm font-semibold text-gray-900 mb-2">
            Property Image
        </label>
        <div x-data="{ preview: null, filename: '' }" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors bg-gray-50">
            <div class="space-y-1 text-center">
                <template x-if="preview">
                    <img :src="preview" class="mx-auto h-32 w-auto object-cover rounded-lg" alt="Preview">
                </template>
                <template x-if="!preview && '{{ $property->image ?? '' }}'">
                    <img src="{{ isset($property) && $property->image ? Storage::url($property->image) : '' }}" class="mx-auto h-32 w-auto object-cover rounded-lg" alt="Current Image">
                </template>
                <div class="flex text-sm text-gray-600" :class="{'mt-4': preview || '{{ $property->image ?? '' }}'}">
                    <label for="image-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                        <span>Upload a file</span>
                        <input id="image-upload" name="image" type="file" class="sr-only" @change="
                            const file = $event.target.files[0];
                            if (file) {
                                filename = file.name;
                                const reader = new FileReader();
                                reader.onload = (e) => preview = e.target.result;
                                reader.readAsDataURL(file);
                            } else {
                                preview = null;
                                filename = '';
                            }
                        ">
                    </label>
                    <p class="pl-1" x-text="filename ? 'or drag and drop' : 'or drag and drop'"></p>
                </div>
                <p class="text-xs text-gray-500">
                    PNG, JPG, GIF up to 2MB
                </p>
                <p class="text-xs text-gray-500" x-show="filename" x-text="filename"></p>
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
    </div> <!-- End of form content -->
</form>
