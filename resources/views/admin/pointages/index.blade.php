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
                        <h5 class="card-title">Pointages</h5>
                        {{-- <a href="{{route('vacations.create')}}" class="btn btn-primary"><i class="ri-add-line mr-2"></i> Ajouter</a> --}}
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6>
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom du Site</th>
                                    <th>Vacation</th>
                                    <th>Status</th>
                                    <th>Date de Fin</th>
                                    <td>Action</td>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pointages as $pointage)
                                        <tr>
                                            <td>{{ $pointage->id }}</td>
                                            <td>{{ $pointage->site->name }}</td>
                                            <td>{{ $pointage->vacation->code_vacation }}</td>
                                            <td>{{ $pointage->status }}</td>
                                            <td>{{ $pointage->fin_vacation }}</td>
                                            
                                            
                                            <td class="text-center">
                                                <a href="{{ route('admin.pointages.show', $pointage->id) }}" class="btn btn-info"><i class="ri-eye-line"></i></a>
                                                <a href="{{ route('admin.pointages.edit', $pointage->id) }}" class="btn btn-warning"><i class="ri-edit-line"></i></a>
                                                <form action="{{ route('admin.pointages.destroy', $pointage->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-12 col-lg-12">
                                <div class="widgetbar" style="color: white;">
                                    <a href="{{route('admin.pointages.create')}}" class="btn btn-primary"><i class="ri-bubble-chart-line mr-2"></i> Pointages</a>
                                </div>                        
                            </div>
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

