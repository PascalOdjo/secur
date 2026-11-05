@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gains de {{ $agent->nom }} {{ $agent->prenom }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.agent-payments.dashboard') }}">Gains</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $agent->nom }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.agent-payments.dashboard') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentbar">
        <!-- Cartes de statistiques -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">En attente</h6>
                                <h3 class="font-weight-bold text-warning">{{ number_format($totalPending, 2) }} FCFA</h3>
                            </div>
                            <i class="ri-time-line ri-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Retirés</h6>
                                <h3 class="font-weight-bold text-success">{{ number_format($totalPaid, 2) }} FCFA</h3>
                            </div>
                            <i class="ri-check-double-line ri-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total</h6>
                                <h3 class="font-weight-bold text-primary">{{ number_format($totalPending + $totalPaid, 2) }} FCFA</h3>
                            </div>
                            <i class="ri-money-dollar-box-line ri-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Bouton de retrait -->
        @if($totalPending > 0)
        <div class="row mb-3">
            <div class="col-lg-12">
                <form action="{{ route('admin.agent-payments.withdraw', $agent->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Confirmer le retrait de {{ number_format($totalPending, 2) }} FCFA?')">
                        <i class="ri-download-cloud-line mr-2"></i> Effectuer un retrait
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Paiements par contrat -->
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Paiements Quotidiens</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Contrat</th>
                                        <th>Site</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentsByVacation as $vacationId => $payments)
                                    @php $vacation = $payments->first()->vacation; @endphp
                                    <tr class="table-primary font-weight-bold">
                                        <td colspan="5">
                                            <i class="ri-folder-line"></i>
                                            Contrat #{{ $vacation->demande_id }}
                                            - {{ $vacation->demande->client->nom }}
                                            - {{ $vacation->site->name }}
                                            ({{ $vacation->demande->start_date }} à {{ $vacation->demande->end_date }})
                                        </td>
                                    </tr>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td></td>
                                        <td>{{ $payment->vacation->site->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y') }}</td>
                                        <td><strong>{{ number_format($payment->amount, 2) }} FCFA</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $payment->status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light">
                                        <td colspan="3" class="text-right font-weight-bold">Sous-total Contrat :</td>
                                        <td><strong>{{ number_format($payments->sum('amount'), 2) }} FCFA</strong></td>
                                        <td></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucun paiement</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations de l'agent -->
        <div class="row">
            <div class="col-lg-6 m-b-30">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informations de l'Agent</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Nom :</strong></label>
                            <p>{{ $agent->nom }} {{ $agent->prenom }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>Email :</strong></label>
                            <p>{{ $agent->email }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>Téléphone :</strong></label>
                            <p>{{ $agent->telephone ?? 'N/A' }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>Adresse :</strong></label>
                            <p>{{ $agent->addresse ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 m-b-30">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Résumé des Gains</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Total Gains :</strong></label>
                            <h4 class="text-primary">{{ number_format($totalPending + $totalPaid, 2) }} FCFA</h4>
                        </div>
                        <div class="form-group">
                            <label><strong>En attente :</strong></label>
                            <h5 class="text-warning">{{ number_format($totalPending, 2) }} FCFA</h5>
                        </div>
                        <div class="form-group">
                            <label><strong>Retirés :</strong></label>
                            <h5 class="text-success">{{ number_format($totalPaid, 2) }} FCFA</h5>
                        </div>
                        <div class="form-group">
                            <label><strong>Nombre de jours travaillés :</strong></label>
                            <h5>{{ $paymentsByVacation->flatten()->count() }} jours</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection