<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    
    public function destroy(Categories $category)
    {
        $category->delete();
        
        return redirect()->route('admin.partials.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
    public function edit(Categories $category)
    {
        return view('admin.partials.categories.edit', compact('category'));
    }

    // Traiter la mise à jour de la catégorie
    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.partials.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function create()
    {
        return view('admin.partials.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        Categories::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.partials.categories.index')->with('success', 'Catégorie créée avec succès.');
    }
}
