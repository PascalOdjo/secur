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
                        <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button class="btn btn-primary"><i class="ri-back-arrow-line mr-2"></i>retour</button>
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
                        <h5 class="card-title text-center font-25">Formulaire d'Inscription</h5>
                    </div>
                    <div class="card-body">
                        
                        
                        </form>
                        
                        <form action="{{route('agents.store')}}" method="POST">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prenom">Prénoms</label>
                                    <input type="text" class="form-control" id="prenom" placeholder="Prénoms" name="prenom">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Adresse e-mail" name="email">
                            </div>
                            <div class="form-group">
                                <label for="telephone">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" placeholder="numero de téléphone" name="telephone">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" name="adresse">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Sexe</label>
                                    <select id="inputState" class="form-control" name="sexe">
                                        <option selected>Choisir...</option>
                                        <option>Masculin</option>
                                        <option>Féminin</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="nationalite">Nationalité</label>
                                    <select id="nationalite" class="form-control" name="nationalite">
                                        <option selected>Choisir...</option>
                                        <option>Burkina Faso</option>
                                        <option>Mali</option>
                                        <option>Cote d'Ivoire</option>
                                        <option>Ghana</option>
                                        <option>Nigeria</option>
                                        <option>Togo</option>
                                        <option>Benin</option>
                                        <option>Senegal</option>
                                        <option>Autre</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
    <!-- End col -->
</div>
{{-- <div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Administration</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Forms</a></li>   
                    <li class="breadcrumb-item active" aria-current="page">Validations</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Ajouter</button>
            </div>
        </div>
    </div>
    <h1>Ajouter un agent</h1>
    <form action="{{ route('agents.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
        </div>
        <div class="form-group">
            <label for="addresse">Addresse</label>
            <input type="text" class="form-control" id="addresse" name="addresse" required>
        </div>
        <div class="form-group">
            <label for="sexe">Sexe</label>
            <input type="text" class="form-control" id="sexe" name="sexe" required>
        </div>
        <div class="form-group">
            <label for="nationalite">Nationalité</label>
            <input type="text" class="form-control" id="nationalite" name="nationalite" required>
        </div>
        <div class="form-group">
            <label for="taille">Taille</label>
            <input type="text" class="form-control" id="taille" name="taille" required>
        </div>
        <div class="form-group">
            <label for="type_contrat">Type de contrat</label>
            <input type="text" class="form-control" id="type_contrat" name="type_contrat" required>
        </div>
        <div class="form-group">
            <label for="date_debut_contrat">Date de début de contrat</label>
            <input type="date" class="form-control" id="date_debut_contrat" name="date_debut_contrat" required>
        </div>
        <div class="form-group">
            <label for="date_fin_contrat">Date de fin de contrat</label>
            <input type="date" class="form-control" id="date_fin_contrat" name="date_fin_contrat" required>
        </div>
        <div class="form-group">
            <label for="carte_identite">Carte d'identité</label>
            <input type="file" class="form-control" id="carte_identite" name="carte_identite" required>
        </div>
        <div class="form-group">
            <label for="passport_photo">Photo de passeport</label>
            <input type="file" class="form-control" id="passport_photo" name="passport_photo" required>
        </div>
        <div class="form-group">
            <label for="casier_judiciaire">Casier judiciaire</label>
            <input type="file" class="form-control" id="casier_judiciaire" name="casier_judiciaire" required>
        </div>
        <div class="form-group">
            <label for="certificat_naissance">Certificat de naissance</label>
            <input type="file" class="form-control" id="certificat_naissance" name="certificat_naissance" required>
        </div>
        <div class="form-group">
            <label for="certificat_medical">Certificat médical</label>
            <input type="file" class="form-control" id="certificat_medical" name="certificat_medical" required>
        </div>
        <div class="form-group">
            <label for="permit_residence">Permis de résidence</label>
            <input type="file" class="form-control" id="permit_residence" name="permit_residence" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
     --}}
@endsection