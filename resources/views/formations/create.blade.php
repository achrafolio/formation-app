@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Ajouter une Formation</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('formations.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formateur" class="form-label">Formateur</label>
                            <input type="text" class="form-control" id="formateur" name="formateur" value="{{ old('formateur') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="duree" class="form-label">Durée</label>
                            <input type="text" class="form-control" id="duree" name="duree" value="{{ old('duree') }}" placeholder="ex: 3 jours, 20 heures" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('formations.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
