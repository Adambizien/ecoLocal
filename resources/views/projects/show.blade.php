@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            @if($project->image)
                <div class="project-image-container rounded mb-4" style="height: 250px;">
                    <img src="{{ asset('storage/' . $project->image) }}" 
                        alt="{{ $project->title }}" 
                        class="img-fluid w-100 h-100 object-fit-cover">
                </div>
            @else
                <div class="project-image-container bg-light rounded mb-4 d-flex align-items-center justify-content-center" style="height: 250px;">
                    <div class="text-center">
                        <i class="fas fa-image fa-5x text-muted mb-3"></i>
                        <p class="text-muted">Aucune image disponible</p>
                    </div>
                </div>
            @endif
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h2 text-truncate" style="max-width: 70%;" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $project->title }}">
                    {{ $project->title }}
                </h1>
                <span class="badge bg-success">{{ $project->category->name }}</span>
            </div>
            
            <div class="mb-4">
                <p>Projet porté par <strong>{{ $project->user->name }}</strong></p>
            </div>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span><strong>{{ number_format($totalDonations, 2) }} €</strong></span>
                    <span>{{ number_format($project->goal_amount, 2) }} €</span>
                </div>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercentage }}%;" 
                         aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressPercentage }}%
                    </div>
                </div>
                <div class="mt-2 text-muted">
                    Se termine le {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</small>
                </div>
            </div>
            
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4">À propos du projet</h2>
                    <p class="card-text">{{ $project->description }}</p>
                </div>
            </div>
            
            <!-- Niveaux du projet -->
            @if($project->projectLevels->isNotEmpty())
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-4">Étapes du projet</h2>
                    <div class="row g-3">
                        @foreach($project->projectLevels as $level)
                        @php
                            $levelPercentage = min(100, ($totalDonations / $level->target_amount) * 100);
                            $bgClass = $totalDonations >= $level->target_amount ? 'bg-success' : ($levelPercentage > 0 ? 'bg-warning' : 'bg-secondary');
                        @endphp
                        
                        <div class="col-12">
                            <div class="card border-0 shadow-sm position-relative overflow-hidden">
                                <div class="position-absolute top-0 start-0 bottom-0 {{ $bgClass }}" 
                                    style="width: {{ $levelPercentage }}%; opacity: 0.2;"></div>
                                
                                <div class="card-body position-relative">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h3 class="h5 mb-2">{{ $level->title }}</h3>
                                            <p class="mb-3">{{ $level->description }}</p>
                                        </div>
                                        <span class="badge {{ $bgClass }}">
                                            {{ number_format($level->target_amount, 2) }} €
                                        </span>
                                    </div>
                                    
                                    
                                    <div class="mt-2 text-end small">
                                        @if($totalDonations >= $level->target_amount)
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> Objectif atteint
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                {{ number_format($totalDonations, 2) }} € / {{ number_format($level->target_amount, 2) }} €
                                                ({{ floor($levelPercentage) }}%)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Carte de don -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4">Soutenir ce projet</h2>
                    
                    @if(now()->gt($project->end_date))
                        <div class="alert alert-warning">
                            Ce projet est terminé depuis le {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}
                        </div>
                    @else
                        @auth
                            <a href="#" class="btn btn-success btn-lg w-100 mb-3">
                                Faire un don
                            </a>
                        @else
                            <div class="alert alert-info">
                                <p>Vous devez être connecté pour faire un don.</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Se connecter</a>
                                <a href="{{ route('register') }}" class="btn btn-success">S'inscrire</a>
                            </div>
                        @endauth
                    @endif
                    
                    <!-- Récompenses -->
                    @if($project->rewardTiers->isNotEmpty())
                    <h3 class="h5 mt-4">Récompenses</h3>
                    <div class="reward-tiers">
                        @foreach($project->rewardTiers as $tier)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h4 class="h6">{{ $tier->title }}</h4>
                                <p class="small">{{ $tier->description }}</p>
                                <span class="badge bg-success">À partir de {{ number_format($tier->minimum_amount, 2) }} €</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Derniers dons -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title h4">Derniers soutiens</h2>
                    @if($project->donations->isNotEmpty())
                    <ul class="list-group list-group-flush">
                        @foreach($project->donations as $donation)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>
                                    @if($donation->user)
                                        {{ $donation->user->name }}
                                    @else
                                        Anonyme
                                    @endif
                                </span>
                                <strong>{{ number_format($donation->amount, 2) }} €</strong>
                            </div>
                            <small class="text-muted">{{ $donation->created_at->diffForHumans() }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">Aucun don pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
