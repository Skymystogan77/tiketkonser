<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'The Eras Tour - Taylor Swift',
                'category' => 'Musik',
                'ticket_price' => 1500000,
                'description' => 'Konser musik spektakuler tur dunia Taylor Swift membawakan lagu-lagu hits terbaik.',
                'image' => null,
            ],
            [
                'title' => 'Soundrenaline Music Festival 2026',
                'category' => 'Festival',
                'ticket_price' => 450000,
                'description' => 'Festival musik lintas genre tahunan terbesar di Indonesia dengan puluhan line-up artis.',
                'image' => null,
            ],
            [
                'title' => 'Web Development & AI Conference',
                'category' => 'Seminar',
                'ticket_price' => 150000,
                'description' => 'Seminar nasional teknologi dan peluang integrasi AI dalam ekosistem web modern.',
                'image' => null,
            ],
            [
                'title' => 'Java Jazz Festival 2026',
                'category' => 'Musik',
                'ticket_price' => 850000,
                'description' => 'Pertunjukan musik jazz internasional yang menghadirkan musisi legendaris dalam dan luar negeri.',
                'image' => null,
            ],
            [
                'title' => 'Indie Clothing & Music Expo',
                'category' => 'Festival',
                'ticket_price' => 75000,
                'description' => 'Eksibisi kreatif kolaborasi brand lokal dan penampilan band indie terpopuler.',
                'image' => null,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}

