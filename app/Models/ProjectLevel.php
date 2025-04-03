<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectLevel extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'target_amount',
    ];

    /**
     * Un ProjectLevel appartient à un projet
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}