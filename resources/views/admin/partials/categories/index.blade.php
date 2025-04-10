@extends('admin.index')

@section('admin-content')
<div class="container-fluid px-0">
    <div class="row mx-0">
        <main class="col-12 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Gestion des Catégories</h1>
                <a href="{{ route('category.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Créer une nouvelle catégorie
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($categories as $category)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <span class="badge bg-info">
                                Catégorie
                            </span>
                            <small class="text-muted">#{{ $category->id }}</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-3 text-truncate" title="{{ $category->name }}">{{ $category->name }}</h5>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between gap-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning text-white flex-grow-1" title="Modifier">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
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
    .card {
        transition: all 0.2s ease;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: rgba(0, 0, 0, 0.02);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 500;
    }
    @media (min-width: 1200px) {
        .row-cols-lg-4 > * {
            flex: 0 0 auto;
            width: 25%;
        }
    }
</style>
@endsection