@extends('admin.index')

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h1 class="h2">Créer une nouvelle catégorie</h1>
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nom de la catégorie</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Créer</button>
            </form>
        </main>
    </div>
</div>
@endsection