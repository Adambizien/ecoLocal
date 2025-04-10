<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   

    public function edit(User $user)
    {
        return view('admin.partials.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,project_leader',
        ]);

        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('admin.partials.users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.partials.users.index')->with('success', 'Utilisateur supprimé avec succès');
    }

}
