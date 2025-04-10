@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar à gauche - fixe -->
            <div class="col-md-3 d-flex flex-column flex-shrink-0 p-3 text-bg-dark position-fixed vh-100">
                <h3>Menu porteur de projet</h3>
                <hr class="border-light">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('project-leader.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('project-leader.index') }}">
                            <i class="bi bi-person-circle"></i> Gérer les Projets
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('project-leader.contributions') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('project-leader.contributions') }}">
                            <i class="bi bi-briefcase"></i> Gérer les contributions
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('project-leader.statistics') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('project-leader.statistics') }}">
                            <i class="bi bi-graph-up"></i> Statistiques
                        </a>
                    </li>
                </ul>
            </div>

            <main class="col-md-9 offset-md-3 p-3">
                @yield('project-leader-content')
            </main>
        </div>
    </div>
@endsection