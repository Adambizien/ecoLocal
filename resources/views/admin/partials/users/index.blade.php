@extends('admin.index')

@section('admin-content')
<div class="container-fluid px-0">
    <div class="row mx-0">
        <main class="col-12 px-4">
            <div class="w-100 pt-3 pb-2 mb-3">
                <h1 class="h2">Gestion des Utilisateurs</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($users as $user)
                <div class="col d-flex">
                    <div class="card w-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'project_leader' ? 'bg-primary' : 'bg-secondary') }}">
                                {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'project_leader' ? 'Porteur' : 'User') }}
                            </span>
                            <small class="text-muted">#{{ $user->id }}</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="w-100 overflow-hidden">
                                    <h6 class="card-title mb-0" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" title="{{ $user->name }}">{{ $user->name }}</h6>
                                    <p class="card-text text-muted small mb-0" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" title="{{ $user->email }}">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.partials.users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white" title="Modifier">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('admin.partials.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </main>
    </div>
</div>

<style>
    .avatar {
        font-size: 1.1rem;
        font-weight: bold;
    }
    .card {
        transition: all 0.2s ease;
        border-radius: 8px;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    @media (min-width: 1200px) {
        .row-cols-lg-4 > * {
            flex: 0 0 auto;
            width: 25%;
        }
    }
</style>
@endsection