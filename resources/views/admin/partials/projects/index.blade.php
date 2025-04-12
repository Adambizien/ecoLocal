@extends('admin.index')

@section('admin-content')
    <div class="container-fluid">
        <div class="row">
            <main class="col-12 px-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 mt-3 gap-2">
                    <h1 class="h2 mb-0">Gestion des Projets</h1>
                    <a href="{{ route('admin.partials.projects.create') }}" class="btn btn-success">
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

                            <div class="col">
                                <div class="card h-100 border-1 rounded-3 shadow-sm project-card" style="background-color: #f8f9fa; transition: all 0.3s ease;">
                                    <div class="position-relative">
                                        @if($project->image)
                                            <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top img-fluid" alt="{{ $project->title }}" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="d-flex justify-content-center align-items-center bg-light" style="height: 150px;">
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
                                        <span class="badge bg-info position-absolute top-0 end-0 m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Créateur du projet">
                                            {{ Str::limit($project->user->email, 10) }}
                                        </span>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ Str::limit($project->title, 30) }}</h5>
                                        <p class="card-text text-muted small">{{ Str::limit($project->description, 80) }}</p>

                                        <div class="mt-auto">
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
                                    </div>

                                    <div class="card-footer bg-white border-top">
                                        <div class="d-flex flex-wrap gap-2">
                                            <form action="{{ route('admin.projects.toggle-validation', $project->id) }}" method="POST" class="flex-grow-1" style="min-width: 120px;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $project->validated ? 'btn-warning' : 'btn-success' }} w-100">
                                                    <i class="fas {{ $project->validated ? 'fa-times-circle' : 'fa-check-circle' }} me-1"></i>
                                                    {{ $project->validated ? 'Invalider' : 'Valider' }}
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('admin.partials.projects.edit', $project->id) }}" class="btn btn-sm btn-warning flex-grow-1" style="min-width: 100px;">
                                                <i class="fas fa-edit me-1"></i> Modifier
                                            </a>
                                            
                                            <form action="{{ route('admin.partials.projects.destroy', $project->id) }}" method="POST" class="flex-grow-1" style="min-width: 100px;">
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
        }
        
        .project-card {
            transition: all 0.3s ease !important;
        }
        
        @media (max-width: 768px) {
            .card-title {
                font-size: 1rem;
            }
            .card-text {
                font-size: 0.8rem;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
            .row-cols-sm-2 {
                grid-template-columns: repeat(1, 1fr);
            }
            .d-flex.justify-content-between.align-items-center.text-muted.small.mb-2 span {
                font-size: 0.7rem;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush