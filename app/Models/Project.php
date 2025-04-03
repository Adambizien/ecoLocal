<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'goal_amount',
        'category_id', 
        'user_id',
        'start_date', 
        'end_date',
        'image',
        'validated',
    ];

   /**
     * Relation avec le modèle User (porteur de projet)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les donations
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Relation avec les reward tiers (niveaux de récompense)
     */
    public function rewardTiers()
    {
        return $this->hasMany(RewardTier::class);
    }

    /**
     * Relation avec les project levels (niveaux de projet)
     */
    public function projectLevels()
    {
        return $this->hasMany(ProjectLevel::class);
    }

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}