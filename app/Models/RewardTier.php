<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardTier extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'minimum_amount',
    ];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    public function donations()
    {
        return $this->belongsToMany(Donation::class, 'donation_reward_tier')
                ->withPivot('is_received')
                ->withTimestamps();
    }
}