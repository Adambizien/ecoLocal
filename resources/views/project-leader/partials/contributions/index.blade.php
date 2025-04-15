@extends('project-leader.index')

@section('project-leader-content')
<div class="container-fluid px-4 mt-3">
    <h1 class="h2">Gestion des Contributeurs</h1>
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    @foreach($contributors as $user)
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card h-100 border-1 border-top-success shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-success fw-bold">{{ $user->name }}</div>
                                            <div class="small text-muted">{{ $user->email }}</div>
                                        </div>
                                        <div class="badge bg-success rounded-pill">ID: {{ $user->id }}</div>
                                    </div>
                                    <hr>
                                    <div class="mb-2">
                                        <span class="fw-bold">Dons :</span>
                                        <span class="badge bg-success"> {{ number_format($user->donations->sum('amount'), 2) }} €</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fw-bold">Nombre de dons :</span>
                                        <span class="badge bg-primary">{{ $user->donations->count() }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="fw-bold">Projets soutenus :</span>
                                        <div class="mt-2">
                                            @foreach($user->donations->groupBy('project_id') as $projectId => $donations)
                                                @php $project = $donations->first()->project; @endphp
                                                <span class=" text-muted">{{ Str::limit($project->title, 50) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('project-leader.contributors.show', $user->id) }}" class="btn btn-sm btn-success text-white">
                                            <i class="fas fa-eye me-1"></i> Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($contributors->isEmpty())
                    <div class="alert alert-success text-center py-5">
                        <i class="fas fa-users fa-3x text-success mb-3"></i>
                        <h3>Aucun contributeur trouvé</h3>
                        <p class="mb-4">
                            Il n'y a pas encore de contributeurs pour ce projet. 
                        </p>
                    </div>
                @endif
            </div> 
        </div>
    </div>
</div>
@endsection

