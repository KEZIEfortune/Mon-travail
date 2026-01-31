<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',          // Ajouté (obligatoire pour ta migration)
        'description', 
        'start_date', 
        'end_date', 
        'location', 
        'city', 
        'region', 
        'price', 
        'image', 
        'category_id', 
        'organizer_id', 
        'status',        // Correction de 'satatus'
        'is_active',
        'available_tickets'
    ];

    // Relation vers la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation vers l'organisateur (qui est un User)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    // Logique métier
    public function isAvailable()
    {
        // Attention : ta migration n'a pas de colonne 'status', 
        // assure-toi de l'ajouter ou d'utiliser 'is_active'
        return $this->is_active && $this->start_date > now();
    }
}