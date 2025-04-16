<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm position-fixed top-0 w-100" style="z-index: 1050;">
    <div class="container-fluid">
        <a class="navbar-brand position-relative" href="{{ route('home') }}">
            <img src="{{ asset('images/ecolocal1.png') }}" 
                alt="Écolocal Logo" 
                height="55" 
                class="position-absolute top-0 start-0" 
                style="transform: translate(-10%, -40%); z-index: 1;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center text-lg-start text-center">
                <li class="nav-item">
                    <a class="nav-link text-white fs-6 mx-2 {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fs-6 mx-2 {{ request()->routeIs('public.projects.index') || request()->routeIs('projects.show') ? 'active fw-bold' : '' }}" href="{{ route('public.projects.index') }}">Projets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fs-6 mx-2 {{ request()->routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">À propos</a>
                </li>
                @if (Auth::check() && Auth::user()->isProjectLeader())
                    <li class="nav-item d-none d-lg-block my-1">
                        <a class="btn btn-light text-success fs-6 mx-2 {{ request()->routeIs('project-leader.project.create') ? 'active fw-bold' : '' }}" href="{{ route('project-leader.project.create') }}">
                            <i class="bi bi-plus-circle"></i> Créer un Projet
                        </a>
                    </li>
                    <li class="nav-item d-lg-none my-1">
                        <a class="btn btn-light text-success fs-6 w-100 {{ request()->routeIs('project-leader.project.create') ? 'active fw-bold' : '' }}" style="max-width: 200px; display: block; margin: auto;" href="{{ route('project-leader.project.create') }}">
                            <i class="bi bi-plus-circle"></i> Créer un Projet
                        </a>
                    </li>
                @endif

                @guest
                    <li class="nav-item my-1">
                        <a class="btn btn-light text-success fs-6 mx-2  {{ request()->routeIs('login') ? 'active' : '' }}" style="width: 100px;" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-light text-success fs-6 mx-2 {{ request()->routeIs('register') ? 'active' : '' }}" style="width: 100px;" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle text-white fs-6 mx-2 d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item fs-6 {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Mon Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item fs-6 {{ request()->routeIs('donations.history') ? 'active fw-bold' : '' }}" href="{{ route('donations.history') }}">
                                    <i class="bi bi-wallet"></i> Mes Dons
                                </a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item fs-6 {{ request()->routeIs('admin.partials.users.index') ? 'active fw-bold' : '' }}" href="{{ route('admin.partials.users.index') }}">
                                        <i class="bi bi-speedometer2"></i> Menu Admin
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->isProjectLeader())
                                <li>
                                    <a class="dropdown-item fs-6 {{ request()->routeIs('project-leader.index') ? 'active fw-bold' : '' }}" href="{{ route('project-leader.index') }}">
                                        <i class="bi bi-speedometer2"></i> Menu Porteur de Projet
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item fs-6">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item d-lg-none my-1">
                        <a class="btn btn-light text-success fs-6 w-100 {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}" style="max-width: 200px; display: block; margin: auto;" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i> Mon Profil
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <li class="nav-item d-lg-none my-1">
                            <a class="btn btn-light text-success fs-6 w-100 {{ request()->routeIs('admin.partials.users.index') ? 'active fw-bold' : '' }}" style="max-width: 200px; display: block; margin: auto;" href="{{ route('admin.partials.users.index') }}">
                                <i class="bi bi-speedometer2"></i> Menu Admin
                            </a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->isProjectLeader())
                        <li class="nav-item d-lg-none my-1">
                            <a class="btn btn-light text-success fs-6 w-100 {{ request()->routeIs('project-leader.index') ? 'active fw-bold' : '' }}" style="max-width: 200px; display: block; margin: auto;" href="{{ route('project-leader.index') }}">
                                <i class="bi bi-speedometer2"></i> Menu Porteur de Projet
                            </a>
                        </li>
                    @endif
                    <li class="nav-item d-lg-none my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light fs-6 w-100" style="max-width: 200px; display: block; margin: auto;">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>