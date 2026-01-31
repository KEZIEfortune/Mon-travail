<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Récupérer un organisateur et une catégorie (nécessaires pour les clés étrangères)
       // Dans la fonction run() de ton EventsSeeder :
$organizer = \App\Models\User::where('role', 'organizer')->first();
$category = \App\Models\Category::first();

// Utilise ensuite $organizer->id et $category->id dans ton Event::create

        // Sécurité : Vérifier que les données parentes existent
        if (!$organizer || !$category) {
            $this->command->error("Erreur : Assurez-vous d'avoir un utilisateur avec le rôle 'organizer' et au moins une catégorie dans la base de données.");
            return;
        }

        // 2. Création des événements Tangerins
        $events = [
            [
                'title' => 'Tanjazz Festival 2026',
                'description' => 'Le rendez-vous incontournable du Jazz au Palais des Institutions Italiennes.',
                'start_date' => Carbon::parse('2026-09-15 19:00:00'),
                'end_date' => Carbon::parse('2026-09-15 23:30:00'),
                'location' => 'Palais Moulay Hafid',
                'city' => 'Tanger',
                'region' => 'Tanger-Tétouan-Al Hoceima',
                'price' => 250.00,
                'image' => 'tanjazz.jpg',
            ],
            [
                'title' => 'Nuit du Gnawa à la Kasbah',
                'description' => 'Une immersion mystique au cœur de la vieille ville.',
                'start_date' => Carbon::parse('2026-06-20 21:00:00'),
                'end_date' => Carbon::parse('2026-06-21 01:00:00'),
                'location' => 'Place du Tabor',
                'city' => 'Tanger',
                'region' => 'Tanger-Tétouan-Al Hoceima',
                'price' => 0.00, // Gratuit
                'image' => 'gnawa.jpg',
            ]
        ];

        foreach ($events as $eventData) {
            Event::create([
                'title' => $eventData['title'],
                'slug' => Str::slug($eventData['title']), // Génère 'tanjazz-festival-2026'
                'description' => $eventData['description'],
                'start_date' => $eventData['start_date'],
                'end_date' => $eventData['end_date'],
                'location' => $eventData['location'],
                'city' => $eventData['city'],
                'region' => $eventData['region'],
                'price' => $eventData['price'],
                'image' => $eventData['image'],
                'category_id' => $category->id,
                'organizer_id' => $organizer->id,
            ]);
        }

        $this->command->info("Seeding des événements terminé avec succès !");
    }
}