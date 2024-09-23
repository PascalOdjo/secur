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
                    <a href="{{route('admin.vacations.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>
    </div>
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">{{ isset($isEdit) && $isEdit ? 'Formulaire de Modification de Sites' : 'Formulaire de Création de Sites' }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.sites.store')}}" method="POST" enctype="multipart/form-data">
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
                            
                                <div class="form-group">
                                    <label for="name">Nom du Site</label>
                                    <input id="name" class="form-control" name="name" value="{{ old('name', isset($sites) ? $sites->name : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                </div>
                                <div class="form-group">
                                    <label for="address">Adresse du Site</label>
                                    <input id="address" class="form-control" name="address" value="{{ old('address', isset($sites) ? $sites->address : '') }}" required> <!-- Pré-remplissage avec la valeur existante -->
                                </div>
                            
                                <button type="submit" class="btn btn-primary">{{isset($isEdit) && $isEdit ? 'Modifier' : 'Ajouter'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>
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
</script> --}}
@endsection



