<x-app-layout>
    <div class="py-8" x-data="{ bookPropertyId: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="h-64 bg-gray-100">
                    @if($property->image)
                        <img src="{{ Storage::url($property->image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-6 space-y-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $property->name }}</h1>
                    <div class="text-gray-600">{{ $property->description }}</div>
                    <div class="text-lg font-semibold text-gray-900">${{ number_format($property->price_per_night, 0) }}/night</div>
                    <div class="pt-2">
                        <button @click="$dispatch('open-book-modal')" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">Request Booking</button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">What’s included</h2>
                <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                    <li>Fast Wi‑Fi</li>
                    <li>Self check‑in</li>
                    <li>Comfortable beds</li>
                </ul>
            </div>
        </div>

        <!-- Booking Request Modal (reused structure) -->
        <div x-data 
             x-on:open-book-modal.window="bookPropertyId = {{ $property->id }}"
             x-show="bookPropertyId" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6" @click.outside="bookPropertyId = null">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Request Booking</h3>
                    <button @click="bookPropertyId = null" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <form method="POST" action="{{ route('client.bookings.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="property_id" :value="bookPropertyId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start date</label>
                            <input type="date" name="start_date" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End date</label>
                            <input type="date" name="end_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" placeholder="Any special requests or details..."></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="bookPropertyId = null" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-primary-600 hover:bg-primary-700 text-white text-sm">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
