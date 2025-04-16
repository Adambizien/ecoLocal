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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function rewardTiers()
    {
        return $this->hasMany(RewardTier::class);
    }

    public function projectLevels()
    {
        return $this->hasMany(ProjectLevel::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}