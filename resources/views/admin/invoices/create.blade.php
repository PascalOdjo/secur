@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Création d'une Facture</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajouter une facture</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary"><i class="ri-todo-line mr-2"></i> Factures</a>
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
                        <h5 class="card-title text-center font-25">Formulaire de Création d'une Facture</h5>
                    </div>
                    <div class="card-body">
                        @if($demande)
                            <p>Description: {{ $demande->description }}</p>
                        @else
                            <p>Aucune demande sélectionnée.</p>
                        @endif

                        <form action="{{ route('admin.invoices.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="demande_id">Demande</label>
                                <select name="demande_id" id="demande_id" class="form-control" required>
                                    <option value="">-- Sélectionner une demande --</option>
                                    @foreach($demandes as $demande)
                                    <option value="{{ $demande->id }}">Demande #{{ $demande->id }} - Client : {{ $demande->client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="total_amount">Montant total</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control" required>
                            </div>
                        
                            <!-- Autres champs pour la facture -->
                        
                            <button type="submit" class="btn btn-primary">Créer la facture</button>
                        </form>
                        
                        
                    </div>
                </div>

                <script>
                    function calculatePayments() {
                        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
                        document.getElementById('agent_payment').value = (totalAmount / 4).toFixed(2);
                        document.getElementById('agency_payment').value = (totalAmount * 3 / 4).toFixed(2);
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
