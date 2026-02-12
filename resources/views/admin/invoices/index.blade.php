@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Liste des Factures</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Factures</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary"><i class="ri-add-line mr-2"></i> Créer une nouvelle facture</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Liste des Factures</h5>
                    </div>
                    <div class="card-body">
                        <!-- Messages de succès -->
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- Tableau des factures -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Client & Demande</th>
                                        <th>Répartition 50/50 (CFA)</th>
                                        <th>Montant Total</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->id }}</strong></td>
                                        <td>
                                            @if($invoice->demande)
                                                <div class="font-weight-bold">{{ $invoice->demande->client->nom ?? 'Client #' . $invoice->demande->client_id }}</div>
                                                <small class="text-muted">Demande #{{ $invoice->demande_id }} | Site: {{ $invoice->demande->site->name ?? '-' }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-between mb-1" style="min-width: 200px;">
                                                    <span class="small text-muted">Exploitation:</span>
                                                    <span class="badge badge-info">{{ number_format($invoice->total_amount, 0, ',', ' ') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="small text-muted">Trésorerie:</span>
                                                    @php
                                                        $tresorerie = $invoice->demande ? $invoice->demande->montant_tresorerie : $invoice->total_amount;
                                                    @endphp
                                                    <span class="badge badge-secondary">{{ number_format($tresorerie, 0, ',', ' ') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-primary font-weight-bold">
                                                @php
                                                    $total = $invoice->demande ? $invoice->demande->montant_brut : ($invoice->total_amount * 2);
                                                @endphp
                                                {{ number_format($total, 0, ',', ' ') }} CFA
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $invoice->status == 'paid' ? 'success' : 'warning' }} p-2">
                                                <i class="ri-{{ $invoice->status == 'paid' ? 'checkbox-circle' : 'time' }}-line mr-1"></i>
                                                {{ strtoupper($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-info btn-sm" title="Détails"><i class="ri-eye-line"></i></a>
                                                @if($invoice->demande)
                                                <a href="{{ route('admin.demandes.paiement', $invoice->demande_id) }}" class="btn btn-success btn-sm" title="Prix et Salaires"><i class="ri-money-cny-box-line"></i></a>
                                                @endif
                                                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm" title="Modifier"><i class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune facture trouvée</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection