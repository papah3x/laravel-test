@extends('layouts.manager')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Edit Booking</h1>
            <p class="text-sm text-gray-600 mt-1">Update booking details for the client</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('manager.bookings.update', $booking) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Client Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-semibold text-gray-900 mb-2">
                        Client <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('user_id', $booking->user_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Property Selection -->
                <div>
                    <label for="property_id" class="block text-sm font-semibold text-gray-900 mb-2">
                        Property <span class="text-red-500">*</span>
                    </label>
                    <select name="property_id" id="property_id" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}" data-price="{{ $property->price_per_night }}" {{ old('property_id', $booking->property_id) == $property->id ? 'selected' : '' }}>
                                {{ $property->name }} - ${{ number_format($property->price_per_night, 2) }}/night
                            </option>
                        @endforeach
                    </select>
                    @error('property_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', optional($booking->start_date)->format('Y-m-d')) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        @error('start_date')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', optional($booking->end_date)->format('Y-m-d')) }}" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        @error('end_date')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Price -->
                <div>
                    <label for="total_price" class="block text-sm font-semibold text-gray-900 mb-2">
                        Total Price
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">$</span>
                        </div>
                        <input type="number" name="total_price" id="total_price" value="{{ old('total_price', $booking->total_price) }}" step="0.01" min="0" class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" placeholder="0.00">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">Leave empty to calculate automatically</p>
                    @error('total_price')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="4" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" placeholder="Add any additional notes about this booking...">{{ old('notes', $booking->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('manager.bookings.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center space-x-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-calculate total price based on dates and property
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const propertySelect = document.getElementById('property_id');
        const totalPriceInput = document.getElementById('total_price');

        function calculateTotalPrice() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const selectedOption = propertySelect.options[propertySelect.selectedIndex];
            const pricePerNight = parseFloat(selectedOption.dataset.price);

            if (startDate && endDate && pricePerNight && startDate < endDate) {
                const nights = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                const totalPrice = nights * pricePerNight;
                totalPriceInput.value = totalPrice.toFixed(2);
            }
        }

        startDateInput.addEventListener('change', calculateTotalPrice);
        endDateInput.addEventListener('change', calculateTotalPrice);
        propertySelect.addEventListener('change', calculateTotalPrice);

        // Set minimum end date based on start date
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            if (endDateInput.value && endDateInput.value <= this.value) {
                endDateInput.value = '';
            }
        });
    </script>
@endsection
