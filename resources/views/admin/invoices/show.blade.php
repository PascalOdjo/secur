@extends('layouts.app')


@section('content')
<div id="containerbar"> 
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Détails de la Facture #{{ $invoice->id }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Factures</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar" style="color: white;">
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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
                        <h5 class="card-title">Détails de la Facture</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Montant Total :</strong> {{ $invoice->total_amount }} Francs CFA</p>
                        <p><strong>Statut :</strong> {{ ucfirst($invoice->status) }}</p>
                        <p><strong>Date de Création :</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>

                        @if($invoice->vacation)
                            <h6>Vacation Associée :</h6>
                            <p><strong>Description :</strong> {{ $invoice->vacation->description }}</p>
                        @else
                            <p>Aucune vacation associée.</p>
                        @endif

                        <h6>Détails des Agents :</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->agents as $agent)
                                    <tr>
                                        <td>{{ $agent->nom }}</td>
                                        <td>{{ $agent->prenom }}</td>
                                        <td>{{ $agent->contact }}</td>
                                    </tr>
                                @endforeach
                                @if($invoice->agents->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">Aucun agent associé à cette facture.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- End col -->
</div>

@endsection