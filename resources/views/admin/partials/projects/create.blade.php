@extends('admin.index')

@section('admin-content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-11 col-lg-10 px-md-4">
            <div class="card shadow-sm mt-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0">Créer un nouveau projet</h1>
                <a href="{{ route('admin.partials.projects.index') }}" class="btn  text-white">
                    <i class="fas fa-arrow-left me-1"></i>
                </a>
            </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.partials.projects.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Titre du projet</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="goal_amount" class="form-label">Montant objectif (€)</label>
                                <input type="number" step="0.01" class="form-control" id="goal_amount" name="goal_amount" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="user_id" class="form-label">Porteur de projet</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="validated" class="form-label">Statut</label>
                                <select class="form-select" id="validated" name="validated">
                                    <option value="0">En attente</option>
                                    <option value="1">Validé</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>

                        <div class="mt-5">
                            <h3 class="h4 mb-4 border-bottom pb-2">Niveaux du projet</h3>
                            <div id="levels-container" class="row g-3">
                                <div class="col-12">
                                    <button type="button" id="add-level" class="btn btn-sm btn-outline-success mb-3">+ Ajouter un niveau</button>
                                </div>
                                
                                <div class="col-md-6 level-item">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Titre du niveau</label>
                                                <input type="text" name="projectLevels[0][title]" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Montant cible</label>
                                                <input type="number" step="0.01" name="projectLevels[0][target_amount]" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="projectLevels[0][description]" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-level" style="display: none;">Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h3 class="h4 mb-4 border-bottom pb-2">Récompenses</h3>
                            <div id="rewards-container" class="row g-3">
                                <div class="col-12">
                                    <button type="button" id="add-reward" class="btn btn-sm btn-outline-success mb-3">+ Ajouter une récompense</button>
                                </div>
                                
                                <div class="col-md-6 reward-item">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Titre de la récompense</label>
                                                <input type="text" name="rewards[0][title]" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Montant minimum</label>
                                                <input type="number" step="0.01" name="rewards[0][minimum_amount]" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="rewards[0][description]" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-reward" style="display: none;">Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-success btn-lg">Créer le projet</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 5px;
        padding: 10px;
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .level-item .card, .reward-item .card {
        transition: all 0.3s ease;
    }
    
    .level-item .card:hover, .reward-item .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .remove-level, .remove-reward {
        width: 100%;
        margin-top: 10px;
    }
    
    @media (max-width: 768px) {
        .level-item, .reward-item {
            width: 100% !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let levelIndex = 1;
    const levelsContainer = document.getElementById('levels-container');
    
    document.getElementById('add-level').addEventListener('click', function() {
        const levelItem = document.querySelector('.level-item').cloneNode(true);
        const cardBody = levelItem.querySelector('.card-body');
        const inputs = cardBody.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            const name = input.name.replace('projectLevels[0]', `projectLevels[${levelIndex}]`);
            input.name = name;
            input.value = '';
        });
        
        const removeBtn = cardBody.querySelector('.remove-level');
        removeBtn.style.display = 'block';
        removeBtn.addEventListener('click', function() {
            levelItem.remove();
        });
        
        levelsContainer.appendChild(levelItem);
        levelIndex++;
    });

    let rewardIndex = 1;
    const rewardsContainer = document.getElementById('rewards-container');
    
    document.getElementById('add-reward').addEventListener('click', function() {
        const rewardItem = document.querySelector('.reward-item').cloneNode(true);
        const cardBody = rewardItem.querySelector('.card-body');
        const inputs = cardBody.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            const name = input.name.replace('[0]', `[${rewardIndex}]`);
            input.name = name;
            input.value = '';
        });
        
        const removeBtn = cardBody.querySelector('.remove-reward');
        removeBtn.style.display = 'block';
        removeBtn.addEventListener('click', function() {
            rewardItem.remove();
        });
        
        rewardsContainer.appendChild(rewardItem);
        rewardIndex++;
    });

    if (document.querySelectorAll('.is-invalid').length > 0) {
        const firstLevelRemove = document.querySelector('.remove-level');
        const firstRewardRemove = document.querySelector('.remove-reward');
        
        if (firstLevelRemove) firstLevelRemove.style.display = 'block';
        if (firstRewardRemove) firstRewardRemove.style.display = 'block';
    }
    
    (function () {
        'use strict'
        
        var forms = document.querySelectorAll('.needs-validation')
        
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
});
</script>
@endsection