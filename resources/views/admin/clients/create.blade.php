@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Vacations</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Gestion des Vacations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('admin.vacations.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Formulaire de Modification de Clientss' : 'Formulaire de Création de Clients' }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.clients.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="name">Nom</label>
                                        <input id="nom" class="form-control" name="nom" value="{{ old('nom', isset($clients) ? $clients->nom : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address">Prénoms</label>
                                        <input id="prenom" class="form-control" name="prenom" value="{{ old('prenom', isset($clients) ? $clients->address : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', isset($clients) ? $clients->email : '') }}" required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Téléphone</label>
                                        <input type="telephone" name="telephone" class="form-control" id="telephone" value="{{ old('telephone', isset($clients) ? $clients->telephone : '') }}" required">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="adresse">Adresse</label>
                                        <input type="text" name="adresse" class="form-control" id="adresse" value="{{ old('adresse', isset($clients) ? $clients->adresse : '') }}" required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="entreprise">Entreprise</label> <label class="text-danger"></label>
                                        <input type="text" name="entreprise" class="form-control" id="entreprise" value="{{ old('entreprise', isset($clients) ? $clients->entreprise : '') }}" required">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="photo_passport">Photo passport</label>
                                        <input type="file" name="photo_passport" id="photo_passport" class="form-control">
                                    </div>
                                </div>
                            
                                <button type="submit" class="btn btn-primary">{{isset($isEdit) && $isEdit ? 'Modifier' : 'Ajouter'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


