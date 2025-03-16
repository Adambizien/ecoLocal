@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Sidebar à gauche -->
        <div class="col-md-3 d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
            <h3>Menu Admin</h3>
            <hr class="border-light">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.partials.users.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.users.index') }}">
                        <i class="bi bi-person-circle"></i> Gérer les Utilisateurs
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.projects') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.projects') }}">
                        <i class="bi bi-briefcase"></i> Gérer les Projets
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.partials.categories.index') ? 'bg-success text-white' : 'text-light' }}" href="{{ route('admin.partials.categories.index') }}">
                        <i class="bi bi-tags"></i> Gérer les Catégories
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenu principal à droite -->
        <main class="col-md-9 p-3 h-100">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
