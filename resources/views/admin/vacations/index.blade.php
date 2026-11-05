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
                        <li class="breadcrumb-item active" aria-current="page">Liste</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar" style="color: white;">
                    <a href="{{route('admin.vacations.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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
                        <h5 class="card-title">Liste des Vacations</h5>
                        {{-- <a href="{{route('vacations.create')}}" class="btn btn-primary"><i class="ri-add-line mr-2"></i> Ajouter</a> --}}
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle">Export des données vers Copy, CSV, Excel & Note.</h6>
                        
                        @if($vacations->isEmpty())
                            <div class="alert alert-info mb-3" role="alert">Pas de vacation disponible</div>
                        @else
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Shift</th>
                                        <th>Agent 1 (Jour)</th>
                                        <th>Agent 2 (Nuit)</th>
                                        <th>Heure de début</th>
                                        <th>Heure de fin</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vacations as $vacation)
                                            <tr>
                                                <td>{{ $vacation->code_vacation }}</td>
                                                <td>{{ $vacation->type_vacation }}</td>
                                                <td>{{ $vacation->shift }}</td>
                                                <td>{{ $vacation->agent1 ? $vacation->agent1->nom . ' ' . $vacation->agent1->prenom : 'Aucun agent (Jour)' }}</td>
                                                <td>{{ $vacation->agent2 ? $vacation->agent2->nom . ' ' . $vacation->agent2->prenom : 'Aucun agent (Nuit)' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vacation->start_time)->format('d/m/Y H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vacation->end_time)->format('d/m/Y H:i') }}</td>
                                                <td>{{ $vacation->status }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.vacations.show', $vacation->id) }}" class="btn btn-info"><i class="ri-eye-line"></i></a>
                                                    <a href="{{ route('admin.vacations.edit', $vacation->id) }}" class="btn btn-warning"><i class="ri-edit-line"></i></a>
                                                    <form action="{{ route('admin.vacations.destroy', $vacation->id) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $vacations->links('vendor.pagination.bootstrap-4') }}
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
