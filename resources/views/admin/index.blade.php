@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.partials.users.index') }}">Gérer les Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.partials.projects') }}">Gérer les Projets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.partials.categories.index') }}">Gérer les Catégories</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection