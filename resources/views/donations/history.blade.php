@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h1 class="h2">Historique de vos dons</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 border-top-success">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user me-1"></i>
                    Informations
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Inscrit depuis:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                    <p><strong>Total donné:</strong> <span class="badge bg-success">{{ number_format($donations->sum('amount'), 2) }} €</span></p>
                    <p><strong>Nombre de dons:</strong> <span class="badge bg-primary">{{ $donations->count() }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4 border-top-success">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-gift me-1"></i>
                    Historique des dons ({{ $donations->count() }})
                </div>
                <div class="card-body">
                    @if($donations->isEmpty())
                        <div class="alert alert-info">Aucun don enregistré</div>
                    @else
                        <div class="row">
                            @foreach($donations as $donation)
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('projects.show', $donation->project->id) }}" class="text-decoration-none text-dark">
                                    <div class="card multicard h-100 shadow-sm">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">{{ $donation->created_at->format('d/m/Y H:i') }}</span>
                                                <span class="badge bg-success">{{ number_format($donation->amount, 2) }} €</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate" style="max-width: 100%;" title="{{ $donation->project->title }}">
                                                {{ $donation->project->title }}
                                            </h5>
                                            
                                            <div class="mt-3">
                                                <h6 class="fw-bold">Récompenses :</h6>
                                                @if($donation->rewardTiers->isNotEmpty())
                                                    <ul class="list-group list-group-flush">
                                                        @foreach($donation->rewardTiers as $reward)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $reward->title }}
                                                            <span class="badge {{ $reward->pivot->is_received ? 'bg-success' : 'bg-warning' }}">
                                                                {{ $reward->pivot->is_received ? 'Reçu' : 'Non reçu' }}
                                                            </span>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">Aucune récompense</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">
                                                    @if($donation->project->validated)
                                                        <i class="fas fa-check-circle text-success me-1"></i> Projet validé
                                                    @else
                                                        <i class="fas fa-hourglass-half text-warning me-1"></i> En attente
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @if($donations->hasPages())
                        <div class="mt-3">
                            {{ $donations->links() }}
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .multicard {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .multicard:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection