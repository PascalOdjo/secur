@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Vacations</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Gestion des Vacations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.vacations.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Modifier la Vacation</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vacations.update', $vacation->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="type_vacation">Type de Vacation</label>
                                <select id="type_vacation" class="form-control" name="type_vacation" required>
                                    <option value="sys_08" {{ $vacation->type_vacation == 'sys_08' ? 'selected' : '' }}>Système 08h</option>
                                    <option value="sys_12" {{ $vacation->type_vacation == 'sys_12' ? 'selected' : '' }}>Système 12h</option>  
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="shift">Shift</label>
                                <select id="shift" class="form-control" name="shift" required>
                                    <option value="jour" {{ $vacation->shift == 'jour' ? 'selected' : '' }}>Jour</option>
                                    <option value="nuit" {{ $vacation->shift == 'nuit' ? 'selected' : '' }}>Nuit</option>
                                    <option value="apre_midi" {{ $vacation->shift == 'apre_midi' ? 'selected' : '' }}>Après-midi</option>
                                    <option value="journee_entiere" {{ $vacation->shift == 'journee_entiere' ? 'selected' : '' }}>Journée Entière</option>
                                    <option value="evenementiel" {{ $vacation->shift == 'evenementiel' ? 'selected' : '' }}>Événementiel</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="start_time">Heure de début</label>
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $vacation->start_time) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="end_time">Heure de fin</label>
                                <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $vacation->end_time) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="agent_1_id">Agent 1</label>
                                <select id="agent_1_id" class="form-control" name="agent_1_id" required>
                                    <option value="" disabled {{ old('agent_1_id') == '' ? 'selected' : '' }}>Choisir...</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $vacation->agent_1_id == $agent->id ? 'selected' : '' }}>{{ $agent->nom }} {{ $agent->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="agent_2_id">Agent 2</label>
                                <select id="agent_2_id" class="form-control" name="agent_2_id" required>
                                    <option value="" disabled {{ old('agent_2_id') == '' ? 'selected' : '' }}>Choisir...</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $vacation->agent_2_id == $agent->id ? 'selected' : '' }}>{{ $agent->nom }} {{ $agent->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="site_id">Site</label>
                                <select name="site_id" id="site_id" class="form-control" required>
                                    <option value="" disabled {{ old('site_id') == '' ? 'selected' : '' }}>Choisir...</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}" {{ $vacation->site_id == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="demande_id">Demande</label>
                                <select name="demande_id" id="demande_id" class="form-control" required>
                                    <option value="" disabled {{ old('demande_id') == '' ? 'selected' : '' }}>Choisir...</option>
                                    @foreach ($demandes as $demande)
                                        <option value="{{ $demande->id }}" {{ $vacation->demande_id == $demande->id ? 'selected' : '' }}>{{ $demande->client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Statut</label>
                                <select id="status" class="form-control" name="status" required>
                                    <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>Choisir...</option>
                                    <option value="en_cours" {{ $vacation->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="cree" {{ $vacation->status == 'cree' ? 'selected' : '' }}>Créé</option>
                                    <option value="affecte" {{ $vacation->status == 'affecte' ? 'selected' : '' }}>Affecté</option>
                                    <option value="termine" {{ $vacation->status == 'termine' ? 'selected' : '' }}>Terminé</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            <a href="{{ route('admin.vacations.index') }}" class="btn btn-secondary"><i class="ri-arrow-go-back-line mr-2"></i>Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('type_vacation').addEventListener('change', function() {
        var shiftOption = document.getElementById('shift_apres_midi');
        if (this.value === 'sys_08') {
            shiftOption.style.display = 'block'; // Affiche l'option 'après-midi'
        } else {
            shiftOption.style.display = 'none'; // Cache l'option 'après-midi'
            // Réinitialiser la sélection si l'option est cachée
            if (document.getElementById('shift').value === 'après-midi') {
                document.getElementById('shift').value = 'jour'; // Choisir une autre option par défaut
            }
        }
    });
</script>
@endsection