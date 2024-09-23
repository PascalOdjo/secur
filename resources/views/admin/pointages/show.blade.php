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
                    <a href="{{route('admin.pointages.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Formulaire de Modification de Pointages' : 'Formulaire de Création de Pointages' }}</h5>
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
                    
                            <div class="form-group">
                                <label for="vacation_id">Vacation</label>
                                <select id="vacation_id" name="vacation_id" class="form-control" required disabled>
                                    @foreach ($vacations as $vacation)
                                        <option value="{{ $vacation->id }}" 
                                            {{ $vacation->id == $pointages->vacation_id ? 'selected' : '' }}>
                                            {{ $vacation->type_vacation }} - {{ $vacation->start_time }} à {{ $vacation->end_time }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="site_id">Site</label>
                                <select id="site_id" name="site_id" class="form-control" required disabled>
                                    <option value="">Sélectionner un site</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}" 
                                            {{ $site->id == $pointages->site_id ? 'selected' : '' }}>
                                            {{ $site->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="status">Statut</label>
                                <select id="status" name="status" class="form-control" required disabled>
                                    <option value="affecte" {{ $pointages->status == 'affecte' ? 'selected' : '' }}>Affecté</option>
                                    <option value="en_cours" {{ $pointages->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="termine" {{ $pointages->status == 'termine' ? 'selected' : '' }}>Terminé</option>
                                </select>
                            </div>
                    
                            <a href="{{ route('admin.pointages.edit', $pointages->id) }}" class="btn btn-warning">Modifier</a>
                       
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection



