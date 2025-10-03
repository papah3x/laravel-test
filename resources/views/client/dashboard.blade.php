<x-app-layout>
    <div class="py-8" x-data="{ bookPropertyId: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if(session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Hero / CTA -->
            <div class="bg-gradient-to-r from-primary-900 to-primary-700 rounded-xl p-8 text-white shadow">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Welcome, {{ auth()->user()->name }} 👋</h1>
                        <p class="mt-1 text-primary-100">Ready to plan your next stay? Discover properties and book in a few clicks.</p>
                    </div>
                    <a href="#properties" class="inline-flex items-center px-5 py-3 bg-white text-gray-900 rounded-lg font-semibold shadow hover:shadow-md transition">
                        Browse Properties
                    </a>
                </div>
            </div>

            <!-- Featured Properties -->
            <section id="properties" class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Featured Properties</h2>
                    <span class="text-sm text-gray-500">Handpicked for you</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($properties ?? [] as $property)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="h-44 bg-gray-100 overflow-hidden">
                                @if($property->image)
                                    <img src="{{ Storage::url($property->image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                                @endif
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-base font-bold text-gray-900 truncate">{{ $property->name }}</h3>
                                    <div class="text-sm font-semibold text-gray-900">${{ number_format($property->price_per_night, 0) }}/night</div>
                                </div>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $property->description }}</p>
                                <div class="pt-2 flex items-center justify-between">
                                    <a href="{{ route('client.properties.show', $property) }}" class="text-sm text-gray-500 hover:text-gray-700">View details</a>
                                    <button @click="bookPropertyId = {{ $property->id }}" class="px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-lg">Request Booking</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="p-6 bg-white border border-dashed border-gray-300 rounded-xl text-center text-gray-500">No properties available yet.</div>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Your Recent Bookings -->
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Your Recent Bookings</h2>
                    <span class="text-sm text-gray-500">Last 6 bookings</span>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    @if(($bookings ?? collect())->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <li class="p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-lg overflow-hidden bg-gray-100">
                                            @if($booking->property->image)
                                                <img src="{{ Storage::url($booking->property->image) }}" class="h-full w-full object-cover" alt="{{ $booking->property->name }}">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $booking->property->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $booking->start_date->format('M d') }} → {{ $booking->end_date->format('M d, Y') }}</div>
                                            @if($booking->status === 'cancelled' && $booking->notes)
                                                <div class="mt-1 text-xs text-red-600">Reason: {{ $booking->notes }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if($booking->status === 'pending')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                        @endif
                                        <div class="text-sm font-semibold text-gray-900">
                                            @if($booking->total_price)
                                                ${{ number_format($booking->total_price, 2) }}
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-8 text-center text-gray-500">No bookings yet. Book your first stay below!</div>
                    @endif
                </div>
            </section>

            <!-- Services / Upsell -->
            <section class="space-y-4">
                <h2 class="text-xl font-bold text-gray-900">You might also like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="font-semibold text-gray-900">Airport Taxi</div>
                        <p class="text-sm text-gray-600 mt-1">Get a comfortable ride to or from the airport.</p>
                        <button class="mt-3 text-sm text-primary-600 hover:text-primary-800 font-semibold">Request a ride →</button>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="font-semibold text-gray-900">Experiences</div>
                        <p class="text-sm text-gray-600 mt-1">Discover local tours and activities near your stay.</p>
                        <button class="mt-3 text-sm text-primary-600 hover:text-primary-800 font-semibold">Browse experiences →</button>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="font-semibold text-gray-900">Grocery Delivery</div>
                        <p class="text-sm text-gray-600 mt-1">Have essentials delivered before you arrive.</p>
                        <button class="mt-3 text-sm text-primary-600 hover:text-primary-800 font-semibold">Order now →</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Booking Request Modal -->
        <div x-show="bookPropertyId" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
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
