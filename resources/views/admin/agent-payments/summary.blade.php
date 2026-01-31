@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Résumé des Gains</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.agent-payments.dashboard') }}">Gains</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Résumé</li>
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
            @php
            $totalPending = \App\Models\AgentPayment::where('status', 'pending')->sum('amount');
            $totalPaid = \App\Models\AgentPayment::where('status', 'paid')->sum('amount');
            $totalGains = $totalPending + $totalPaid;
            @endphp

            <div class="col-lg-3 col-md-6 m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total Gains</h6>
                                <h3 class="font-weight-bold">{{ number_format($totalGains, 2) }} FCFA</h3>
                            </div>
                            <i class="ri-money-dollar-box-line ri-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 m-b-30">
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

            <div class="col-lg-3 col-md-6 m-b-30">
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

            <div class="col-lg-3 col-md-6 m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Agents</h6>
                                <h3 class="font-weight-bold">{{ count($agentsSummary) }}</h3>
                            </div>
                            <i class="ri-user-line ri-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Résumé par Agent</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Agent</th>
                                        <th>Email</th>
                                        <th>En attente</th>
                                        <th>Retirés</th>
                                        <th>Total</th>
                                        <th>Pourcentage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agentsSummary as $summary)
                                    @php
                                    $percentage = $totalGains > 0 ? ($summary['total'] / $totalGains) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $summary['agent']->id }}</strong></td>
                                        <td>{{ $summary['agent']->nom }} {{ $summary['agent']->prenom }}</td>
                                        <td>{{ $summary['agent']->email }}</td>
                                        <td>
                                            <span class="badge badge-warning">
                                                {{ number_format($summary['total_pending'], 2) }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ number_format($summary['total_paid'], 2) }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($summary['total'], 2) }} FCFA</strong>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agent-payments.show', $summary['agent']->id) }}" class="btn btn-info btn-sm">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Aucun agent avec des gains</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection