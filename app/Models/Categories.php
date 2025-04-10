<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
