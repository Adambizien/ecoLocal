@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <button class="d-md-none btn btn-sm position-fixed rounded-circle shadow-sm" 
                style="left: 2px; top: 65px; width: 36px; height: 36px; background-color: #212529; border: none; color: white; z-index: 1015;"
                id="menuToggle">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </button>

        <div class="col-md-3 d-flex flex-column flex-shrink-0 p-3 text-bg-dark sidebar" id="sidebar" style="min-height: 110vh;">
            <h3>Menu Porteur de Projet</h3>
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

        <main class="col-md-9 p-3 main-content">
            @yield('project-leader-content')
        </main>
    </div>
</div>

<style>
    .sidebar {
        width: 350px;
        position: fixed;
        height: 100vh;
        transition: transform 0.3s ease;
        background-color: #212529;
    }
    
    .main-content {
        margin-left: 350px;
        transition: margin 0.3s ease;
    }
    
    @media (max-width: 767.98px) {
        .sidebar {
            transform: translateX(-100%);
            z-index: 1020;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            width: 280px;
        }
        
        .sidebar.show {
            transform: translateX(0);
            box-shadow: 5px 0 15px rgba(0,0,0,0.2);
        }
        
        .main-content {
            margin-left: 0;
            width: 100%;
        }
        
        #menuToggle {
            background-color: #212529 !important;
            transition: all 0.3s ease;
        }
        
        #menuToggle:hover {
            background-color: #343a40 !important;
            transform: scale(1.05);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            this.querySelector('i').classList.toggle('bi-grid-3x3-gap-fill');
            this.querySelector('i').classList.toggle('bi-x');
        });
        
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 767.98 && 
                !sidebar.contains(event.target) && 
                event.target !== menuToggle) {
                sidebar.classList.remove('show');
                menuToggle.querySelector('i').classList.add('bi-grid-3x3-gap-fill');
                menuToggle.querySelector('i').classList.remove('bi-x');
            }
        });
    });
</script>
@endsection