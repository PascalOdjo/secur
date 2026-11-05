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
                        <li class="breadcrumb-item active" aria-current="page">Voir</li>
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
</div>

<div class="contentbar">
    <div class="row">
        <div class="col-lg-12 m-b-30">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Voir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Shift</th>
                                    <th>Agent 1</th>
                                    <th>Agent 2</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $vacation->code_vacation }}</td>
                                    <td>{{ $vacation->type_vacation }}</td>
                                    <td>{{ $vacation->shift }}</td>
                                    <td>{{ $vacation->agent1 ? $vacation->agent1->nom . ' ' . $vacation->agent1->prenom : 'N/A' }}</td>
                                    <td>{{ $vacation->agent2 ? $vacation->agent2->nom . ' ' . $vacation->agent2->prenom : 'N/A' }}</td>
                                    <td>{{ $vacation->start_time }}</td>
                                    <td>{{ $vacation->end_time }}</td>
                                    <td>{{ $vacation->status }}</td>
                                    {{-- <td>{{$vacation->site->name}}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection