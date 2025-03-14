<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'goal_amount', 
        'raised_amount', 
        'start_date', 
        'end_date',
        'category_id',
        'user_id'
    ];

    // Relation avec l'utilisateur (si tu utilises un modèle User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les donations
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // Relation avec les paliers
    public function tiers()
    {
        return $this->hasMany(Tier::class);
    }

    // Relation avec le type de projet
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}