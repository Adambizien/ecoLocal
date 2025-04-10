@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 d-flex flex-column flex-shrink-0 p-3 text-bg-dark position-fixed vh-100">
            <h3>Menu Admin</h3>
            <hr class="border-light">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.partials.users.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.users.index') }}">
                        <i class="bi bi-person-circle"></i> Gérer les Utilisateurs
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.projects.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.projects.index') }}">
                        <i class="bi bi-briefcase"></i> Gérer les Projets
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.categories.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.categories.index') }}">
                        <i class="bi bi-tags"></i> Gérer les Catégories
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.contributions.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.contributions.index') }}">
                        <i class="bi bi-graph-up"></i> Gérer les Contributions
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.statistics.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.statistics.index') }}">
                        <i class="bi bi-bar-chart"></i> Statistiques
                    </a>
                </li>
            </ul>
        </div>
        <main class="col-md-9 offset-md-3 p-3">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
