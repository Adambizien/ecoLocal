@extends('layouts.app')

@section('content')
    <div class="container py-5">
        
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Filtrer</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('public.projects.index') }}" method="GET">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Recherche</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Rechercher un projet...">
                                </div>
                                
                                <h6 class="card-subtitle mb-2 text-muted">Par catégorie</h6>
                                <div class="list-group list-group-flush mb-3">
                                    <div class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" 
                                                   id="all-categories" value="" 
                                                   {{ !request('category') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="all-categories">
                                                Toutes les catégories
                                            </label>
                                        </div>
                                    </div>
                                    @foreach($categories as $category)
                                        <div class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="category" 
                                                       id="category-{{ $category->id }}" value="{{ $category->id }}"
                                                       {{ request('category') == $category->id ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category-{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100">Appliquer</button>
                                @if(request('search') || request('category'))
                                    <a href="{{ route('public.projects.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                        Réinitialiser
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Liste des projets</h2>
                    </div>
                    @if($projects->isEmpty())
                        <div class="text-center py-5">
                           <p class="lead">Aucun projet trouvé.</p>
                        </div>
                    @else


                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($projects as $project)
                                <div class="col">
                                    <div class="card h-100 shadow-sm project-card">
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-dark">
                                            <div class="position-relative">
                                                @if($project->image)
                                                    <img src="{{ asset('storage/' . $project->image) }}" 
                                                        class="card-img-top" 
                                                        alt="{{ $project->title }}"
                                                        style="height: 180px; object-fit: cover;">
                                                @else
                                                    <div class="card-img-top d-flex justify-content-center align-items-center bg-light border-bottom border-1" 
                                                        style="height: 180px;">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                                @if($project->category)
                                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                                        {{ $project->category->name }}
                                                    </span>
                                                @endif
                                                
                                                <span class="badge position-absolute bottom-0 end-0 m-2 
                                                    {{ $project->days_remaining < 1 ? 'bg-danger' : ($project->days_remaining > 7 ? 'bg-success' : 'bg-warning') }}">
                                                    @if($project->days_remaining < 1)
                                                        Dernier jour !
                                                    @else
                                                        {{ round($project->days_remaining) }} jours restants
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="card-body">
                                                <h5 class="card-title text-truncate" style="max-width: 100%;">
                                                    {{ $project->title }}
                                                </h5>
                                                <p class="card-text text-muted small">
                                                    {{ Str::limit($project->description, 100) }}
                                                </p>
                                                
                                                <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                                                    <span><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</span>
                                                    <span class="mx-1">→</span> 
                                                    <span><i class="far fa-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</span>
                                                </div>
                                                
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $project->percentage == 0 ? '0.5' : $project->percentage }}%" 
                                                        aria-valuenow="{{ $project->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2 small">
                                                    <span class="fw-bold text-success">{{ number_format($project->totalDonations, 0, ',', ' ') }} €</span>
                                                    <span class="text-muted">{{ $project->percentage }}%</span>
                                                    <span class="text-muted">{{ number_format($project->goal_amount, 2) }} €</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                </div>
            </div>
    </div>

    <style>
        .project-card {
            transition: all 0.3s ease;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.1);
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: rgba(0,0,0,0.2);
        }
        
        .card-img-top {
            border-top-left-radius: 8px !important;
            border-top-right-radius: 8px !important;
        }
        
        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
    </style>
@endsection