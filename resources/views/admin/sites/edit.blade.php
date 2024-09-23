@extends('layouts.app')
@section('content')
    <div id="containerbar">
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">Gestion des Sites</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Gestion des Sites</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                        </ol>
                    </div>
                </div>
    
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                        <a href="{{route('admin.sites.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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
                        <form method="POST" action="{{ route('admin.sites.update', $sites->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.sites.create', ['isEdit' => true, 'sites' => $sites])  <!-- include create form and past data -->

                            <button type="submit" class="btn btn-primary">Mettre à jour</button> 
                            <a href="{{route('admin.sites.index')}}" class="btn btn-secondary"><i class="ri-arrow-go-back-line mr-2"></i>Annuler</a> <a href="{{route('admin.sites.index')}}"></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection