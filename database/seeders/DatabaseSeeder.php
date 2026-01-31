<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    \App\Models\Category::create([
        'id' => 1, 
        'name' => 'événement éducative', 
        'slug' => 'événement éducative'
    ]);

    \App\Models\Category::create([
        'id' => 2, 
        'name' => 'événements culturels', 
        'slug' => 'événements culturels'
    ]);
    \App\Models\Category::create([
        'id' => 3, 
        'name' => 'événements sportive', 
        'slug' => 'événements sportive'
    ]);
    \App\Models\Category::create([
        'id' => 4, 
        'name' => 'événements festives', 
        'slug' => 'événements festives'
    ]);
    $user = User::factory()->create([
    'name' => 'Organisateur Test',
    'email' => 'admin@tanjazz.com',
]);


\App\Models\Organizer::create([
    'id' => 1,           
    'user_id' => $user->id,
    'name' => 'Tanjfood Organiseur',
    'slug' => 'tanjfood-organiseur'
]);
\App\Models\Organizer::create([
    'id' => 2,           
    'user_id' => $user->id,
    'name' => 'Tanjazz Organiseur',
    'slug' => 'tanjazz-organiseur'
]);
\App\Models\Organizer::create([
    'id' => 3,           
    'user_id' => $user->id,
    'name' => 'Tanjsport Organiseur',
    'slug' => 'tanjsport-organiseur'
]);
    
}
    }

