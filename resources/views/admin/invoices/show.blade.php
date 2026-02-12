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

                        @if($invoice->demande)
                            <h6>Client :</h6>
                            <p><strong>Nom :</strong> {{ $invoice->demande->client->nom ?? '-' }} {{ $invoice->demande->client->prenom ?? '' }}</p>
                            <p><strong>Adresse :</strong> {{ $invoice->demande->client->adresse ?? '-' }}</p>
                            <p><strong>Téléphone :</strong> {{ $invoice->demande->client->telephone ?? '-' }}</p>
                        @else
                            <p>Aucun client associé.</p>
                        @endif

                        @if($invoice->vacation)
                            <h6>Vacation Associée :</h6>
                            <p><strong>Description :</strong> {{ $invoice->vacation->description ?? '-' }}</p>
                            <p><strong>Statut :</strong> {{ ucfirst($invoice->vacation->status) }}</p>
                            <p><strong>Heure de Début :</strong> {{ $invoice->vacation->start_time ? $invoice->vacation->start_time->format('d/m/Y H:i:s') : '-' }}</p>
                            <p><strong>Heure de Fin :</strong> {{ $invoice->vacation->end_time ? $invoice->vacation->end_time->format('d/m/Y H:i:s') : '-' }}</p>
                        @endif

                        <h6 class="mt-4">Agents Assignés à cette Demande :</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom & Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice->agents as $agent)
                                    <tr>
                                        <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->telephone }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Aucun agent assigné à cette demande pour le moment.</td>
                                    </tr>
                                @endforelse
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