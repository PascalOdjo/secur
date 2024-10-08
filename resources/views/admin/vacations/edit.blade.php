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
                            <li class="breadcrumb-item active" aria-current="page">Modifier</li>
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
    </div>

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Modifier</h5>
                    </div>
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
                        <form method="POST" action="{{ route('admin.vacations.update', $vacation->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.vacations.create', ['isEdit' => true, 'vacation' => $vacation])  <!-- include edit form and past data for agents modification -->

                            <!-- Sélecteurs pour les agents -->
                            <div class="form-group">
                                <label for="agent_1_id">Agent 1:</label>
                                <select name="agent_1_id" id="agent_1_id" class="form-control" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $vacation->agent_1_id == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->nom }} {{$agent->prenom}}<!-- Remplacez 'name' par le champ approprié -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="agent_2_id">Agent 2:</label>
                                <select name="agent_2_id" id="agent_2_id" class="form-control" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $vacation->agent_2_id == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->nom }} {{$agent->prenom}} <!-- Remplacez 'name' par le champ approprié -->
                                        </option>
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
                            <button type="submit" class="btn btn-primary">Mettre à jour</button> 
                            <a href="{{route('admin.vacations.index')}}" class="btn btn-secondary"><i class="ri-arrow-go-back-line mr-2"></i>Annuler</a> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection