<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Donation;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'total_donations' => Donation::sum('amount'),
            'total_communities' => User::where('role', 'project_leader')->count(),
            'pending_projects' => Project::where('validated', true)->count(),
        ];

        $monthlyDonations = Donation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyDonationsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyDonationsData[] = $monthlyDonations[$i] ?? 0;
        }

        $projectsByCategory = Categories::withCount(['projects' => function($query) {
            $query->where('validated', true);
        }])
        ->orderBy('projects_count', 'desc')
        ->get();
        

        $environmentalImpact = [
            'Énergie' => 12.5,
            'Déchets' => 18.2,
            'Eau' => 15.7,
            'Transport' => 22.4,
            'Alimentation' => 19.8,
            'Biodiversité' => 25.3,
            'Air' => 21.6
        ];

        $topProjects = Project::withSum('donations', 'amount')
            ->orderBy('donations_sum_amount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($project) {
                // Remplace null par 0 pour les projets sans dons
                $project->donations_sum_amount = $project->donations_sum_amount ?? 0;
                return $project;
            });

        return view('admin.partials.statistics.index', compact(
            'stats',
            'monthlyDonationsData',
            'projectsByCategory',
            'environmentalImpact',
            'topProjects'
        ));
    }
  
}