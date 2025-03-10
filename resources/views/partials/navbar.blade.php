<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">Eco Local</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="{{route('home')}}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Projets</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">À propos</a></li>
                @guest
                    <li class="nav-item">
                        <a class="btn btn-light text-success" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light text-success" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="btn btn-light text-success" href="{{ route('profile.edit') }}">Mon Profil</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light text-success">Déconnexion</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>