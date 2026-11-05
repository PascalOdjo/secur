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
                        <form action="{{ route('admin.demandes.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="client_nom">Nom du Client</label>
                                    <input type="text" id="client_nom" name="client_nom" class="form-control" value="{{ old('client_nom') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_prenom">Prénom du Client</label>
                                    <input type="text" id="client_prenom" name="client_prenom" class="form-control" value="{{ old('client_prenom') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_email">Email</label>
                                    <input type="email" id="client_email" name="client_email" class="form-control" value="{{ old('client_email') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_telephone">Téléphone</label>
                                    <input type="tel" id="client_telephone" name="client_telephone" class="form-control" value="{{ old('client_telephone') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_adresse">Adresse</label>
                                    <input type="text" id="client_adresse" name="client_adresse" class="form-control" value="{{ old('client_adresse') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_passport_photo">Photo Passport</label>
                                    <input type="file" id="client_passport_photo" name="client_passport_photo" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="site_name">Nom du Site</label>
                                    <input type="text" id="site_name" name="site_name" class="form-control" value="{{ old('site_name') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_code">Code du Site (ex: 0331OIF)</label>
                                    <input type="text" id="site_code" name="site_code" class="form-control" value="{{ old('site_code') }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="site_address">Adresse du Site</label>
                                    <input type="text" id="site_address" name="site_address" class="form-control" value="{{ old('site_address') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_type">Type de Site</label>
                                    <select id="site_type" name="site_type" class="form-control" required>
                                        <option value="LION" {{ old('site_type') == 'LION' ? 'selected' : '' }}>LION</option>
                                        <option value="LIONNE" {{ old('site_type') == 'LIONNE' ? 'selected' : '' }}>LIONNE</option>
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
                                    <input type="number" id="nombre_agents" name="nombre_agents" class="form-control" value="{{ old('nombre_agents') }}" required min="4">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="montant_par_agent">Montant par agent <span class="text-danger">*</span></label>
                                    <input type="number" id="montant_par_agent" name="montant_par_agent" class="form-control" step="0.01" value="{{ old('montant_par_agent') }}" required min="1" placeholder="Ex: 105000">
                                    <small class="form-text text-muted">Salaire par agent = Montant ÷ 2</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="montant">Montant total brut</label>
                                    <input type="number" id="montant" name="montant" class="form-control" step="0.01" value="{{ old('montant') }}" min="0" readonly>
                                    <small class="form-text text-muted">Calculé automatiquement: nombre_agents × montant_par_agent</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="start_date">Date de début du contrat</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end_date">Date de fin du contrat</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nombreAgentsInput = document.getElementById('nombre_agents');
        const montantParAgentInput = document.getElementById('montant_par_agent');
        const montantInput = document.getElementById('montant');

        function calculateMontant() {
            const nombreAgents = parseFloat(nombreAgentsInput.value) || 0;
            const montantParAgent = parseFloat(montantParAgentInput.value) || 0;
            const montant = nombreAgents * montantParAgent;
            montantInput.value = montant > 0 ? montant.toFixed(2) : '';
        }

        nombreAgentsInput.addEventListener('input', calculateMontant);
        montantParAgentInput.addEventListener('input', calculateMontant);

        // Calculer au chargement si des valeurs existent
        calculateMontant();
    });
</script>

@endsection