<section class="space-y-6">
    <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <div class="mb-3">
            <h5 class="text-danger">{{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}</h5>
            <p class="text-muted">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer votre compte de façon permanente.') }}
            </p>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="{{ __('Mot de passe') }}" 
                required
            >
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-danger">{{ __('Supprimer le compte') }}</button>
        </div>
    </form>
</section>
