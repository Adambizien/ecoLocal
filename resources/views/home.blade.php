@extends('layouts.app')

@section('title', 'Accueil - ÉcoLocal')

@section('content')
<section class="hero-section bg-success bg-gradient text-white py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Soutenez l'avenir local avec ÉcoLocal</h1>
                <p class="lead mb-4">Plateforme de financement participatif dédiée aux projets écologiques et locaux. Ensemble, faisons germer les initiatives qui comptent vraiment.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('public.projects.index') }}" class="btn btn-light btn-lg px-4">Découvrir les projets</a>
                    <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4">Comment ça marche ?</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">

                <img src="{{ asset('images/image.png') }}" alt="Projets écologiques" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Projets à la une</h2>
            <p class="lead text-muted">Découvrez nos projets coup de cœur</p>
        </div>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($featuredProjects as $project)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm project-card">
                    <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-dark">
                        <div class="position-relative">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" 
                                    class="card-img-top" 
                                    alt="{{ $project->title }}"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top d-flex justify-content-center align-items-center bg-light border-bottom border-1" 
                                    style="height: 180px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            @if($project->category)
                                <span class="badge bg-success position-absolute top-0 start-0 m-2">
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
                            <h5 class="card-title">{{ Str::limit($project->title, 40) }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($project->description, 100) }}
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $project->user->name }}
                                </small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                                <span><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</span>
                                <span class="mx-1">→</span> 
                                <span><i class="far fa-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $project->percentage == 0 ? '0.5' : $project->percentage }}%" 
                                    aria-valuenow="{{ $project->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 small">
                                <span class="fw-bold text-success">{{ number_format($project->totalDonations, 0, ',', ' ') }} €</span>
                                <span class="text-muted">{{ $project->percentage }}%</span>
                                <span class="text-muted">{{ number_format($project->goal_amount, 0, ',', ' ') }} €</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('public.projects.index') }}" class="btn btn-success px-4">Voir tous les projets</a>
        </div>
    </div>
</section>

<section id="how-it-works" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Comment ça marche ?</h2>
            <p class="lead text-muted">Soutenir un projet en 3 étapes simples</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-search text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">1. Découvrez</h5>
                        <p class="card-text">Parcourez notre sélection de projets locaux et écoresponsables qui vous parlent.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-hand-holding-heart text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">2. Soutenez</h5>
                        <p class="card-text">Choisissez le montant de votre contribution et participez à la réalisation du projet.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-seedling text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">3. Suivez</h5>
                        <p class="card-text">Recevez des nouvelles du projet et voyez l'impact de votre contribution.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-success bg-opacity-10">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <h3 class="fw-bold text-success display-5">+ {{ $stats['projectsCount'] }}</h3>
                <p class="text-muted">Projets financés</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-success display-5">+ {{ $stats['donationsSum'] }} €</h3>
                <p class="text-muted">Collectés</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-success display-5">+ {{ $stats['contributorsCount'] }}</h3>
                <p class="text-muted">Contributeurs</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-success display-5">{{ $stats['successRate'] }}%</h3>
                <p class="text-muted">Taux de réussite</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Ils nous font confiance</h2>
            <p class="lead text-muted">Découvrez ce que disent nos porteurs de projets</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="50" height="50" alt="Témoignage">
                            <div>
                                <h6 class="mb-0">Marie Dupont</h6>
                                <small class="text-muted">Ferme biologique "Les jardins de Marie"</small>
                            </div>
                        </div>
                        <p class="card-text">"Grâce à ÉcoLocal, nous avons pu financer notre nouvelle serre écologique. La communauté est incroyablement bienveillante et engagée !"</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="50" height="50" alt="Témoignage">
                            <div>
                                <h6 class="mb-0">Thomas Martin</h6>
                                <small class="text-muted">Atelier de réparation vélo "CycleVert"</small>
                            </div>
                        </div>
                        <p class="card-text">"La plateforme ÉcoLocal nous a permis de rencontrer des contributeurs passionnés par la mobilité douce. Un vrai succès pour notre atelier !"</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50" height="50" alt="Témoignage">
                            <div>
                                <h6 class="mb-0">Sophie Leroy</h6>
                                <small class="text-muted">Épicerie zéro déchet "La Graine"</small>
                            </div>
                        </div>
                        <p class="card-text">"L'équipe d'ÉcoLocal nous a accompagnés pas à pas dans notre campagne. Aujourd'hui notre épicerie est ouverte grâce à 150 contributeurs !"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-success text-white">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-4">Prêt à soutenir l'économie locale et durable ?</h2>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('public.projects.index') }}" class="btn btn-light btn-lg px-4">Découvrir les projets</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Créer un compte</a>
        </div>
    </div>
</section>

<style>
    .hero-section {
        background: linear-gradient(135deg, #198754 0%, #0d6e3f 100%);
    }
    
    .project-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    
    .progress {
        border-radius: 4px;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
    
    .card-img-top {
        transition: transform 0.3s ease;
    }
    
    .project-card:hover .card-img-top {
        transform: scale(1.05);
    }
</style>
@endsection