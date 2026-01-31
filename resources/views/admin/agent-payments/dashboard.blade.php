@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-4 col-lg-4">
                <h4 class="page-title">Gains des Agents</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gains des Agents</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-8 col-lg-8">
                <div class="widgetbar d-flex justify-content-end">
                    <a href="{{ route('admin.agent-payments.summary') }}" class="btn btn-primary mr-2"><i class="ri-bar-chart-line mr-2"></i> Résumé</a>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary mr-2"><i class="ri-file-text-line mr-2"></i> Factures</a>
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-info mr-2"><i class="ri-user-line mr-2"></i> Agents</a>
                    <a href="{{ route('admin.vacations.index') }}" class="btn btn-dark"><i class="ri-calendar-2-line mr-2"></i> Vacations</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Tableau de bord des gains</h5>
                    </div>
                    <div class="card-body">
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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Paiements en attente</th>
                                        <th>Paiements effectués</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agents as $agent)
                                    @php
                                    $pending = \App\Models\AgentPayment::where('agent_id', $agent->id)
                                    ->where('status', 'pending')
                                    ->sum('amount');
                                    $paid = \App\Models\AgentPayment::where('agent_id', $agent->id)
                                    ->where('status', 'paid')
                                    ->sum('amount');
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $agent->id }}</strong></td>
                                        <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>
                                            <span class="badge badge-warning">
                                                {{ number_format($pending, 2) }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ number_format($paid, 2) }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($pending + $paid, 2) }} FCFA</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.agent-payments.show', $agent->id) }}" class="btn btn-info btn-sm" title="Détails">
                                                <i class="ri-eye-line"></i> Détails
                                            </a>
                                            @if($pending > 0)
                                            <form action="{{ route('admin.agent-payments.withdraw', $agent->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Confirmer le retrait?')">
                                                    <i class="ri-download-cloud-line"></i> Retrait
                                                </button>
                                            </form>
                                            @else
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="ri-check-line"></i> Retiré
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Aucun agent</td>
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