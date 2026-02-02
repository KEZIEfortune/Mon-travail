<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',
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
        'status',
        'is_validated', // AJOUTÉ : indispensable pour ta validation admin
        'is_active',
        'available_tickets' // Vérifie que c'est bien le nom utilisé dans ton formulaire
    ];

    // Relation vers la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation vers l'organisateur
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
        // On récupère les commentaires approuvés
        return $this->hasMany(Comment::class);
    }

    // Logique métier pour la disponibilité
    public function isAvailable()
    {
        // Un événement est disponible s'il est actif, approuvé et pas encore passé
        return $this->is_active && $this->status === 'approved' && $this->start_date > now();
    }
}