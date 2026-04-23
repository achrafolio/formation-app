@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Détails de la Formation</h3>
                    <a href="{{ route('formations.index') }}" class="btn btn-light btn-sm">Retour</a>
                </div>
                <div class="card-body">
                    <h4>{{ $formation->titre }}</h4>
                    <hr>
                    <p><strong>Description:</strong></p>
                    <p>{{ $formation->description }}</p>
                    
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Formateur:</strong> {{ $formation->formateur }}</li>
                        <li class="list-group-item"><strong>Durée:</strong> {{ $formation->duree }}</li>
                        <li class="list-group-item"><strong>Date de début:</strong> {{ date('d/m/Y', strtotime($formation->date_debut)) }}</li>
                        <li class="list-group-item"><strong>Créée le:</strong> {{ $formation->created_at->format('d/m/Y H:i') }}</li>
                    </ul>

                    <div class="d-flex">
                        <a href="{{ route('formations.edit', $formation->id) }}" class="btn btn-warning me-2">Modifier</a>
                        <form action="{{ route('formations.destroy', $formation->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
