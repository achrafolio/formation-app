@extends('layouts.app')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bienvenue sur Formation App</h1>
            <p class="col-md-8 fs-4">
                Une application simple et efficace pour gérer votre catalogue de formations. 
                Ajoutez, modifiez et organisez vos cours facilement.
            </p>
            <a href="{{ route('formations.index') }}" class="btn btn-primary btn-lg">Voir la liste des formations</a>
        </div>
    </div>
@endsection
