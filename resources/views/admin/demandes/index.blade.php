@extends('layouts.app')




@section('content')

<div id="containerbar"> 
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Demande</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Gestion des Demandes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liste</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar" style="color: white;">
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>                        
            </div>
        </div>          
    </div>
    <!-- End Breadcrumbbar -->
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        @include('_message')
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <h5 class="card-title">Liste des demandes</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.demandes.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" placeholder="Rechercher par nom, prénom, email ou contact" value="{{ request()->get('search') }}">
                                
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </form>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Email</th>
                                    <th>Adresse</th>
                                    <th>Téléphone</th>
                                    {{-- <th>Sexe</th> --}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($demandes->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune demande n'a été trouvé !</td>
                                    </tr>
                                    @else
                                    @foreach ($demandes as $demande)
                                        <tr>
                                            <td>{{ $demande->client->nom }}</td>
                                            <td>{{ $demande->client->prenom }}</td>
                                            <td>{{ $demande->client->email }}</td>
                                            <td>{{ $demande->client->adresse }}</td>
                                            <td>{{ $demande->client->telephone }}</td>
                                            {{-- <td>{{ $client->sexe }}</td> --}}
                                            <td class="text-center">
                                                <a href="{{ route('admin.demandes.show', $demande->id) }}" class="btn btn-info"><i class="ri-eye-line"></i></a>
                                                <a href="{{ route('admin.demandes.edit', $demande->id) }}" class="btn btn-warning"><i class="ri-edit-line"></i></a>
                                                <form action="{{ route('admin.demandes.destroy', $demande->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
   
    <!-- End col -->
</div>





   
@endsection

