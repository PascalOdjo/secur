@extends('layouts.app')

@section('content')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Tableau de Bord</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tableau de Bord</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="{{ route('admin.demandes.create') }}" class="btn btn-primary"><i class="ri-add-line mr-2"></i>Nouvelle Demande</a>
            </div>
        </div>
    </div>

    <div class="contentbar">
        <!-- KPI Cards Row 1 -->
        <div class="row">
            <!-- Total Agents -->
            <div class="col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Nombre d'Agents</p>
                                <h4 class="card-title mb-0">{{ $totalAgents }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Demandes -->
            <div class="col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Nombre de Demandes</p>
                                <h4 class="card-title mb-0">{{ $totalDemandes }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-success text-white rounded"><i class="ri-file-list-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Vacations -->
            <div class="col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Total Vacations</p>
                                <h4 class="card-title mb-0">{{ $totalVacations }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-info text-white rounded"><i class="ri-calendar-2-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Contrats -->
            <div class="col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Total Contrats</p>
                                <h4 class="card-title mb-0">{{ $totalContrats }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-secondary text-white rounded"><i class="ri-file-contract-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Paiements (FCFA) -->
            <div class="col-lg-6 col-xl-4">
                <div class="card m-b-30" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Total Paiements</p>
                                <h3 class="card-title mb-0">{{ number_format($totalPayments, 0, ',', ' ') }} FCFA</h3>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-white text-primary rounded"><i class="ri-money-dollar-box-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards Row 2 -->
        <div class="row">
            <!-- Paiements en Attente -->
            <div class="col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15 text-warning">Paiements en Attente</p>
                                <h3 class="card-title mb-0 text-warning">{{ number_format($totalPending, 0, ',', ' ') }} FCFA</h3>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-warning text-white rounded"><i class="ri-time-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paiements Effectués -->
            <div class="col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15 text-success">Paiements Effectués</p>
                                <h3 class="card-title mb-0 text-success">{{ number_format($totalPaid, 0, ',', ' ') }} FCFA</h3>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-success text-white rounded"><i class="ri-check-double-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Agents with Pending Payments -->
            <div class="col-lg-12 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0"><i class="ri-user-warning-line mr-2"></i>Agents en Attente de Paiement</h5>
                            </div>
                            <div class="col-3">
                                <a href="{{ route('admin.agent-payments.dashboard') }}" class="btn btn-outline-primary btn-sm float-right font-12">Voir Tout</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($agentsWithPending->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Montant Attente</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agentsWithPending as $agent)
                                    <tr>
                                        <td>
                                            <strong>{{ $agent->nom }} {{ $agent->prenom }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $agent->id }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">
                                                {{ number_format($agent->agentPayments->sum('amount'), 0, ',', ' ') }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agent-payments.show', $agent->id) }}" class="btn btn-info btn-sm" title="Détails">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center mb-0">Aucun agent en attente de paiement</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Demands Workflow -->
            <div class="col-lg-12 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0"><i class="ri-file-list-line mr-2"></i>Demandes Récentes (Workflow)</h5>
                            </div>
                            <div class="col-3">
                                <a href="{{ route('admin.demandes.index') }}" class="btn btn-outline-primary btn-sm float-right font-12">Voir Tout</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentDemandes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Demande</th>
                                        <th>Client</th>
                                        <th>Vacations</th>
                                        <th>Agents</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDemandes as $item)
                                    @php $demande = $item['demande']; @endphp
                                    <tr>
                                        <td>
                                            <strong>#{{ $demande->id }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $demande->site ? $demande->site->nom : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $demande->client ? $demande->client->nom : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $item['total_vacations'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item['agents_assigned'] > 0)
                                            <span class="badge badge-success">
                                                {{ $item['agents_assigned'] }}
                                            </span>
                                            @else
                                            <span class="badge badge-warning">
                                                0
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ number_format($demande->montant_brut ?? 0, 0, ',', ' ') }} CFA</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center mb-0">Aucune demande récente</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-links-line mr-2"></i>Accès Rapide</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.demandes.index') }}" class="card text-center p-3 text-decoration-none" style="border: 2px solid #007bff;">
                                    <i class="ri-file-list-line ri-2x text-primary mb-2"></i>
                                    <h6 class="text-primary">Demandes</h6>
                                    <small class="text-muted">{{ $totalDemandes }} entrée(s)</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.agent-payments.dashboard') }}" class="card text-center p-3 text-decoration-none" style="border: 2px solid #28a745;">
                                    <i class="ri-money-dollar-box-line ri-2x text-success mb-2"></i>
                                    <h6 class="text-success">Paiements Agents</h6>
                                    <small class="text-muted">Dashboard</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('vacations-list.index') }}" class="card text-center p-3 text-decoration-none" style="border: 2px solid #17a2b8;">
                                    <i class="ri-calendar-2-line ri-2x text-info mb-2"></i>
                                    <h6 class="text-info">Vacations</h6>
                                    <small class="text-muted">{{ $totalVacations }} vacation(s)</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.agents.index') }}" class="card text-center p-3 text-decoration-none" style="border: 2px solid #6c757d;">
                                    <i class="ri-user-3-line ri-2x text-secondary mb-2"></i>
                                    <h6 class="text-secondary">Agents</h6>
                                    <small class="text-muted">{{ $totalAgents }} agent(s)</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection