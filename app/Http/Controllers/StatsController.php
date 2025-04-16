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
    public function adminStats()
    {
        $stats = [
            'total_projects' => Project::count(),
            'total_donations' => Donation::sum('amount'),
            'total_communities' => User::where('role', 'project_leader')->count(),
            'pending_projects' => Project::where('validated', true)->count(),
            'total_users' => User::where('role', '!=', 'project_leader')->count(),
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

        $monthlyRegistrations = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyRegistrationsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRegistrationsData[] = $monthlyRegistrations[$i] ?? 0;
        }

        $projectsByCategory = Categories::withCount(['projects' => function($query) {
            $query->where('validated', true);
        }])
        ->orderBy('projects_count', 'desc')
        ->get();

        $topProjects = Project::withSum('donations', 'amount')
            ->orderBy('donations_sum_amount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($project) {
                $project->donations_sum_amount = $project->donations_sum_amount ?? 0;
                return $project;
            });

        return view('admin.partials.statistics.index', compact(
            'stats',
            'monthlyDonationsData',
            'monthlyRegistrationsData',
            'projectsByCategory',
            'topProjects'
        ));
    }

    public function projectLeaderStats(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'total_projects' => Project::where('user_id', $user->id)->count(),
            'active_projects' => Project::where('user_id', $user->id)
                                    ->where('validated', true)
                                    ->count(),
            'pending_projects' => Project::where('user_id', $user->id)
                                    ->where('validated', true)
                                    ->count(),
            'total_donations' => Donation::whereHas('project', function($query) use ($user) {
                                    $query->where('user_id', $user->id);
                                })->sum('amount'),
            'total_donors' => Donation::whereHas('project', function($query) use ($user) {
                                    $query->where('user_id', $user->id);
                                })->distinct('user_id')->count('user_id'),
        ];

        $monthlyDonations = Donation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereHas('project', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
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

        $topProjects = Project::withSum('donations', 'amount')
            ->where('user_id', $user->id)
            ->orderBy('donations_sum_amount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($project) {
                $project->donations_sum_amount = $project->donations_sum_amount ?? 0;
                return $project;
            });

        $projectsDonations = Project::withSum('donations', 'amount')
            ->where('user_id', $user->id)
            ->orderBy('donations_sum_amount', 'desc')
            ->get();

        return view('project-leader.partials.statistics.index', compact(
            'stats',
            'monthlyDonationsData',
            'topProjects',
            'projectsDonations'
        ));
    }
}