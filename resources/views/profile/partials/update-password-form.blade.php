<section>
    <header>
    @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ __('Le mot de passe a été mis à jour avec succès.') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <p class="mt-2 text-muted">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Mot de passe actuel') }}</label>
            <input 
                type="password" 
                id="update_password_current_password" 
                name="current_password" 
                class="form-control" 
                autocomplete="current-password" 
                required
            >
            @error('current_password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
            <input 
                type="password" 
                id="update_password_password" 
                name="password" 
                class="form-control" 
                autocomplete="new-password" 
                required
            >
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
            <input 
                type="password" 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                class="form-control" 
                autocomplete="new-password" 
                required
            >
            @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
        </div>
    </form>
</section>
