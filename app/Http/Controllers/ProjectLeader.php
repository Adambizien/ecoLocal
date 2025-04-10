<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ProjectLeader extends Controller
{
        
    public function projects()
    {
        $projects = Project::where('user_id', Auth::id())
        ->with('category')
        ->get();
        return view('project-leader.partials.projects.index', compact('projects'));
    }

    public function contributions()
    {
        // récuperer les contributeurs qui ont fait des dons sur les projet de l'utilisateur actuellement connecté
        $contributors = User::has('donations')
            ->withCount('donations')
            ->withSum('donations', 'amount')
            ->whereHas('donations.project', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('project-leader.partials.contributions.index', compact('contributors'));
    }

    public function statistics()
    {
        return view('project-leader.partials.statistics.index');
    }

    

}
