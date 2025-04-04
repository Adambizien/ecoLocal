<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Categories;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.partials.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'raised_amount' => 'numeric',
            'start_date' => 'date',
            'end_date' => 'date',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation de l'image
            'tiers' => 'array',
            'tiers.*.title' => 'required|string|max:255',
            'tiers.*.goal_amount' => 'required|numeric',
            'tiers.*.description' => 'required|string',
        ]);

        // Upload de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }



        // Création du projet
        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'goal_amount' => $request->input('goal_amount'),
            'raised_amount' => $request->input('raised_amount', 0),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->id(),
            'image' => $imagePath, // Stocke le chemin de l'image
        ]);

        // Ajout des paliers de donation
        foreach ($request->input('tiers', []) as $tierData) {
            $project->tiers()->create([
                'title' => $tierData['title'],
                'goal_amount' => $tierData['goal_amount'],
                'description' => $tierData['description'],
            ]);
        }

        return redirect()->route('home')->with('success', 'Projet créé avec succès!');
    }
}
