@extends('layouts.app')

@section('title', 'À propos - ÉcoLocal')

@section('content')
<section class="hero-section bg-success bg-gradient text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Notre mission</h1>
                <p class="lead mb-4">Connecter les porteurs de projets écologiques avec une communauté engagée pour construire ensemble un avenir plus durable.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Notre histoire</h2>
                <p class="lead text-muted">ÉcoLocal, une entreprise née en Normandie en 2020</p>
                <p>Spécialisée dans le financement participatif pour des projets éco-responsables, notre plateforme a été créée pour favoriser la transition écologique en connectant porteurs de projets engagés et citoyens soucieux de leur impact environnemental.</p>
                <p>Nous offrons une alternative locale et durable au financement traditionnel, permettant à des initiatives écologiques de voir le jour grâce à la mobilisation collective. Acteur clé du financement de l'économie verte en Normandie, nous soutenons les projets qui répondent aux enjeux environnementaux actuels et futurs.</p>
                <p>En nous concentrant sur des initiatives locales, nous accompagnons entrepreneurs, agriculteurs, associations et collectivités normandes dans leurs démarches durables, renforçant ainsi l'économie circulaire et la résilience environnementale de notre région.</p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/team5.png') }}" alt="L'équipe ÉcoLocal" class="img-fluid rounded shadow-lg ">
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nos valeurs</h2>
            <p class="lead text-muted">Les principes qui guident nos actions</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-leaf text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Écologie</h5>
                        <p class="card-text">Nous sélectionnons rigoureusement les projets pour leur impact environnemental positif et leur durabilité.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-hands-helping text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Solidarité</h5>
                        <p class="card-text">Nous croyons en la force des communautés locales pour soutenir les projets qui les concernent directement.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 text-center p-4 h-100">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-lock text-success fs-3"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Transparence</h5>
                        <p class="card-text">Nous garantissons une information claire sur l'utilisation des fonds et le suivi des projets financés.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-success bg-opacity-10">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Notre équipe</h2>
                <p class="lead text-muted">Une équipe passionnée et engagée</p>
                <p>Notre équipe est composée de professionnels venant de divers horizons mais partageant la même conviction : l'écologie est l'avenir.</p>
                <p>Nous accompagnons chaque porteur de projet dans la construction de sa campagne et veillons à la bonne réalisation des projets financés.</p>
                <a href="#" class="btn btn-success mt-3">Nous contacter</a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="row g-4">
                    <div class="col-6">
                        <div class="text-center">
                            <img src="{{ asset('images/team1.png') }}" alt="Membre de l'équipe" 
                                 class="img-fluid rounded-circle shadow mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="mb-1">Le fou du c*l</h5>
                            <p class="text-muted small">Chef de Projet</p>
                        </div>
                        <div class="text-center mt-4">
                            <img src="{{ asset('images/team2.png') }}" alt="Membre de l'équipe" 
                                 class="img-fluid rounded-circle shadow" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="mb-1 mt-3">Le beau gosse originel</h5>
                            <p class="text-muted small">Responsable RH</p>
                        </div>
                    </div>
                    <div class="col-6 pt-5">
                        <div class="text-center">
                            <img src="{{ asset('images/team3.png') }}" alt="Membre de l'équipe" 
                                 class="img-fluid rounded-circle shadow mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="mb-1 mt-3">Philippe Echtttttttttttebez</h5>
                            <p class="text-muted small">Technicien controle qualité</p>
                        </div>
                        <div class="text-center mt-4">
                            <img src="{{ asset('images/team4.png') }}" alt="Membre de l'équipe" 
                                 class="img-fluid rounded-circle shadow" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="mb-1 mt-3">Le fou de la Gare</h5>
                            <p class="text-muted small">Designer UI/UX</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-5 bg-success text-white">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-4">Vous avez un projet écologique ?</h2>
        <p class="lead mb-4">Nous pouvons vous aider à le financer et le concrétiser</p>
        <p class="mb-4">Rejoignez notre communauté de porteurs de projets et profitez d'un accompagnement personnalisé en nous contactant à l'adresse suivante : <span class="fw-bold">666satanas92iElmorjen@gmail.com</span>.😈</p>
    </div>
</section>

<style>
    .hero-section {
        background: linear-gradient(135deg, #198754 0%, #0d6e3f 100%);
    }
    
    .card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 767px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .hero-section .lead {
            font-size: 1.1rem;
        }
        
        .btn-lg {
            padding: 0.5rem 1rem !important;
            font-size: 1rem !important;
        }
        
        .bg-success .d-flex {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem !important;
        }
        
        .bg-success .btn {
            margin-bottom: 0.5rem;
            width: 100%;
            max-width: 250px;
        }
    }
</style>
@endsection