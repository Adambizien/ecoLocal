@extends('layouts.app')
@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <h1 class="text-center mb-4">Gérer votre profil</h1>
                <div class="card-body">
                    <div class="py-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Mettre à jour les informations du profil</h5>
                            </div>
                            <div class="card-body">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Mettre à jour le mot de passe</h5>
                            </div>
                            <div class="card-body">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Supprimer le compte</h5>
                            </div>
                            <div class="card-body">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
