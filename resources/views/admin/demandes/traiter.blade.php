@extends('layouts.app')

@section('content')
    <h1>Confirmation de Contrat</h1>
    <p>Le contrat a été validé avec succès.</p>
    <ul>
        <li>Nombre d'agents : {{ $contrat->nombre_agents }}</li>
        <li>Type de contrat : {{ $contrat->type }}</li>
        <li>Valeur en exploitation : {{ $contrat->valeur_exploitation }}</li>
        <li>Valeur en trésorerie : {{ $contrat->valeur_tresorerie }}</li>
    </ul>
    <a href="{{ route('admin.demandes.index') }}" class="btn btn-primary">Retour à la liste des demandes</a>

@endsection
