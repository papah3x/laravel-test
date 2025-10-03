@extends('layouts.manager')

@section('content')
    <!-- Header with Filters -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Bookings</h1>
                <p class="text-sm text-gray-600 mt-1">Manage and track all property bookings</p>
            </div>
            <a href="{{ route('manager.bookings.create') }}" class="inline-flex items-center space-x-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg shadow-sm hover:shadow transition-all text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create Booking</span>
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('manager.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Start Date Filter -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>

                <!-- End Date Filter -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Pending Bookings Alert -->
        @if($pendingCount > 0)
            <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">
                            You have {{ $pendingCount }} pending booking{{ $pendingCount > 1 ? 's' : '' }} waiting for confirmation.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" x-data="{ openViewId: null, openDeclineId: null }">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $passedPending = false; @endphp
                        @foreach($bookings as $booking)
                            @if($booking->status !== 'pending' && !$passedPending)
                                @php $passedPending = true; @endphp
                                <tr>
                                    <td colspan="6" class="px-6 py-2 bg-white">
                                        <div class="border-t-2 border-gray-200 my-1"></div>
                                    </td>
                                </tr>
                            @endif
                            <tr class="transition-colors {{ $booking->status === 'pending' ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'hover:bg-gray-50' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-600 font-semibold text-sm">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->property->name }}</div>
                                    <div class="text-sm text-gray-500">${{ number_format($booking->property->price_per_night, 2) }}/night</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->start_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">to {{ $booking->end_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $booking->start_date->diffInDays($booking->end_date) }} nights</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        @if($booking->total_price)
                                            ${{ number_format($booking->total_price, 2) }}
                                        @else
                                            <span class="text-gray-400">Not set</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Pending
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Confirmed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button type="button" @click="openViewId = {{ $booking->id }}" class="text-gray-700 hover:text-gray-900 font-medium">View</button>
                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('manager.bookings.confirm', $booking) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                            </form>
                                            <button type="button" @click="openDeclineId = {{ $booking->id }}" class="text-red-600 hover:text-red-900 font-medium">Decline</button>
                                        @else
                                            <a href="{{ route('manager.bookings.edit', $booking) }}" class="text-primary-600 hover:text-primary-900 font-medium">Edit</a>
                                            <form method="POST" action="{{ route('manager.bookings.destroy', $booking) }}" class="inline" onsubmit="return confirm('Delete this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- View Details Modal -->
                            <div x-show="openViewId === {{ $booking->id }}" @keydown.escape.window="openViewId = null" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
                                <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6" @click.outside="openViewId = null">
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">Booking Details</h3>
                                        <button @click="openViewId = null" class="text-gray-400 hover:text-gray-600">✕</button>
                                    </div>
                                    <div class="mt-4 space-y-2 text-sm text-gray-700">
                                        <div><span class="font-medium">Client:</span> {{ $booking->user->name }} ({{ $booking->user->email }})</div>
                                        <div><span class="font-medium">Property:</span> {{ $booking->property->name }}</div>
                                        <div><span class="font-medium">Dates:</span> {{ $booking->start_date->format('M d, Y') }} → {{ $booking->end_date->format('M d, Y') }}</div>
                                        <div><span class="font-medium">Nights:</span> {{ $booking->start_date->diffInDays($booking->end_date) }}</div>
                                        <div><span class="font-medium">Total Price:</span> {{ $booking->total_price ? '$'.number_format($booking->total_price, 2) : 'Not set' }}</div>
                                        @if($booking->notes)
                                            <div><span class="font-medium">Notes:</span> {{ $booking->notes }}</div>
                                        @endif
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button @click="openViewId = null" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm">Close</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Decline Modal -->
                            <div x-show="openDeclineId === {{ $booking->id }}" @keydown.escape.window="openDeclineId = null" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
                                <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.outside="openDeclineId = null">
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">Decline Booking</h3>
                                        <button @click="openDeclineId = null" class="text-gray-400 hover:text-gray-600">✕</button>
                                    </div>
                                    <form method="POST" action="{{ route('manager.bookings.cancel', $booking) }}" class="mt-4">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason (optional)</label>
                                        <textarea name="notes" rows="4" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Provide a brief reason for declining (optional)"></textarea>
                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button type="button" @click="openDeclineId = null" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm">Cancel</button>
                                            <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Decline</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new booking.</p>
                <div class="mt-6">
                    <a href="{{ route('manager.bookings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Booking
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
