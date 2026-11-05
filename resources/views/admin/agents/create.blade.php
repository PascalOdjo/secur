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
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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

                        <form action="{{route('admin.agents.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                    <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom" required value="{{old('nom')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prenom">Prénoms</label>
                                    <input type="text" class="form-control" id="prenom" placeholder="Prénoms" name="prenom" required value="{{old('prenom')}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Adresse e-mail" name="email" required value="{{old('email')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" placeholder="numero de téléphone" name="telephone" value="{{old('telephone')}}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" id="age" step="1" min="18" max="65" required
                                        class="form-control" value="{{ old('age', $agent->age ?? '') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Sexe</label>
                                    <select id="inputState" class="form-control" name="sexe" required>
                                        <option value="">Choisir...</option>
                                        <option value="masculin" {{ old('sexe') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="féminin" {{ old('sexe') == 'féminin' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nationalite">Nationalité</label>
                                    <select id="nationalite" class="form-control" name="nationalite" required>
                                        <option value="">Choisir...</option>
                                        <option value="Burkina Faso" {{ old('nationalite') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                        <option value="Mali" {{ old('nationalite') == 'Mali' ? 'selected' : '' }}>Mali</option>
                                        <option value="Cote d'Ivoire" {{ old('nationalite') == "Cote d'Ivoire" ? 'selected' : '' }}>Cote d'Ivoire</option>
                                        <option value="Ghana" {{ old('nationalite') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                        <option value="Nigeria" {{ old('nationalite') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                        <option value="Togo" {{ old('nationalite') == 'Togo' ? 'selected' : '' }}>Togo</option>
                                        <option value="Benin" {{ old('nationalite') == 'Benin' ? 'selected' : '' }}>Benin</option>
                                        <option value="Senegal" {{ old('nationalite') == 'Senegal' ? 'selected' : '' }}>Senegal</option>
                                        <option value="Autre" {{ old('nationalite') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="taille">Taille</label>
                                    <input type="number" name="taille" id="taille" step="0.01" min="0.50" max="2.50" required class="form-control" value="{{old('taille')}}">
                                </div>



                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Addresse</label>
                                    <input type="text" name="addresse" id="addresse" class="form-control" required value="{{old('addresse')}}">
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Contrat de Travail</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="type_contrat">Type de Contrat</label>
                                    <select name="type_contrat" id="type_contrat" class="form-control" required>
                                        <option value="">Choisir...</option>
                                        <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                        <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date_debut">Date debut</label>
                                    <input type="date" name="date_debut_contrat" class="form-control" required value="{{old('date_debut_contrat')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Date fin</label>
                                    <input type="date" name="date_fin_contrat" class="form-control" required value="{{old('date_fin_contrat')}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status">Statut</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Choisir...</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>Inactif</option>
                                        <option value="on_permission" {{ old('status') == 'on_permission' ? 'selected' : '' }}>En attente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Pièce Jointe</h5>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date_debut">Carte d'Identité</label>
                                    <input type="file" name="carte_identite" class="form-control" required value="{{old('carte_identite')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Photo Passport</label>
                                    <input type="file" name="passport_photo" class="form-control" value="{{old('passport_photo')}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="casier_judiciaire">Casier judiciaire</label>
                                    <input type="file" class="form-control" id="casier_judiciaire" name="casier_judiciaire" required value="{{old('casier_judiciaire')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="certificat_naissance">Certificat de naissance</label>
                                    <input type="file" class="form-control" id="certificat_naissance" name="certificat_naissance" required value="{{old('certificat_naissance')}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="certificat_medical">Certificat médical</label>
                                    <input type="file" class="form-control" id="certificat_medical" name="certificat_medical" value="{{old('certificat_medical')}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="permit_residence">Permis de résidence</label>
                                    <input type="file" class="form-control" id="permit_residence" name="permit_residence" value="{{old('permit_residence')}}">
                                </div>
                            </div>

                            <div class="card-header">
                                <h5 class="card-title text-center font-25">Personnes à Prévenir</h5>
                            </div>

                            <div id="personnes-container">
                                <div class="form-row" id="personne-0">
                                    <div class="form-group col-md-6">
                                        <label for="personnes[0][nom]">Nom</label>
                                        <input type="text" name="personnes[0][nom]" class="form-control" placeholder="Nom de la personne à prévenir">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="personnes[0][prenom]">Prénom</label>
                                        <input type="text" name="personnes[0][prenom]" class="form-control" placeholder="Prénom">
                                    </div>
                                </div>
                                <div class="form-row" id="personne-0-contact">
                                    <div class="form-group col-md-6">
                                        <label for="personnes[0][contact]">Contact</label>
                                        <input type="text" name="personnes[0][contact]" class="form-control" placeholder="Contact">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="personnes[0][profession]">Profession</label>
                                        <input type="text" name="personnes[0][profession]" class="form-control" placeholder="Profession">
                                    </div>
                                </div>
                                <div class="form-group" id="personne-0-adresse">
                                    <label for="personnes[0][adresse]">Adresse</label>
                                    <input type="text" name="personnes[0][adresse]" class="form-control" placeholder="Adresse">
                                </div>
                            </div>

                            <button type="button" id="add-personne" class="btn btn-primary">Ajouter une autre personne à prévenir</button>

                            <script>
                                document.getElementById('add-personne').addEventListener('click', function() {
                                    // Demander à l'utilisateur s'il souhaite ajouter une autre personne
                                    const addAnother = confirm("Voulez-vous ajouter une autre personne à prévenir ?");

                                    if (addAnother) {
                                        // Compter le nombre de personnes déjà ajoutées
                                        const currentCount = document.querySelectorAll('[id^="personne-"]').length;
                                        const newIndex = currentCount; // Utiliser l'index actuel pour la nouvelle personne

                                        // Créer de nouveaux champs pour la nouvelle personne
                                        const newPersonDiv = document.createElement('div');
                                        newPersonDiv.classList.add('form-row');
                                        newPersonDiv.id = `personne-${newIndex}`;
                                        newPersonDiv.innerHTML = `
                                            <div class="form-group col-md-6">
                                                <label for="personnes[${newIndex}][nom]">Nom</label>
                                                <input type="text" name="personnes[${newIndex}][nom]" class="form-control" placeholder="Nom de la personne à prévenir">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="personnes[${newIndex}][prenom]">Prénom</label>
                                                <input type="text" name="personnes[${newIndex}][prenom]" class="form-control" placeholder="Prénom">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="personnes[${newIndex}][contact]">Contact</label>
                                                <input type="text" name="personnes[${newIndex}][contact]" class="form-control" placeholder="Contact">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="personnes[${newIndex}][profession]">Profession</label>
                                                <input type="text" name="personnes[${newIndex}][profession]" class="form-control" placeholder="Profession">
                                            </div>
                                            <div class="form-group">
                                                <label for="personnes[${newIndex}][adresse]">Adresse</label>
                                                <input type="text" name="personnes[${newIndex}][adresse]" class="form-control" placeholder="Adresse">
                                            </div>
                                        `;

                                        // Ajouter les nouveaux champs au conteneur
                                        document.getElementById('personnes-container').appendChild(newPersonDiv);
                                    }
                                });
                            </script>


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