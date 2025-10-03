@extends('layouts.manager')

@section('content')
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">All Properties</h1>
            <p class="text-sm text-gray-600 mt-1">Manage your property listings</p>
        </div>
        <a href="{{ route('manager.properties.create') }}" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow transition-all text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add Property</span>
        </a>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow overflow-hidden border border-gray-200">
                <!-- Property Image -->
                @if($property->image)
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ Storage::url($property->image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-white px-2.5 py-1 rounded-full text-xs font-semibold text-gray-900 shadow-sm">
                            €{{ number_format($property->price_per_night, 0) }}/night
                        </div>
                    </div>
                @else
                    <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-gray-500 text-xs">No Image</span>
                    </div>
                @endif

                <!-- Property Details -->
                <div class="p-4">
                    <h3 class="text-base font-bold text-gray-900 mb-1.5 truncate">{{ $property->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $property->description }}</p>
                    
                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center space-x-2">
                            @if(($property->booked_today_count ?? 0) > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd"/>
                                    </svg>
                                    Booked today
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 102 0V7a1 1 0 10-2 0v6z" clip-rule="evenodd"/>
                                    </svg>
                                    Available today
                                </span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="openEditModal({{ $property->id }})" class="inline-flex items-center space-x-1.5 text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg transition-colors text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Edit</span>
                            </button>
                            <form method="POST" action="{{ route('manager.properties.destroy', $property) }}" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center space-x-1.5 text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors text-xs font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No properties yet</h3>
                    <p class="text-gray-600 text-sm mb-6">Get started by adding your first property listing</p>
                    <a href="{{ route('manager.properties.create') }}" class="inline-flex items-center space-x-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add Your First Property</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>
    <!-- Edit Property Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
            
            <!-- Modal Container -->
            <div class="relative w-full max-w-4xl mx-auto">
                <!-- Modal Content -->
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div id="modalContent" class="p-0">
                        <!-- Content will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(propertyId) {
            // Show loading state
            document.getElementById('modalContent').innerHTML = `
                <div class="p-8">
                    <div class="flex justify-center items-center py-16">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-200 border-t-blue-500"></div>
                    </div>
                </div>
            `;
            
            // Show modal and prevent body scroll
            document.body.style.overflow = 'hidden';
            document.getElementById('editModal').classList.remove('hidden');
            
            // Load the edit form via AJAX
            fetch(`/manager/properties/${propertyId}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    
                    // Reinitialize any necessary JavaScript for the form
                    const form = document.querySelector('#modalContent form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const formData = new FormData(form);
                            // No need to append _method here as we're using @method('PUT') in the form
                            
                            // Show loading state
                            const submitButton = form.querySelector('button[type="submit"]');
                            const originalButtonText = submitButton.innerHTML;
                            submitButton.disabled = true;
                            submitButton.innerHTML = `
                                <div class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    </svg>
                                    Updating...
                                </div>
                            `;
                            
                            // Get the form action URL
                            const url = form.getAttribute('action');
                            
                            // Add the _method parameter for Laravel to recognize it as a PUT request
                            if (form.querySelector('input[name="_method"]')) {
                                formData.append('_method', 'PUT');
                            }
                            
                            console.log('Starting form submission to:', url);
                            console.log('Form data:', Object.fromEntries(formData.entries()));
                            
                            // Add timeout for the fetch request
                            const controller = new AbortController();
                            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
                            
                            // Get CSRF token from the form
                            const csrfToken = form.querySelector('input[name="_token"]').value;
                            
                            fetch(url, {
                                method: 'POST',
                                body: formData,
                                signal: controller.signal,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => {
                                clearTimeout(timeoutId);
                                console.log('Response status:', response.status);
                                
                                if (!response.ok) {
                                    return response.json()
                                        .then(err => { 
                                            console.error('Server error:', err);
                                            throw new Error(err.message || 'Server returned an error');
                                        })
                                        .catch(() => {
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Success:', data);
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                } else {
                                    // If no redirect is provided, just close the modal and refresh the page
                                    closeEditModal();
                                    window.location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Error details:', {
                                    name: error.name,
                                    message: error.message,
                                    stack: error.stack
                                });
                                
                                // Show error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4';
                                errorDiv.role = 'alert';
                                
                                let errorMessage = 'An error occurred while updating the property.';
                                if (error.name === 'AbortError') {
                                    errorMessage = 'Request timed out. Please try again.';
                                } else if (error.message) {
                                    errorMessage = error.message;
                                }
                                
                                errorDiv.innerHTML = `
                                    <p class="font-bold">Error</p>
                                    <p>${errorMessage}</p>
                                    <p class="text-sm mt-2">Check the browser console for more details.</p>
                                `;
                                
                                const existingError = form.querySelector('.bg-red-100');
                                if (existingError) {
                                    existingError.remove();
                                }
                                
                                form.prepend(errorDiv);
                                
                                // Reset button
                                submitButton.disabled = false;
                                submitButton.innerHTML = originalButtonText;
                                
                                // Auto-scroll to the error message
                                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            });
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading form:', error);
                      document.getElementById('modalContent').innerHTML = `
                          <div class="p-8">
                              <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded">
                                  <div class="flex">
                                      <div class="flex-shrink-0">
                                          <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                          </svg>
                                      </div>
                                      <div class="ml-3">
                                          <h3 class="text-sm font-medium text-red-800">Error loading form</h3>
                                          <div class="mt-2 text-sm text-red-700">
                                              <p>${error.message || 'Failed to load the edit form. Please try again.'}</p>
                                          </div>
                                          <div class="mt-4">
                                              <button type="button" onclick="closeEditModal()" class="rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                  Close
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      `;
                });
        }

        function closeEditModal() {
            document.body.style.overflow = 'auto';
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modal when clicking outside the modal content
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
@endsection