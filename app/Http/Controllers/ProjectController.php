<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\ProjectLevel;
use App\Models\RewardTier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function createProjectLeader()
    {
        $categories = Categories::all();
        return view('project-leader.partials.projects.create', compact('categories'));
    }

    public function createAdmin()
    {
        $categories = Categories::all();
        $users = User::all();
        return view('admin.partials.projects.create', compact('categories', 'users'));
    }


    public function storeProjectLeader(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'projectLevels' => 'required|array|min:1',
                'projectLevels.*.title' => 'required|string|max:255',
                'projectLevels.*.target_amount' => 'required|numeric|min:0',
                'projectLevels.*.description' => 'required|string',
                'rewards' => 'required|array|min:1',
                'rewards.*.title' => 'required|string|max:255',
                'rewards.*.minimum_amount' => 'required|numeric|min:0',
                'rewards.*.description' => 'required|string',
            ]);
    
            $project = new Project();
            $project->title = $validated['title'];
            $project->description = $validated['description'];
            $project->goal_amount = $validated['goal_amount'];
            $project->category_id = $validated['category_id'];
            $project->user_id = Auth::id(); // Assigner l'ID de l'utilisateur connecté directement
            $project->start_date = $validated['start_date'];
            $project->end_date = $validated['end_date'];
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }
    
            $project->save();
    
            foreach ($validated['projectLevels'] as $levelData) {
                $level = new ProjectLevel();
                $level->title = $levelData['title'];
                $level->target_amount = $levelData['target_amount'];
                $level->description = $levelData['description'];
                $project->projectLevels()->save($level);
            }
    
            foreach ($validated['rewards'] as $rewardData) {
                $reward = new RewardTier();
                $reward->title = $rewardData['title'];
                $reward->minimum_amount = $rewardData['minimum_amount'];
                $reward->description = $rewardData['description'];
                $project->rewardTiers()->save($reward);
            }
    
            DB::commit();
    
            return redirect()->route('project-leader.index') // Corrigez cette route si nécessaire
                ->with('success', 'Projet créé avec succès!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function storeAdmin(Request $request)
    {
        
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'user_id' => 'required|exists:users,id',
                'validated' => 'boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'projectLevels' => 'required|array|min:1',
                'projectLevels.*.id' => 'sometimes|exists:project_levels,id',
                'projectLevels.*.title' => 'required|string|max:255',
                'projectLevels.*.target_amount' => 'required|numeric|min:0',
                'projectLevels.*.description' => 'required|string',
                'rewards' => 'required|array|min:1',
                'rewards.*.id' => 'sometimes|exists:reward_tiers,id',
                'rewards.*.title' => 'required|string|max:255',
                'rewards.*.minimum_amount' => 'required|numeric|min:0',
                'rewards.*.description' => 'required|string',
            ]);

            $project = new Project();
            $project->title = $validated['title'];
            $project->description = $validated['description'];
            $project->goal_amount = $validated['goal_amount'];
            $project->category_id = $validated['category_id'];
            $project->user_id = $validated['user_id'];
            $project->validated = $validated['validated'] ?? false;
            $project->start_date = $validated['start_date'];
            $project->end_date = $validated['end_date'];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }

            $project->save();

            foreach ($validated['projectLevels'] as $levelData) {
                $level = new ProjectLevel();
                $level->title = $levelData['title'];
                $level->target_amount = $levelData['target_amount'];
                $level->description = $levelData['description'];
                $project->projectLevels()->save($level);
            }

            foreach ($validated['rewards'] as $rewardData) {
                $reward = new RewardTier();
                $reward->title = $rewardData['title'];
                $reward->minimum_amount = $rewardData['minimum_amount'];
                $reward->description = $rewardData['description'];
                $project->rewardTiers()->save($reward);
            }

            DB::commit();

            return redirect()->route('admin.partials.projects.index')
                ->with('success', 'Projet créé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function editProjectLeader(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Categories::all();
        return view('project-leader.partials.projects.edit', compact('project', 'categories'));
    }

    public function editAdmin(Project $project)
    {
        $categories = Categories::all();
        $users = User::all();
        $project->load(['projectLevels', 'rewardTiers']);
        
        return view('admin.partials.projects.edit', compact('project', 'categories', 'users'));
    }


    public function updateProjectLeader(Request $request, Project $project)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'sometimes|boolean',
                'projectLevels' => 'required|array|min:1',
                'projectLevels.*.id' => 'sometimes|exists:project_levels,id',
                'projectLevels.*.title' => 'required|string|max:255',
                'projectLevels.*.target_amount' => 'required|numeric|min:0',
                'projectLevels.*.description' => 'required|string',
                'rewards' => 'required|array|min:1',
                'rewards.*.id' => 'sometimes|exists:reward_tiers,id',
                'rewards.*.title' => 'required|string|max:255',
                'rewards.*.minimum_amount' => 'required|numeric|min:0',
                'rewards.*.description' => 'required|string',
            ]);

            $project->title = $validated['title'];
            $project->description = $validated['description'];
            $project->goal_amount = $validated['goal_amount'];
            $project->category_id = $validated['category_id'];
            $project->start_date = $validated['start_date'];
            $project->end_date = $validated['end_date'];

            if ($request->has('remove_image') && $request->input('remove_image')) {
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                    $project->image = null;
                }
            } elseif ($request->hasFile('image')) {
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }

            $project->save();

            $existingLevelIds = [];
            foreach ($validated['projectLevels'] as $levelData) {
                if (isset($levelData['id'])) {
                    $level = ProjectLevel::find($levelData['id']);
                    $level->update([
                        'title' => $levelData['title'],
                        'target_amount' => $levelData['target_amount'],
                        'description' => $levelData['description']
                    ]);
                    $existingLevelIds[] = $level->id;
                } else {
                    $level = $project->projectLevels()->create([
                        'title' => $levelData['title'],
                        'target_amount' => $levelData['target_amount'],
                        'description' => $levelData['description']
                    ]);
                    $existingLevelIds[] = $level->id;
                }
            }
            $project->projectLevels()->whereNotIn('id', $existingLevelIds)->delete();

            $existingRewardIds = [];
            foreach ($validated['rewards'] as $rewardData) {
                if (isset($rewardData['id'])) {
                    $reward = RewardTier::find($rewardData['id']);
                    $reward->update([
                        'title' => $rewardData['title'],
                        'minimum_amount' => $rewardData['minimum_amount'],
                        'description' => $rewardData['description']
                    ]);
                    $existingRewardIds[] = $reward->id;
                } else {
                    $reward = $project->rewardTiers()->create([
                        'title' => $rewardData['title'],
                        'minimum_amount' => $rewardData['minimum_amount'],
                        'description' => $rewardData['description']
                    ]);
                    $existingRewardIds[] = $reward->id;
                }
            }
            $project->rewardTiers()->whereNotIn('id', $existingRewardIds)->delete();

            DB::commit();

            return redirect()->route('project-leader.index')
                ->with('success', 'Projet mis à jour avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour: ' . $e->getMessage());
        }

    }


    public function updateAdmin(Request $request, Project $project)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'goal_amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'user_id' => 'required|exists:users,id',
                'validated' => 'boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'sometimes|boolean',
                'projectLevels' => 'required|array|min:1',
                'projectLevels.*.id' => 'sometimes|exists:project_levels,id',
                'projectLevels.*.title' => 'required|string|max:255',
                'projectLevels.*.target_amount' => 'required|numeric|min:0',
                'projectLevels.*.description' => 'required|string',
                'rewards' => 'required|array|min:1',
                'rewards.*.id' => 'sometimes|exists:reward_tiers,id',
                'rewards.*.title' => 'required|string|max:255',
                'rewards.*.minimum_amount' => 'required|numeric|min:0',
                'rewards.*.description' => 'required|string',
            ]);

            $project->title = $validated['title'];
            $project->description = $validated['description'];
            $project->goal_amount = $validated['goal_amount'];
            $project->category_id = $validated['category_id'];
            $project->user_id = $validated['user_id'];
            $project->validated = $validated['validated'] ?? false;
            $project->start_date = $validated['start_date'];
            $project->end_date = $validated['end_date'];

            if ($request->has('remove_image') && $request->input('remove_image')) {
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                    $project->image = null;
                }
            } elseif ($request->hasFile('image')) {
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                $imagePath = $request->file('image')->store('projects', 'public');
                $project->image = $imagePath;
            }

            $project->save();

            $existingLevelIds = [];
            foreach ($validated['projectLevels'] as $levelData) {
                if (isset($levelData['id'])) {
                    $level = ProjectLevel::find($levelData['id']);
                    $level->update([
                        'title' => $levelData['title'],
                        'target_amount' => $levelData['target_amount'],
                        'description' => $levelData['description']
                    ]);
                    $existingLevelIds[] = $level->id;
                } else {
                    $level = $project->projectLevels()->create([
                        'title' => $levelData['title'],
                        'target_amount' => $levelData['target_amount'],
                        'description' => $levelData['description']
                    ]);
                    $existingLevelIds[] = $level->id;
                }
            }
            $project->projectLevels()->whereNotIn('id', $existingLevelIds)->delete();

            $existingRewardIds = [];
            foreach ($validated['rewards'] as $rewardData) {
                if (isset($rewardData['id'])) {
                    $reward = RewardTier::find($rewardData['id']);
                    $reward->update([
                        'title' => $rewardData['title'],
                        'minimum_amount' => $rewardData['minimum_amount'],
                        'description' => $rewardData['description']
                    ]);
                    $existingRewardIds[] = $reward->id;
                } else {
                    $reward = $project->rewardTiers()->create([
                        'title' => $rewardData['title'],
                        'minimum_amount' => $rewardData['minimum_amount'],
                        'description' => $rewardData['description']
                    ]);
                    $existingRewardIds[] = $reward->id;
                }
            }
            $project->rewardTiers()->whereNotIn('id', $existingRewardIds)->delete();

            DB::commit();

            return redirect()->route('admin.partials.projects.index')
                ->with('success', 'Projet mis à jour avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour: ' . $e->getMessage());
        }
    }
    
    public function destroyProjectLeader(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('project-leader.index')->with('success', 'Projet supprimé avec succès');
    }

    public function destroyAdmin(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.partials.projects.index')->with('success', 'Projet supprimé avec succès');
    }

    public function toggleValidation(Project $project)
    {
        $project->update(['validated' => !$project->validated]);
        
        return back()->with('success', 'Statut de validation mis à jour avec succès');
    }
}
