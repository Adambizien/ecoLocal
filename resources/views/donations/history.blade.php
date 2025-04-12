@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Historique de vos dons</h1>

    @if($donations->isEmpty())
        <div class="alert alert-info">
            Vous n'avez effectué aucun don pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Projet</th>
                        <th>Montant</th>
                        <th>Récompenses</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('projects.show', $donation->project) }}">
                                    {{ $donation->project->title }}
                                </a>
                            </td>
                            <td>{{ number_format($donation->amount, 2) }} €</td>
                            <td>
                                @if($donation->rewardTiers->isNotEmpty())
                                    <ul class="list-unstyled">
                                        @foreach($donation->rewardTiers as $reward)
                                            <li>
                                                {{ $reward->title }}
                                                @if($reward->pivot->is_received)
                                                    <span class="badge bg-success">Reçue</span>
                                                @else
                                                    <span class="badge bg-warning">En attente</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Aucune récompense</span>
                                @endif
                            </td>
                            <td>
                                @if($donation->project->validated)
                                    <span class="badge bg-success">Projet validé</span>
                                @else
                                    <span class="badge bg-warning">En attente de validation</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $donations->links() }}
        </div>
    @endif
</div>
@endsection