@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card" style="width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title text-center" style="color: #28a745;">{{ __('Inscription à Eco Local') }}</h5>
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                @error('password_confirmation')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Nom') }}</label>
                        <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('E-mail') }}</label>
                        <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirmez le mot de passe') }}</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" /> 
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="text-muted text-decoration-none" href="{{ route('login') }}">
                            {{ __('Déjà inscrit ?') }}
                        </a>
                        <button type="submit" class="btn" style="background-color: #28a745; color: white;">
                            {{ __("S'inscrire") }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
