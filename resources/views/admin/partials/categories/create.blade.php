@extends('admin.index')

@section('admin-content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-11 col-lg-10 px-md-4">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h1 class="h2 mb-0">Créer une nouvelle catégorie</h1>
                    <a href="{{ route('admin.partials.categories.index') }}" class="btn text-white">
                        <i class="fas fa-arrow-left me-1"></i>
                    </a>
                </div>
                
                <div class="card-body">
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
                    
                    <form action="{{ route('category.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Nom de la catégorie</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-success btn-lg">Créer</button>
                            <a href="{{ route('admin.partials.categories.index') }}" class="btn btn-secondary btn-lg">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 5px;
        padding: 10px;
    }
    
    @media (max-width: 768px) {
        .btn-lg {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<script>
    (function () {
        'use strict'
        
        var forms = document.querySelectorAll('.needs-validation')
        
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection