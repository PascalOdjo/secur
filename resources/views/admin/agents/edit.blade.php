@extends('layouts.app')

@section('content')

<div id="containerbar"> 
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Agents</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Gestion des Agents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier</li>
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
    <!-- End Breadcrumbbar -->
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Modifier un agent</h5>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{route('admin.agents.update', $agent->id)}}" method="POST" enctype="multipart/form-data">
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

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom"  value="{{old('nom', $agent->nom)}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prenom">Prénoms</label>
                                    <input type="text" class="form-control" id="prenom" placeholder="Prénoms" name="prenom"  value="{{old('prenom', $agent->prenom)}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Adresse e-mail" name="email"  value="{{$agent->email}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" placeholder="numero de téléphone" name="telephone"  value="{{$agent->telephone}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" id="age" step="1" min="1" max="100"  class="form-control" value="{{old('age', $agent->age)}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Sexe</label>
                                    <select id="inputState" class="form-control" name="sexe"  value="{{old('sexe', $agent->sexe)}}">
                                        <option selected>Choisir...</option>
                                        <option value="masculin" {{old('sexe', $agent->sexe) === 'masculin' ? 'selected' : ''}}>Masculin</option>
                                        <option value="feminin" {{old('sexe', $agent->sexe) === 'feminin' ? 'selected' : ''}}>Féminin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nationalite">Nationalité</label>
                                    <select id="nationalite" class="form-control" name="nationalite"  value="{{old('nationalite', $agent->nationalite)}}">
                                        <option selected>Choisir...</option>
                                        <option value="Burkina Faso" {{old('nationalite', $agent->nationalite) === 'Burkina Faso' ? 'selected' : ''}}>Burkina Faso</option>
                                        <option value="Mali" {{old('nationalite', $agent->nationalite) === 'Mali' ? 'selected' : ''}}>Mali</option>
                                        <option value="Cote d'Ivoire" {{old('nationalite', $agent->nationalite) === 'Cote d\'Ivoire' ? 'selected' : ''}}>Cote d'Ivoire</option>
                                        <option value="Ghana" {{old('nationalite', $agent->nationalite) === 'Ghana' ? 'selected' : ''}}>Ghana</option>
                                        <option value="Nigeria" {{old('nationalite', $agent->nationalite) === 'Nigeria' ? 'selected' : ''}}>Nigeria</option>
                                        <option value="Togo" {{old('nationalite', $agent->nationalite) === 'Togo' ? 'selected' : ''}}>Togo</option>
                                        <option value="Benin" {{old('nationalite', $agent->nationalite) === 'Benin' ? 'selected' : ''}}>Benin</option>
                                        <option value="Senegal" {{old('nationalite', $agent->nationalite) === 'Senegal' ? 'selected' : ''}}>Senegal</option>
                                        <option value="Autre" {{old('nationalite', $agent->nationalite) === 'Autre' ? 'selected' : ''}}>Autre</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="taille">Taille</label>
                                    <input type="number" name="taille" id="taille" step="0.01" min="0.50" max="2.50"  class="form-control" value="{{old('taille', $agent->taille)}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" name="addresse" id="addresse" class="form-control" value="{{old('addresse', $agent->addresse)}}">
                                
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Contrat de Travail</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="type_contrat">Type de Contrat</label>
                                    <select name="type_contrat" id="type_contrat" class="form-control"  value="{{old('type_contrat', $agent->type_contrat)}}">
                                        <option value="" selected>Choisir...</option>
                                        <option value="CDI" {{old('type_contrat', $agent->type_contrat) === 'CDI' ? 'selected' : ''}}>CDI</option>
                                        <option value="CDD" {{old('type_contrat', $agent->type_contrat) === 'CDD' ? 'selected' : ''}}>CDD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date_debut">Date debut</label>
                                    <input type="date" name="date_debut_contrat" class="form-control" value="{{old('date_debut_contrat', $agent->date_debut_contrat)}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Date fin</label>
                                    <input type="date" name="date_fin_contrat" class="form-control" value="{{old('date_fin_contrat', $agent->date_fin_contrat)}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Statut</label>
                                    <select name="status" id="status" class="form-control"  value="{{old('status', $agent->status)}}">
                                        <option value="" selected>Choisir...</option>
                                        <option value="actif" {{old('status', $agent->status) === 'actif' ? 'selected' : ''}}>Actif</option>
                                        <option value="Inactif" {{old('status', $agent->status) === 'Inactif' ? 'selected' : ''}}>Inactif</option>
                                        <option value="En attente" {{old('status', $agent->status) === 'En attente' ? 'selected' : ''}}>En attente</option>

                                    </select>
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Pièce Jointe</h5>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date_debut">Carte d'Identité</label>
                                        <input type="file" name="carte_identite" class="form-control"  >
                                        @if ($agent->carte_identite)
                                            <small>{{ $agent->carte_identite }}</small>
                                        @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Photo Passport</label>
                                    <input type="file" name="passport_photo" class="form-control"  >
                                    @if ($agent->passport_photo)    
                                        <small>{{ $agent->passport_photo }}</small>
                                        
                                    @endif
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="casier_judiciaire">Casier judiciaire</label>
                                    <input type="file" class="form-control" id="casier_judiciaire" name="casier_judiciaire"  >
                                    @if ($agent->casier_judiciaire)
                                        <small>{{ $agent->casier_judiciaire }}</small>
                                        
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="certificat_naissance">Certificat de naissance</label>
                                    <input type="file" class="form-control" id="certificat_naissance" name="certificat_naissance"  >
                                    @if ($agent->certificat_naissance)
                                        <small>{{ $agent->certificat_naissance }}</small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="certificat_medical">Certificat médical</label>
                                    <input type="file" class="form-control" id="certificat_medical" name="certificat_medical"  >
                                    @if ($agent->certificat_medical)
                                        <small>{{ $agent->certificat_medical }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="permit_residence">Permis de résidence</label>
                                    <input type="file" class="form-control" id="permit_residence" name="permit_residence" >
                                    @if ($agent->permit_residence)
                                        <small>{{ $agent->permit_residence }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Personnes à Prévenir</h5>
                            </div>
                            
                            <div class="form-row">
                                @if($agent->personneaprevenir && $agent->personneaprevenir->count() > 0)
                                    @foreach($agent->personneaprevenir as $index => $personne)
                                        <input type="hidden" name="personnes[{{ $index }}][id]" value="{{ $personne->id }}">
                                        <div class="form-group col-md-6">
                                            <label for="personnes[{{ $index }}][nom]">Nom</label>
                                            <input type="text" name="personnes[{{ $index }}][nom]" value="{{ old('personnes.'.$index.'.nom', $personne->nom) }}"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="personnes[{{ $index }}][prenom]">Prénom</label>
                                            <input type="text" name="personnes[{{ $index }}][prenom]" value="{{ old('personnes.'.$index.'.prenom', $personne->prenom) }}"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="personnes[{{ $index }}][contact]">Contact</label>
                                            <input type="text" name="personnes[{{ $index }}][contact]" value="{{ old('personnes.'.$index.'.contact', $personne->contact) }}"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="personnes[{{ $index }}][profession]">Profession</label>
                                            <input type="text" name="personnes[{{ $index }}][profession]" value="{{ old('personnes.'.$index.'.profession', $personne->profession) }}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="personnes[{{ $index }}][adresse]">Adresse</label>
                                            <input type="text" name="personnes[{{ $index }}][adresse]" value="{{ old('personnes.'.$index.'.adresse', $personne->adresse) }}" class="form-control">
                                        </div>
                                    @endforeach
                                @else
                                    <p>Aucune personne à prévenir n'a été ajoutée pour cet agent.</p>
                                @endif
                            </div>
                            
                            <div class="form-row">
                                <!-- Ajouter une nouvelle personne à prévenir -->
                                @if($agent->personneaprevenir && $agent->personneaprevenir->count() > 0)
                                    @php $newIndex = $agent->personneaprevenir->count(); @endphp
                                @else
                                    @php $newIndex = 0; @endphp
                                @endif
                                <div class="form-group col-md-6">
                                    <label for="personnes[{{ $newIndex }}][nom]">Nom</label>
                                    <input type="text" name="personnes[{{ $newIndex }}][nom]" class="form-control" placeholder="Nom de la personne à prévenir">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="personnes[{{ $newIndex }}][prenom]">Prénom</label>
                                    <input type="text" name="personnes[{{ $newIndex }}][prenom]" class="form-control" placeholder="Prénom">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="personnes[{{ $newIndex }}][contact]">Contact</label>
                                    <input type="text" name="personnes[{{ $newIndex }}][contact]" class="form-control" placeholder="Contact">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="personnes[{{ $newIndex }}][profession]">Profession</label>
                                    <input type="text" name="personnes[{{ $newIndex }}][profession]" class="form-control" placeholder="Profession">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="personnes[{{ $newIndex }}][adresse]">Adresse</label>
                                    <input type="text" name="personnes[{{ $newIndex }}][adresse]" class="form-control" placeholder="Adresse">
                                </div>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-primary"><i class="ri-save-3-fill mr-2 "></i> Sauvegarder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
    <!-- End col -->
</div>

@endsection