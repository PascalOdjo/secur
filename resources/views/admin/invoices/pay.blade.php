@extends('layouts.app')

@section('content')

<div id="containerbar"> 
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Paiement de la Facture #{{ $invoice->id }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Paiement</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Facture</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar" style="color: white;">
                    <a href="{{route('admin.invoices.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
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
                        <h5 class="card-title">Détails du Paiement</h5>
                    </div>
                    <div class="card-body">
                        <p>Montant total : {{ $invoice->total_amount }} Francs CFA</p>

                        <form action="{{ route('admin.invoices.processPayment', $invoice->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="payment_method">Méthode de paiement :</label>
                                <select id="payment_method" name="payment_method" class="form-control" required>
                                    <option value="card">Carte Bancaire</option>
                                    <option value="cash">Espèces</option>
                                </select>
                            </div>

                            <div id="card_details" class="payment-details" style="display: none;">
                                <h4>Détails de la carte</h4>
                                <div class="form-group">
                                    <label for="card_number">Numéro de carte :</label>
                                    <input type="text" id="card_number" name="card_number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="expiry_date">Date d'expiration :</label>
                                    <input type="text" id="expiry_date" name="expiry_date" class="form-control" required placeholder="MM/AA">
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV :</label>
                                    <input type="text" id="cvv" name="cvv" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Confirmer le paiement</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- End col -->
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        var cardDetails = document.getElementById('card_details');
        if (this.value === 'card') {
            cardDetails.style.display = 'block';
        } else {
            cardDetails.style.display = 'none';
        }
    });
</script>

@endsection