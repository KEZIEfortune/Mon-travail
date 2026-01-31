<?php

namespace App\Models;

Use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{  use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
}
