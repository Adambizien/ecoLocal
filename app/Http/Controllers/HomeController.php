<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Project;
use App\Models\Donation;


class HomeController extends Controller
{
    public function index()
    {
        $categories = Categories::all();

        $featuredProjects = Project::with(['category', 'donations', 'user'])
            ->where('validated', true)
            ->where('end_date', '>', now())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($project) {
                $project->totalDonations = $project->donations()->sum('amount');
                $project->percentage = $project->goal_amount > 0 
                    ? min(round(($project->totalDonations / $project->goal_amount) * 100, 2), 100)
                    : 0;
                $project->days_remaining = now()->diffInDays($project->end_date, false);
                return $project;
            });



        $stats = [
            'projectsCount' => Project::where('validated', true)
                                ->where('validated', true)
                                ->count(),
            'donationsSum' => Donation::sum('amount'),
            'contributorsCount' => Donation::distinct('user_id')->count('user_id'),
            'successRate' => $this->calculateSuccessRate(),
        ];

        return view('home', [
            'categories' => $categories,
            'featuredProjects' => $featuredProjects,
            'stats' => $stats,
        ]);
    }

    private function calculateSuccessRate()
    {
        $totalProjects = Project::where('validated', true)->count();
        if ($totalProjects === 0) return 0;

        $successfulProjects = Project::where('validated', true)
            ->where('validated', true)
            ->withSum('donations', 'amount')
            ->get()
            ->filter(function ($project) {
                return $project->donations_sum_amount >= $project->goal_amount;
            })
            ->count();

        return round(($successfulProjects / $totalProjects) * 100);
    }
}