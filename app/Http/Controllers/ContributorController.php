<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class ContributorController extends Controller
{
    public function showAdmin(User $user)
    {
        $user->load(['donations' => function($query) {
            $query->with(['project', 'rewardTiers'])
                  ->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.partials.contributions.show', compact('user'));
    }

    public function showProjectLeader(User $user)
    {

        if ($user->donations->isNotEmpty()) {
            $user->donations->each(function($donation) {
                if ($donation->project->user_id !== auth()->id()) {
                    abort(403);
                }
            });
        }
        
        $user->load(['donations' => function($query) {
            $query->with(['project', 'rewardTiers'])
                  ->orderBy('created_at', 'desc');
        }]);
        
        return view('project-leader.partials.contributions.show', compact('user'));
    }
}