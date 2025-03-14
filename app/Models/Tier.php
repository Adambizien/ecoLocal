<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    protected $fillable = [
        'title', 
        'goal_amount', 
        'description', 
        'project_id'
    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

     // Relation with donations
     public function donations()
     {
         return $this->hasMany(Donation::class);
     }
}
