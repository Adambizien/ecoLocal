@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-success">Créer un Projet</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form method="POST" action="{{ route('project.store') }}" novalidate>
            @csrf

            <!-- Titre du projet -->
            <div class="mb-3">
                <label for="title" class="form-label">Titre du projet</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description du projet -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Montant objectif -->
            <div class="mb-3">
                <label for="goal_amount" class="form-label">Montant objectif</label>
                <input type="number" name="goal_amount" id="goal_amount" class="form-control @error('goal_amount') is-invalid @enderror" value="{{ old('goal_amount') }}" required>
                @error('goal_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Date de début -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Date de début</label>
                <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date de fin -->
            <div class="mb-3">
                <label for="end_date" class="form-label">Date de fin</label>
                <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de la catégorie -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Catégorie</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ajout des paliers de donation -->
            <div id="tiers-container">
                <h3 class="text-success d-inline">Ajouter des paliers de donation</h3>
                <button type="button" id="add-tier" class="btn btn-outline-success ms-3 d-inline">+</button>

                <div class="row g-3 mt-3" id="tiers-row">
                    <!-- Premier palier -->
                    <div class="tier col-md-4 card mb-3 mt-3 p-3">
                        <div class="card-body">
                            <label for="tier_title" class="form-label">Titre du palier</label>
                            <input type="text" name="tiers[0][title]" class="form-control @error('tiers.0.title') is-invalid @enderror" value="{{ old('tiers.0.title') }}" required>
                            @error('tiers.0.title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="tier_goal_amount" class="form-label">Montant du palier</label>
                            <input type="number" name="tiers[0][goal_amount]" class="form-control @error('tiers.0.goal_amount') is-invalid @enderror" value="{{ old('tiers.0.goal_amount') }}" required>
                            @error('tiers.0.goal_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="tier_description" class="form-label">Description du palier</label>
                            <textarea name="tiers[0][description]" class="form-control @error('tiers.0.description') is-invalid @enderror" required>{{ old('tiers.0.description') }}</textarea>
                            @error('tiers.0.description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-success mt-3">Créer le projet</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let tierIndex = 1;

        document.getElementById('add-tier').addEventListener('click', function() {
            let firstTier = document.querySelector('#tiers-row .tier');
            let newTier = firstTier.cloneNode(true);

            newTier.querySelectorAll('input, textarea').forEach(function(input) {
                let name = input.getAttribute('name');
                name = name.replace('0', tierIndex);
                input.setAttribute('name', name);
                input.value = '';
            });

            if (tierIndex > 0) {
                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'remove-tier', 'mt-2');
                removeButton.innerHTML = '<i class="bi bi-trash"></i> Supprimer ce palier';
                removeButton.addEventListener('click', function() {
                    newTier.remove();
                });
                newTier.querySelector('.card-body').appendChild(removeButton);
            }

            document.getElementById('tiers-row').appendChild(newTier);
            tierIndex++;
        });
    });
</script>
@endsection