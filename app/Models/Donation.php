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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rewardTiers()
    {
        return $this->belongsToMany(RewardTier::class, 'donation_reward_tier')
                ->withPivot('is_received')
                ->withTimestamps();
    }



}
