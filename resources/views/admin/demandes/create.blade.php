@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Création d'une Demande</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajouter une demande</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.demandes.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Formulaire de Création d'une Demande</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.demandes.store') }}" method="POST">
                            @csrf
                            <!-- Gestion des erreurs -->
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
                                    <label for="client_id">Client</label>
                                    <select id="client_id" name="client_id" class="form-control" required>
                                        <option value="">Sélectionner un client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_id">Site</label>
                                    <select id="site_id" name="site_id" class="form-control" required>
                                        <option value="">Sélectionner un site</option>
                                        @foreach ($sites as $site)
                                            <option value="{{ $site->id }}" data-client="{{ $site->client_id }}">{{ $site->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="status">Statut</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="en_cours">En cours</option>
                                        <option value="affecte">Affecté</option>
                                        <option value="termine">Terminé</option>
                                        <option value="annule">Annulé</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type_vacation">Type de Vacation :</label>
                                    <select id="type_vacation" name="type_vacation" class="form-control" required>
                                        <option value="sys_12">Système 12</option>
                                        <option value="sys_08">Système 08</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombre_contrats">Nombre d'agents</label>
                                    <input type="number" id="nombre_contrats" name="nombre_contrats" class="form-control" value="{{ old('nombre_contrats') }}" required min="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Créer la demande</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
