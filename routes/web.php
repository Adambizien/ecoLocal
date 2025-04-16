<?php


use App\Http\Controllers\ContributorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLeader;
use App\Http\Controllers\StatsController;

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');
Route::get('/a-propos', function () {
    return view('about');
})->name('about');


// show projects
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects', [ProjectController::class, 'indexPublic'])->name('public.projects.index');

Route::middleware(['auth'])->group(function () {
    //admin :

    // - users 
    Route::get('/admin/users', [AdminController::class, 'user'])->name('admin.partials.users.index');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.partials.users.destroy');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.partials.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.partials.users.update');

    // - projects 
    Route::get('/admin/projects', [AdminController::class, 'projects'])->name('admin.partials.projects.index');
    Route::get('/admin/projects/create', [ProjectController::class, 'createAdmin'])->name('admin.partials.projects.create');
    Route::post('/admin/projects/store', [ProjectController::class, 'storeAdmin'])->name('admin.partials.projects.store');
    Route::get('/admin/projects/{project}/edit', [ProjectController::class, 'editAdmin'])->name('admin.partials.projects.edit');
    Route::put('/admin/projects/{project}', [ProjectController::class, 'updateAdmin'])->name('admin.partials.projects.update');
    Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroyAdmin'])->name('admin.partials.projects.destroy');
    Route::patch('/admin/projects/{project}/toggle-validation', [ProjectController::class, 'toggleValidation'])
    ->name('admin.projects.toggle-validation');

    // - categories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.partials.categories.index');
    Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('category.create');
    Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->name('category.store');
    Route::get('/admin/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
    Route::put('/admin/categories/{category}', [CategoriesController::class, 'update'])->name('category.update');
    Route::delete('/admin/categories/{category}', [CategoriesController::class, 'destroy'])->name('category.destroy');

    // - contributions
    Route::get('/admin/contributions', [AdminController::class, 'contributions'])->name('admin.partials.contributions.index');
    Route::get('admin/contributors/{user}', [ContributorController::class, 'showAdmin'])->name('admin.partials.contributors.show');

    // - statistics
    Route::get('/admin/statistics', [StatsController::class, 'adminStats'])->name('admin.partials.statistics.index');

    //porteurs de projets :
    // - projets
    Route::get('/project-leader/projets', [ProjectLeader::class, 'projects'])->name('project-leader.index');
    Route::get('/project-leader/project/create', [ProjectController::class, 'createProjectLeader'])->name('project-leader.project.create');
    Route::post('/project-leader/project', [ProjectController::class, 'storeProjectLeader'])->name('project-leader.project.store');
    Route::get('/project-leader/project/{project}/edit', [ProjectController::class, 'editProjectLeader'])->name('project-leader.project.edit');
    Route::put('/project-leader/project/{project}', [ProjectController::class, 'updateProjectLeader'])->name('project-leader.project.update');
    Route::delete('/project-leader/project/{project}', [ProjectController::class, 'destroyProjectLeader'])->name('project-leader.project.destroy');
    
    // - contributions
    Route::get('/project-leader/contributions', [ProjectLeader::class, 'contributions'])->name('project-leader.contributions');
    Route::get('project-leader/contributors/{user}', [ContributorController::class, 'showProjectLeader'])->name('project-leader.contributors.show');
    
    // - statistics
    Route::get('/project-leader/statistics', [StatsController::class, 'projectLeaderStats'])->name('project-leader.statistics');


    //profils :
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Historiques Donations
    Route::get('/donations/history', [DonationController::class, 'history'])
    ->middleware('auth')
    ->name('donations.history');

});




require __DIR__.'/auth.php';

