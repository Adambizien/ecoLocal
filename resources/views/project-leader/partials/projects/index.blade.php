@extends('project-leader.index')

@section('project-leader-content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-11 ms-sm-auto col-lg-12 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <h1 class="h2">Gestion des Projets</h1>
                <a href="{{ route('project-leader.project.create') }}" class="btn btn-success ">
                    <i class="fas fa-plus"></i> Créer un nouveau projet
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($projects->isEmpty())
                <div class="alert alert-success text-center py-5">
                    <i class="fas fa-success-circle fa-3x mb-4"></i>
                    <h3>Aucun projet disponible</h3>
                    <p class="mb-4">Vous n'avez pas encore créé de projet. Commencez par en créer un nouveau.</p>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="margin-left: -15px; margin-right: -15px;">
                    @foreach($projects as $project)
                        @php
                            $totalDonations = $project->donations->sum('amount');
                            $percentage = $project->goal_amount > 0 ? min(round(($totalDonations / $project->goal_amount) * 100), 100) : 0;
                        @endphp

                        <div class="col" style="padding-left: 15px; padding-right: 15px;">
                            <div class="card border-1 rounded-3 shadow-sm project-card" style="background-color: #f8f9fa; width: 100%; transition: all 0.3s ease; transform: translateY(0);">
                                <div class="position-relative">
                                    @if($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}" style="height: 150px; object-fit: cover; width: 100%;">
                                    @else
                                        <div class="d-flex justify-content-center align-items-center bg-light" style="height: 150px; width: 100%;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="badge {{ $project->validated ? 'bg-success' : 'bg-warning' }} position-absolute top-0 start-0 m-2">
                                        {{ $project->validated ? 'Validé' : 'En attente' }}
                                    </span>
                                    @if($project->category)
                                        <span class="badge bg-secondary position-absolute bottom-0 end-0 m-2">
                                            {{ $project->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column border-top border-1">
                                    <h5 class="card-title">{{  Str::limit($project->title, 30) }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($project->description, 100) }}</p>

                                    <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                                        <span><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</span>
                                        <span class="mx-1">→</span> 
                                        <span><i class="far fa-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</span>
                                    </div>

                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{ $percentage == 0 ? '0.5' : $percentage }}%" 
                                             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 small">
                                        <span class="fw-bold text-success">{{ number_format($totalDonations, 2) }} €</span>
                                        <span class="text-muted">{{ $percentage }}%</span>
                                        <span class="text-muted">{{ number_format($project->goal_amount, 2) }} €</span>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-top">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('project-leader.project.edit', $project->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                            <i class="fas fa-edit me-1"></i> Modifier
                                        </a>
                                        <form action="{{ route('project-leader.project.destroy', $project->id) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet?')">
                                                <i class="fas fa-trash me-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

<style>
    .project-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease !important;
    }
    
    .project-card {
        transition: all 0.3s ease !important;
    }
</style>
@endsection