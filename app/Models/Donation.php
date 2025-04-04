<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'amount',
        'project_id',
        'user_id',
    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tiers()
    {
        return $this->belongsToMany(Tier::class, 'donation_tier');
    }

}
