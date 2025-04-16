@extends('admin.index')

@section('admin-content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid px-0 px-md-2">
    <div class="row justify-content-center mx-0">
        <main class="col-12 col-md-11 col-lg-10 px-2 px-md-3 px-lg-4">
            <div class="card shadow-sm mt-3 mt-md-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2 py-md-3">
                    <h1 class="h4 h3-md h2-lg mb-0">Modifier l'utilisateur</h1>
                    <a href="{{ route('admin.partials.users.index') }}" class="btn text-white py-1 py-md-2">
                        <i class="fas fa-arrow-left me-1"></i>
                    </a>
                </div>
                
                <div class="card-body p-2 p-md-3 p-lg-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.partials.users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-2 g-md-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="role" class="form-label">Rôle</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="project_leader" {{ $user->role == 'project_leader' ? 'selected' : '' }}>Porteur de projet</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 mt-md-5 text-center text-md-end">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }

    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    @media (max-width: 576px) {
        .card-header {
            flex-direction: column;
            text-align: center;
        }
        
        .card-header h1 {
            margin-bottom: 0.5rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .ms-2 {
            margin-left: 0 !important;
        }
    }
    
    @media (min-width: 576px) and (max-width: 768px) {
        .card-header {
            padding: 0.75rem 1rem;
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