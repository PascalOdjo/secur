@extends('layouts.app')

@section('content')
     
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Administration</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Gestion des Agents</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="{{route('admin.agents.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                        </div>                        
                    </div>
                </div>
            </div>
        
   


    <div class="contentbar">   
        <!-- Start row -->
       
        <!-- End row -->
        <!-- Start row -->
        <div class="row"> 
             
            <!-- Start col -->
            <div class="col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-header text-center">                                
                        <h5 class="card-title mb-0">Photo de Profile</h5>
                    </div>
                    <div class="card-body text-center ">
                        @if($agent->passport_photo)
                            <img src="{{asset($agent->passport_photo ) }}" alt="Photo de {{ $agent->nom }}" width="200" style="border-radius: 50%;">
                        @else
                            <p>Pas de photo</p>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-3 border-right px-0">
                                <p class="my-2">Nom</p>
                                <h5>{{old('nom', $agent->nom) ?? '-'}}</h5>
                            </div>
                            <div class="col-3 border-right px-0">
                                <p class="my-2">Prénom</p>
                                <h5>{{old('prenom', $agent->prenom) ?? '-'}}</h5>
                            </div>
                            <div class="col-3 border-right px-0">
                                <p class="my-2">Sexe</p>
                                <h5>{{old('sexe', $agent->sexe) ?? '-'}}</h5>
                            </div>
                            <div class="col-3 px-0">
                                <p class="my-2">Age</p>
                                <h5> {{ isset($agent->age) ? $agent->age : '-' }} ans</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
       
        <!-- Start row -->
        <div class="row"> 
            
            <!-- Start col -->
            <div class="col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-header text-center">                                
                        <h5 class="card-title mb-0">Autres Informations</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="age">Adresse</label>
                                <input type="text" name="addresse" id="addresse" disabled required class="form-control" value="{{$agent->addresse}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="nationalite">Nationalité</label>
                                <input type="text" disabled class="form-control" id="nationalite" name="nationalite" required value="{{$agent->nationalite}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Email</label>
                                <input type="email" class="form-control" id="email" disabled name="email" required value="{{$agent->email}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Téléphone</label>
                                <input type="text" disabled class="form-control" id="telephone" placeholder="telephone" name="telephone" required value="{{$agent->telephone}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Taille</label>
                                <input type="text" class="form-control" id="taille" disabled  name="taille" required value="{{$agent->taille}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Type de Contrat</label>
                                <input type="text" disabled class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{$agent->type_contrat}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Date de début contrat</label>
                                <input type="text" class="form-control" id="nom" disabled placeholder="Nom" name="nom" required value="{{$agent->date_debut_contrat}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Date de fin Contrat</label>
                                <input type="text" disabled class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{$agent->date_fin_contrat}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Carte d'identité</label>
                                <input type="text" class="form-control" id="nom" disabled placeholder="Nom" name="nom" required value="{{$agent->carte_identite}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Casier Judiciaire</label>
                                <input type="text" disabled class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{$agent->casier_judiciaire}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Certificat de Naissance</label>
                                <input type="text" class="form-control" id="nom" disabled placeholder="Nom" name="nom" required value="{{$agent->certificat_naissance}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Certificat Médical</label>
                                <input type="text" disabled class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{$agent->certificat_medical}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Permis de résidence</label>
                                <input type="text" class="form-control" id="nom" disabled placeholder="Nom" name="nom" required value="{{$agent->permit_residence}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="prenom">Statut</label>
                                <input type="text" disabled class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{$agent->status}}">
                            </div>
                        </div> 
                        <div class="card-header">
                            <h5 class="card-title text-center font-25">Personnes à Prévenir</h5>
                        </div>
                        @if($agent->personneaprevenir && $agent->personneaprevenir->count() > 0)
                            @foreach($agent->personneaprevenir as $index => $personne)
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="personnes[{{ $index }}][nom]">Nom</label>
                                        <input type="text" name="personnes[{{ $index }}][nom]" value="{{ old('personnes.'.$index.'.nom', $personne->nom) }}" required class="form-control" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="personnes[{{ $index }}][prenom]">Prénom</label>
                                        <input type="text" name="personnes[{{ $index }}][prenom]" value="{{ old('personnes.'.$index.'.prenom', $personne->prenom) }}" required class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="personnes[{{ $index }}][contact]">Contact</label>
                                        <input type="text" name="personnes[{{ $index }}][contact]" value="{{ old('personnes.'.$index.'.contact', $personne->contact) }}" required class="form-control" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="personnes[{{ $index }}][profession]">Profession</label>
                                        <input type="text" name="personnes[{{ $index }}][profession]" value="{{ old('personnes.'.$index.'.profession', $personne->profession) }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="personnes[{{ $index }}][adresse]">Adresse</label>
                                    <input type="text" name="personnes[{{ $index }}][adresse]" value="{{ old('personnes.'.$index.'.adresse', $personne->adresse) }}" class="form-control" disabled>
                                </div>
                            @endforeach
                        @else
                            <p>Aucune personne à prévenir n'a été ajoutée pour cet agent.</p>
                        @endif

 
                        <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-warning">Modifier</a>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
        <!-- End row -->
    </div>


    {{-- <h1>Détails de l'agent</h1>
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
    </form> --}}
@endsection