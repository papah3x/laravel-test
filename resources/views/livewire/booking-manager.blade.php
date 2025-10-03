<div 
    x-data="{ show: false, message: '' }"
    x-on:bookingcreated.window="
        message = 'Réservation enregistrée !';
        show = true;
        setTimeout(() => show = false, 3000);
    "
    class="p-4 max-w-md mx-auto bg-white rounded shadow"
>
    <h2 class="text-lg font-bold mb-4">Nouvelle réservation</h2>

    {{-- Sélection du bien immobilier --}}
    <select wire:model="propertyId" class="mb-2 block w-full border rounded p-2">
        <option value="">Sélectionnez un bien</option>
        @foreach($properties as $property)
            <option value="{{ $property->id }}">{{ $property->name }}</option>
        @endforeach
    </select>

    {{-- Dates de réservation --}}
    <input type="date" wire:model="startDate" class="mb-2 block w-full border rounded p-2" />
    <input type="date" wire:model="endDate" class="mb-2 block w-full border rounded p-2" />

    <button wire:click="createBooking" class="bg-primary text-white px-4 py-2 rounded">
        Réserver
    </button>

    {{-- Notification Alpine.js --}}
    <div 
        x-show="show"
        x-transition
        class="mt-2 text-green-600"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>

    {{-- Affichage des erreurs de validation --}}
    @error('propertyId') <div class="text-red-500">{{ $message }}</div> @enderror
    @error('startDate') <div class="text-red-500">{{ $message }}</div> @enderror
    @error('endDate') <div class="text-red-500">{{ $message }}</div> @enderror

    {{-- Liste des réservations existantes --}}
    <h3 class="text-md font-semibold mt-6 mb-2">Mes réservations</h3>
    <ul>
        @forelse($bookings as $booking)
            <li class="mb-1">
                <span class="font-bold">{{ $booking->property->name ?? 'Bien supprimé' }}</span> :
                du {{ $booking->start_date }} au {{ $booking->end_date }}
            </li>
        @empty
            <li>Aucune réservation.</li>
        @endforelse
    </ul>
</div>
