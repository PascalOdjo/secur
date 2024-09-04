@extends('layouts.app')

@section('content')
    <h1>Modifier l'agent</h1>
    <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $agent->nom }}" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $agent->prenom }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $agent->email }}" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $agent->telephone }}">
        </div>
        <div class="form-group">
            <label for="addresse">Adresse</label>
            <input type="text" class="form-control" id="addresse" name="addresse" value="{{ $agent->addresse }}">
        </div>
        <div class="form-group">
            <label for="sexe">Sexe</label>
            <input type="text" class="form-control" id="sexe" name="sexe" value="{{ $agent->sexe }}">
        </div>
        <div class="form-group">
            <label for="nationalite">Nationalité</label>
            <input type="text" class="form-control" id="nationalite" name="nationalite" value="{{ $agent->nationalite }}">
        </div>
        <div class="form-group">
            <label for="taille">Taille</label>
            <input type="text" class="form-control" id="taille" name="taille" value="{{ $agent->taille }}">
        </div>
        <div class="form-group">
            <label for="type_contrat">Type de contrat</label>
            <input type="text" class="form-control" id="type_contrat" name="type_contrat" value="{{ $agent->type_contrat }}">
        </div>
        <div class="form-group">
            <label for="date_debut_contrat">Date de début de contrat</label>
            <input type="date" class="form-control" id="date_debut_contrat" name="date_debut_contrat" value="{{ $agent->date_debut_contrat }}">
        </div>
        <div class="form-group">
            <label for="date_fin_contrat">Date de fin de contrat</label>
            <input type="date" class="form-control" id="date_fin_contrat" name="date_fin_contrat" value="{{ $agent->date_fin_contrat }}">
        </div>
        <div class="form-group">
            <label for="carte_identite">Carte d'identité</label>
            <input type="file" class="form-control" id="carte_identite" name="carte_identite">
        </div>
        <div class="form-group">
            <label for="passport_photo">Photo de passeport</label>
            <input type="file" class="form-control" id="passport_photo" name="passport_photo">
        </div>
        <div class="form-group">
            <label for="casier_judiciaire">Casier judiciaire</label>
            <input type="file" class="form-control" id="casier_judiciaire" name="casier_judiciaire">
        </div>
        <div class="form-group">
            <label for="certificat_naissance">Certificat de naissance</label>
            <input type="file" class="form-control" id="certificat_naissance" name="certificat_naissance">
        </div>
        <div class="form-group">
            <label for="certificat_medical">Certificat médical</label>
            <input type="file" class="form-control" id="certificat_medical" name="certificat_medical">
        </div>
        <div class="form-group">
            <label for="permit_residence">Permis de résidence</label>
            <input type="file" class="form-control" id="permit_residence" name="permit_residence">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection