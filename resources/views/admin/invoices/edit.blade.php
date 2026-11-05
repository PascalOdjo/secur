@extends('layouts.app')

@section('content')

<div id="containerbar"> 
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Modifier la Facture #{{ $invoice->id }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Factures</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier</li>
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
                        <h5 class="card-title">Modifier les Détails de la Facture</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="total_amount">Montant Total :</label>
                                <input type="number" id="total_amount" name="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $invoice->total_amount) }}" required>
                                @error('total_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Statut :</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Payée</option>
                                    <option value="canceled" {{ $invoice->status == 'canceled' ? 'selected' : '' }}>Annulée</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Mettre à jour la Facture</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- End col -->
</div>

@endsection
