<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function history()
    {
        $user = Auth::user();
        $donations = $user->donations()
                        ->with(['project', 'rewardTiers'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('donations.history', compact('donations'));
    }
}