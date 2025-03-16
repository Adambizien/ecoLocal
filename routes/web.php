<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.partials.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.partials.users.update');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.partials.users.index');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.partials.users.destroy');
    Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.partials.projects');
    Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('admin.partials.categories.index');
    Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('category.create');
    Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->name('category.store');
    Route::get('/admin/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
    Route::put('/admin/categories/{category}', [CategoriesController::class, 'update'])->name('category.update');
    Route::delete('/admin/categories/{category}', [CategoriesController::class, 'destroy'])->name('category.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/create-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/create-project', [ProjectController::class, 'store'])->name('project.store');
});



require __DIR__.'/auth.php';
