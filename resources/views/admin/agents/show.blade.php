@extends('layouts.app')

@section('content')
    <h1>Détails de l'agent</h1>
    <p><strong>Nom:</strong> {{ $agent->nom }}</p>
    <p><strong>Prénom:</strong> {{ $agent->prenom }}</p>
    <p><strong>Email:</strong> {{ $agent->email }}</p>
    <p><strong>Téléphone:</strong> {{ $agent->telephone }}</p>
    <p><strong>Addresse:</strong> {{ $agent->addresse }}</p>
    <p><strong>Sexe:</strong> {{ $agent->sexe }}</p>
    <p><strong>Nationalité:</strong> {{ $agent->nationalite }}</p>
    <p><strong>Taille:</strong> {{ $agent->taille }}</p>
    <p><strong>Type de contrat:</strong> {{ $agent->type_contrat }}</p>
    <p><strong>Date de début de contrat:</strong> {{ $agent->date_debut_contrat }}</p>
    <p><strong>Date de fin de contrat:</strong> {{ $agent->date_fin_contrat }}</p>
    <p><strong>Carte d'identité:</strong> {{ $agent->carte_identite }}</p>
    <p><strong>Photo de passeport:</strong> {{ $agent->passport_photo }}</p>
    <p><strong>Casier judiciaire:</strong> {{ $agent->casier_judiciaire }}</p>
    <p><strong>Certificat de naissance:</strong> {{ $agent->certificat_naissance }}</p>
    <p><strong>Certificat médical:</strong> {{ $agent->certificat_medical }}</p>
    <p><strong>Permis de résidence:</strong> {{ $agent->permit_residence }}</p>
    <p><strong>Statut:</strong> {{ $agent->status }}</p>
    <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-warning">Modifier</a>
    <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
@endsection