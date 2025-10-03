<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Modern City Loft',
                'description' => 'Sleek loft in the heart of the city, close to cafes and nightlife.',
                'price_per_night' => 160,
                'asset' => 'modern-city-loft.jpg',
            ],
            [
                'name' => 'Cozy Country Cottage',
                'description' => 'Charming cottage with a garden and fireplace for a relaxing getaway.',
                'price_per_night' => 120,
                'asset' => 'cozy-country-cottage.jpg',
            ],
            [
                'name' => 'Beachfront Villa',
                'description' => 'Stunning villa with direct beach access and ocean views.',
                'price_per_night' => 320,
                'asset' => 'beachfront-villa.jpg',
            ],
            [
                'name' => 'Mountain Cabin Retreat',
                'description' => 'Rustic cabin surrounded by pines, perfect for hiking and stargazing.',
                'price_per_night' => 180,
                'asset' => 'mountain-cabin-retreat.jpg',
            ],
            [
                'name' => 'Minimalist Studio',
                'description' => 'Bright studio with minimalist decor and fast Wi‑Fi.',
                'price_per_night' => 95,
                'asset' => 'minimalist-studio.jpg',
            ],
            [
                'name' => 'Lake House Getaway',
                'description' => 'Peaceful lake house with deck and kayak access.',
                'price_per_night' => 210,
                'asset' => 'lake-house-getaway.jpg',
            ],
        ];

        foreach ($items as $item) {
            $slug = Str::slug($item['name']);
            $path = "properties/{$slug}.jpg";

            // Copy from local curated assets to public storage
            try {
                $src = base_path('resources/assets/' . $item['asset']);
                if (is_file($src)) {
                    Storage::disk('public')->put($path, file_get_contents($src));
                } else {
                    Storage::disk('public')->put($path, base64_decode(self::placeholder()));
                }
            } catch (\Throwable $e) {
                Storage::disk('public')->put($path, base64_decode(self::placeholder()));
            }

            Property::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'price_per_night' => $item['price_per_night'],
                'image' => $path,
            ]);
        }
    }

    private static function placeholder(): string
    {
        // 1x1 gray JPEG
        return '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxAQEA8QDw8QDw8QDw8QDw8PDw8PDw8QFREWFhURFRUYHSggGBolHRUVITEhJSkrLi4uFx8zODMsNygtLisBCgoKDg0OGhAQGi0lICUtLS0tLS0tLS0tLS0tLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAKAAoAMBIgACEQEDEQH/xAAXAAADAQAAAAAAAAAAAAAAAAAEBQYB/8QAHxAAAQQDAQEAAAAAAAAAAAAAAQIDBBEFITFh/8QAFQEBAQAAAAAAAAAAAAAAAAAAAQT/xAAZEQACAwEAAAAAAAAAAAAAAAAAAQIDETH/2gAMAwEAAhEDEQA/AJ3S9qQ1vQwqgN2gHqvL2b3xkqkq2J4m2JgZ0c8JqE2sQXq4i6J6mO0QxD8o7e1aGm2C2tq1bKp7mJb7Q2m1w9bK9f//Z';
    }
}
