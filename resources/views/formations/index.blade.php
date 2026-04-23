@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des Formations</h2>
        <a href="{{ route('formations.create') }}" class="btn btn-primary">Ajouter une formation</a>
    </div>

    @if($formations->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Formateur</th>
                    <th>Durée</th>
                    <th>Date de début</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formations as $formation)
                    <tr>
                        <td>{{ $formation->id }}</td>
                        <td>{{ $formation->titre }}</td>
                        <td>{{ $formation->formateur }}</td>
                        <td>{{ $formation->duree }}</td>
                        <td>{{ date('d/m/Y', strtotime($formation->date_debut)) }}</td>
                        <td>
                            <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('formations.edit', $formation->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('formations.destroy', $formation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Aucune formation disponible pour le moment.</div>
    @endif
@endsection
