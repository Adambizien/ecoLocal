@extends('project-leader.index')

@section('project-leader-content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-11 col-lg-10 px-md-4">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h1 class="h2 mb-0">Modifier le projet</h1>
                    <a href="{{ route('project-leader.index') }}" class="btn text-white">
                        <i class="fas fa-arrow-left me-1"></i>
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('project-leader.project.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Titre du projet</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $project->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="goal_amount" class="form-label">Montant objectif (€)</label>
                                <input type="number" step="0.01" class="form-control @error('goal_amount') is-invalid @enderror" id="goal_amount" name="goal_amount" value="{{ old('goal_amount', $project->goal_amount) }}" required>
                                @error('goal_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($project->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="Image du projet" style="max-width: 200px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1" {{ old('remove_image') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remove_image">
                                                Supprimer l'image actuelle
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Section pour les Project Levels -->
                        <div class="mt-5">
                            <h3 class="h4 mb-4 border-bottom pb-2">Niveaux du projet</h3>
                            <div id="projectLevels-container" class="row g-3">
                                <div class="col-12">
                                    <button type="button" id="add-projectLevel" class="btn btn-sm btn-outline-success mb-3">+ Ajouter un niveau</button>
                                </div>
                                
                                @foreach(old('projectLevels', $project->projectLevels ?: []) as $index => $item)
                                    @php
                                        $projectLevel = is_array($item) ? (object)$item : $item;
                                    @endphp
                                    <div class="col-md-6 level-item">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <input type="hidden" name="projectLevels[{{ $index }}][id]" value="{{ $projectLevel->id ?? '' }}">
                                                <div class="mb-3">
                                                    <label class="form-label">Titre du niveau</label>
                                                    <input type="text" name="projectLevels[{{ $index }}][title]" 
                                                           class="form-control @error('projectLevels.'.$index.'.title') is-invalid @enderror" 
                                                           value="{{ old('projectLevels.'.$index.'.title', $projectLevel->title ?? '') }}" required>
                                                    @error('projectLevels.'.$index.'.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Montant cible</label>
                                                    <input type="number" step="0.01" name="projectLevels[{{ $index }}][target_amount]" 
                                                           class="form-control @error('projectLevels.'.$index.'.target_amount') is-invalid @enderror" 
                                                           value="{{ old('projectLevels.'.$index.'.target_amount', $projectLevel->target_amount ?? '') }}" required>
                                                    @error('projectLevels.'.$index.'.target_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="projectLevels[{{ $index }}][description]" 
                                                              class="form-control @error('projectLevels.'.$index.'.description') is-invalid @enderror" 
                                                              rows="2" required>{{ old('projectLevels.'.$index.'.description', $projectLevel->description ?? '') }}</textarea>
                                                    @error('projectLevels.'.$index.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-projectLevel @if($loop->first) d-none @endif">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section pour les Reward Tiers -->
                        <div class="mt-5">
                            <h3 class="h4 mb-4 border-bottom pb-2">Récompenses</h3>
                            <div id="rewards-container" class="row g-3">
                                <div class="col-12">
                                    <button type="button" id="add-reward" class="btn btn-sm btn-outline-success mb-3">+ Ajouter une récompense</button>
                                </div>
                                
                                @foreach(old('rewards', $project->rewardTiers ?: []) as $index => $item)
                                    @php
                                        $reward = is_array($item) ? (object)$item : $item;
                                    @endphp
                                    <div class="col-md-6 reward-item">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <input type="hidden" name="rewards[{{ $index }}][id]" value="{{ $reward->id ?? '' }}">
                                                <div class="mb-3">
                                                    <label class="form-label">Titre de la récompense</label>
                                                    <input type="text" name="rewards[{{ $index }}][title]" 
                                                           class="form-control @error('rewards.'.$index.'.title') is-invalid @enderror" 
                                                           value="{{ old('rewards.'.$index.'.title', $reward->title ?? '') }}" required>
                                                    @error('rewards.'.$index.'.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Montant minimum</label>
                                                    <input type="number" step="0.01" name="rewards[{{ $index }}][minimum_amount]" 
                                                           class="form-control @error('rewards.'.$index.'.minimum_amount') is-invalid @enderror" 
                                                           value="{{ old('rewards.'.$index.'.minimum_amount', $reward->minimum_amount ?? '') }}" required>
                                                    @error('rewards.'.$index.'.minimum_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="rewards[{{ $index }}][description]" 
                                                              class="form-control @error('rewards.'.$index.'.description') is-invalid @enderror" 
                                                              rows="2" required>{{ old('rewards.'.$index.'.description', $reward->description ?? '') }}</textarea>
                                                    @error('rewards.'.$index.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-reward @if($loop->first) d-none @endif">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-success btn-lg">Mettre à jour</button>
                            <a href="{{ route('admin.partials.projects.index') }}" class="btn btn-secondary btn-lg">Annuler</a>
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
    
    .remove-projectLevel, .remove-reward {
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
    // Gestion des projectLevels
    let projectLevelIndex = {{ count(old('projectLevels', $project->projectLevels ?: [])) }};
    document.getElementById('add-projectLevel').addEventListener('click', function() {
        const template = document.querySelector('.level-item');
        if (!template) return;
        
        const levelItem = template.cloneNode(true);
        const cardBody = levelItem.querySelector('.card-body');
        const inputs = cardBody.querySelectorAll('input, textarea');
        
        // Mise à jour des noms et valeurs
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${projectLevelIndex}]`);
            input.name = name;
            if (!input.type.includes('hidden') && !input.type.includes('checkbox')) {
                input.value = '';
            }
        });
        
        // Suppression de l'ID caché pour les nouveaux projectLevels
        const hiddenInput = cardBody.querySelector('input[type="hidden"]');
        if (hiddenInput) hiddenInput.remove();
        
        // Affichage du bouton supprimer
        const removeBtn = cardBody.querySelector('.remove-projectLevel');
        if (removeBtn) removeBtn.classList.remove('d-none');
        
        // Gestion de la suppression
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.level-item').length > 1) {
                    levelItem.remove();
                } else {
                    alert('Vous devez garder au moins un niveau');
                }
            });
        }
        
        // Réinitialisation des classes d'erreur
        cardBody.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        cardBody.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
        
        document.getElementById('projectLevels-container').appendChild(levelItem);
        projectLevelIndex++;
    });

    // Gestion des récompenses
    let rewardIndex = {{ count(old('rewards', $project->rewardTiers ?: [])) }};
    document.getElementById('add-reward').addEventListener('click', function() {
        const template = document.querySelector('.reward-item');
        if (!template) return;
        
        const rewardItem = template.cloneNode(true);
        const cardBody = rewardItem.querySelector('.card-body');
        const inputs = cardBody.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${rewardIndex}]`);
            input.name = name;
            if (!input.type.includes('hidden') && !input.type.includes('checkbox')) {
                input.value = '';
            }
        });
        
        const hiddenInput = cardBody.querySelector('input[type="hidden"]');
        if (hiddenInput) hiddenInput.remove();
        
        const removeBtn = cardBody.querySelector('.remove-reward');
        if (removeBtn) {
            removeBtn.classList.remove('d-none');
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.reward-item').length > 1) {
                    rewardItem.remove();
                } else {
                    alert('Vous devez garder au moins une récompense');
                }
            });
        }
        
        cardBody.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        cardBody.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
        
        document.getElementById('rewards-container').appendChild(rewardItem);
        rewardIndex++;
    });

    // Gestion de la suppression d'image
    const imageInput = document.getElementById('image');
    const removeCheckbox = document.getElementById('remove_image');
    
    if (imageInput && removeCheckbox) {
        imageInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                removeCheckbox.checked = false;
            }
        });
        
        removeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                imageInput.value = '';
            }
        });
    }

    // Activation des boutons supprimer pour les éléments existants en cas d'erreur
    if (document.querySelectorAll('.is-invalid').length > 0) {
        document.querySelectorAll('.remove-projectLevel').forEach(btn => {
            btn?.classList.remove('d-none');
        });
        document.querySelectorAll('.remove-reward').forEach(btn => {
            btn?.classList.remove('d-none');
        });
    }

    // Gestion de la suppression pour les éléments existants
    document.querySelectorAll('.remove-projectLevel').forEach(btn => {
        btn?.addEventListener('click', function() {
            if (document.querySelectorAll('.level-item').length > 1) {
                this.closest('.level-item')?.remove();
            } else {
                alert('Vous devez garder au moins un niveau');
            }
        });
    });
    
    document.querySelectorAll('.remove-reward').forEach(btn => {
        btn?.addEventListener('click', function() {
            if (document.querySelectorAll('.reward-item').length > 1) {
                this.closest('.reward-item')?.remove();
            } else {
                alert('Vous devez garder au moins une récompense');
            }
        });
    });
});
</script>
@endsection