@extends('layouts.app')

@section('content')
     
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Administration</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Gestion des clients</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="{{route('admin.clients.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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
                        @if($clients->passport_photo)
                            <img src="{{asset($clients->passport_photo ) }}" alt="Photo de {{ $clients->nom }}" width="200" style="border-radius: 50%;">
                        @else
                            <p>Pas de photo</p>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-4 border-right px-0">
                                <p class="my-2">Nom</p>
                                <h5>{{old('nom', $clients->nom) ?? '-'}}</h5>
                            </div>
                            <div class="col-4 border-right px-0">
                                <p class="my-2">Prénom</p>
                                <h5>{{old('prenom', $clients->prenom) ?? '-'}}</h5>
                            </div>
                            
                            <div class="col-4 px-0">
                                <p class="my-2">Email</p>
                                <h5> {{ isset($clients->email) ? $clients->email : '-' }}</h5>
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
                                <input type="text" name="adresse" id="adresse" disabled required class="form-control" value="{{$clients->adresse}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="nationalite">Entreprise</label>
                                <input type="text" disabled class="form-control" id="nationalite" name="entreprise" required value="{{$clients->entreprise}}">
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Email</label>
                                <input type="email" class="form-control" id="email" disabled name="email" required value="{{$clients->email}}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="telephone">Téléphone</label>
                                <input type="text" disabled class="form-control" id="telephone" placeholder="telephone" name="telephone" required value="{{$clients->telephone}}">
                            </div>
                        </div>  
                         
                        
                        
                       
                        

 
                        <a href="{{ route('admin.clients.edit', $clients->id) }}" class="btn btn-warning">Modifier</a>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
        <!-- End row -->
    </div>



@endsection