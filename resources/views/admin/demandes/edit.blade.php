@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Modification d'une Demande</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier la demande</li>
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
                        <h5 class="card-title text-center font-25">Formulaire de Modification d'une Demande</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.demandes.update', $demande->id) }}" method="POST">
                            @csrf
                            @method('PUT')

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
                                    <label for="montant">Montant (FCFA)</label>
                                    <input type="number" id="montant" name="montant" class="form-control" value="{{ old('montant', $demande->montant) }}" required step="0.01" min="0">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="start_date">Date de début</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $demande->start_date) }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="end_date">Date de fin</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $demande->end_date) }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="client_id">Client</label>
                                    <select id="client_id" name="client_id" class="form-control" required>
                                        <option value="">Sélectionner un client</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $demande->client_id ? 'selected' : '' }}>
                                            {{ $client->nom }} {{ $client->prenom }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_id">Site</label>
                                    <select id="site_id" name="site_id" class="form-control" required>
                                        <option value="">Sélectionner un site</option>
                                        @foreach ($sites as $site)
                                        <option value="{{ $site->id }}" {{ $site->id == $demande->site_id ? 'selected' : '' }}>
                                            {{ $site->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="status">Statut</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="en_cours" {{ $demande->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="affecte" {{ $demande->status == 'affecte' ? 'selected' : '' }}>Affecté</option>
                                        <option value="termine" {{ $demande->status == 'termine' ? 'selected' : '' }}>Terminé</option>
                                        <option value="annule" {{ $demande->status == 'annule' ? 'selected' : '' }}>Annulé</option>
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
                                    <label for="nombre_agents">Nombre d'agents</label>
                                    <input type="number" id="nombre_agents" name="nombre_agents" class="form-control" value="{{ old('nombre_agents', $demande->nombre_agents) }}" required min="4">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="montant_par_agent">Montant par agent <span class="text-danger">*</span></label>
                                    <input type="number" id="montant_par_agent" name="montant_par_agent" class="form-control" step="0.01" value="{{ old('montant_par_agent', $demande->montant_par_agent) }}" required min="1" placeholder="Ex: 105000">
                                    <small class="form-text text-muted">Salaire par agent = Montant ÷ 2</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="montant">Montant total brut</label>
                                    <input type="number" id="montant" name="montant" class="form-control" step="0.01" value="{{ old('montant', $demande->montant) }}" readonly>
                                    <small class="form-text text-muted">Calculé automatiquement: nombre_agents × montant_par_agent</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control">{{ old('description', $demande->description) }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour la demande</button>
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