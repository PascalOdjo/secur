@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Enregistrements</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Gestion des enregistrements</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('admin.enregistrements.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Formulaire de Modification' : 'Formulaire de Création' }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.enregistrements.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="name">Nom</label>
                                        <input id="nom" class="form-control" name="nom" value="{{ old('nom', isset($clients) ? $clients->nom : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address">Prénoms</label>
                                        <input id="prenom" class="form-control" name="prenom" value="{{ old('prenom', isset($clients) ? $clients->address : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', isset($clients) ? $clients->email : '') }}" required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Téléphone</label>
                                        <input type="telephone" name="telephone" class="form-control" id="telephone" value="{{ old('telephone', isset($clients) ? $clients->telephone : '') }}" required">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="adresse">Adresse</label>
                                        <input type="text" name="adresse" class="form-control" id="adresse" value="{{ old('adresse', isset($clients) ? $clients->adresse : '') }}" required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="entreprise">Entreprise</label> <label class="text-danger"></label>
                                        <input type="text" name="entreprise" class="form-control" id="entreprise" value="{{ old('entreprise', isset($clients) ? $clients->entreprise : '') }}" required">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="photo_passport">Photo passport</label>
                                        <input type="file" name="photo_passport" id="photo_passport" class="form-control">
                                    </div>
                                </div>

                                <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Modification de Sites' : 'Création de Sites' }}</h5>
                                
                                <div class="form-group">
                                    <label for="name">Nom du Site</label>
                                    <input id="name" class="form-control" name="name" value="{{ old('name', isset($sites) ? $sites->name : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                </div>
                                <div class="form-group">
                                    <label for="address">Adresse du Site</label>
                                    <input id="address" class="form-control" name="address" value="{{ old('address', isset($sites) ? $sites->address : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                </div>

                                <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Modification de Contrat' : 'Validation de Contrat' }}</h5>
                                <div class="form-group">
                                    <label for="nombre_contrat">Nombre de Contrats</label>
                                    <select id="nombre_contrat" class="form-control" name="nombre_contrat" required>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} Contrat{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type_vacation">Type de Vacation</label>
                                    <select id="type_vacation" class="form-control" name="type_vacation" required>
                                        <option value="sys_08" {{ old('type_vacation') == 'sys_08' ? 'selected' : '' }}>Système 08h</option>
                                        <option value="sys_12" {{ old('type_vacation') == 'sys_12' ? 'selected' : '' }}>Système 12h</option>  
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shift">Shift</label>
                                    <select id="shift" class="form-control" name="shift" required>
                                        <option value="jour" {{ old('shift') == 'jour' ? 'selected' : '' }}>Jour</option>
                                        <option value="nuit" {{ old('shift') == 'nuit' ? 'selected' : '' }}>Nuit</option>
                                        <option id="shift_apres_midi" value="apre_midi" {{ old('shift') == 'apre_midi' ? 'selected' : '' }}>Après-midi</option>
                                        <option value="journee_entiere" {{ old('shift') == 'journee_entiere' ? 'selected' : '' }}>Journée Entière</option>
                                        <option value="evenementiel" {{ old('shift') == 'evenementiel' ? 'selected' : '' }}>Événementiel</option>
                                    </select>
                                </div>


                            
                                <button type="submit" class="btn btn-primary">{{ isset($isEdit) && $isEdit ? 'Modifier' : 'Ajouter' }}</button>
                            </div>
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



