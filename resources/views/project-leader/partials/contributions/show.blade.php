@extends('project-leader.index')

@section('project-leader-content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h1 class=" h2">Détails du contributeur</h1>
        <a href="{{ url()->previous() }}" class="btn btn-outline-success">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- Carte d'informations -->
        <div class="col-md-4">
            <div class="card mb-4 border-top-success">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user me-1"></i>
                    Informations
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Inscrit depuis:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                    <p><strong>Total donné:</strong> <span class="badge bg-success">{{ number_format($user->donations->sum('amount'), 2) }} €</span></p>
                    <p><strong>Nombre de dons:</strong> <span class="badge bg-primary">{{ $user->donations->count() }}</span></p>
                </div>
            </div>
        </div>

        <!-- Historique des dons en cartes -->
        <div class="col-md-8">
            <div class="card mb-4 border-top-success">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-gift me-1"></i>
                    Historique des dons ({{ $user->donations->count() }})
                </div>
                <div class="card-body">
                    @if($user->donations->isEmpty())
                        <div class="alert alert-info">Aucun don enregistré</div>
                    @else
                        <div class="row">
                            @foreach($user->donations as $donation)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm">
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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-top-success {
        border-top: 4px solid #1cc88a !important;
    }
    .border-top-info {
        border-top: 4px solid #36b9cc !important;
    }
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush