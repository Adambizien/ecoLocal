<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    public function user()
    {
        $users = User::all();
        return view('admin.partials.users.index', compact('users'));
    }

    public function categories()
    {
        $categories = Categories::all();
        return view('admin.partials.categories.index', compact('categories'));
    }

    public function projects()
    {
        $projects = Project::all();
        return view('admin.partials.projects.index', compact('projects'));
    }

    public function contributions()
    {
        $contributors = User::has('donations')->withCount('donations')->withSum('donations', 'amount')->get();
        
        return view('admin.partials.contributions.index', compact('contributors'));
    }

    
}
