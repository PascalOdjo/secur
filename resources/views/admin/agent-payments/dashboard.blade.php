@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-6">
                <h4 class="page-title">Gestion Financière des Agents</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gains & Paiements</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="widgetbar text-right">
                    <a href="{{ route('admin.agent-payments.summary') }}" class="btn btn-outline-primary mr-2 shadow-sm"><i class="ri-bar-chart-2-line mr-2"></i>Analytique</a>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary shadow-sm"><i class="ri-file-list-3-line mr-2"></i>Factures</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentbar">
        {{-- SECTION 1 : WIDGETS DE SYNTHÈSE --}}
        <div class="row">
            @php
                $totalPendingPayroll = \App\Models\AgentPayment::where('status', 'pending')->sum('amount');
                $totalPaidPayroll = \App\Models\AgentPayment::where('status', 'paid')->sum('amount');
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="card m-b-30 shadow-sm border-0 bg-primary-gradient">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-white-50 text-uppercase mb-2 font-12">Masse Salariale Totale</h6>
                                <h3 class="mb-0 font-weight-bold">{{ number_format($totalPendingPayroll + $totalPaidPayroll, 0, ',', ' ') }}</h3>
                                <p class="mb-0 text-white-50 mt-1">Francs CFA</p>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ri-money-dollar-circle-line ri-4x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card m-b-30 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted text-uppercase mb-2 font-12">Reste à Payer (Pending)</h6>
                                <h3 class="mb-0 font-weight-bold text-warning">{{ number_format($totalPendingPayroll, 0, ',', ' ') }}</h3>
                                <p class="mb-0 text-muted mt-1">Attente de retrait</p>
                            </div>
                            <div class="col-4 text-right">
                                <div class="bg-warning-rgba p-3 rounded-circle d-inline-block">
                                    <i class="ri-time-line ri-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card m-b-30 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted text-uppercase mb-2 font-12">Salaires Versés (Paid)</h6>
                                <h3 class="mb-0 font-weight-bold text-success">{{ number_format($totalPaidPayroll, 0, ',', ' ') }}</h3>
                                <p class="mb-0 text-muted mt-1">Confirmés</p>
                            </div>
                            <div class="col-4 text-right">
                                <div class="bg-success-rgba p-3 rounded-circle d-inline-block">
                                    <i class="ri-checkbox-circle-line ri-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('_message')

        <div class="row">
            {{-- SECTION 2 : TABLEAU DE BORD PRINCIPAL (AGENTS) --}}
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-dark mb-0"><i class="ri-user-star-line mr-2 text-primary"></i>Liste des Gains par Agent</h5>
                        <span class="badge badge-primary-rgba text-primary">{{ $agents->count() }} Agents actifs</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">#ID</th>
                                        <th class="border-0">Agent</th>
                                        <th class="border-0">En Attente</th>
                                        <th class="border-0">Déjà Payé</th>
                                        <th class="border-0">Total Gain</th>
                                        <th class="border-0 text-center">Status Retrait</th>
                                        <th class="border-0 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agents as $agent)
                                    @php
                                        $pending = \App\Models\AgentPayment::where('agent_id', $agent->id)->where('status', 'pending')->sum('amount');
                                        $paid = \App\Models\AgentPayment::where('agent_id', $agent->id)->where('status', 'paid')->sum('amount');
                                    @endphp
                                    <tr>
                                        <td><span class="text-muted font-12">#{{ $agent->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info-rgba mr-2 rounded-circle text-center d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                                                    <span class="text-info font-weight-bold">{{ strtoupper(substr($agent->nom, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold text-dark">{{ $agent->nom }} {{ $agent->prenom }}</div>
                                                    <small class="text-muted">{{ $agent->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-warning font-weight-bold">{{ number_format($pending, 0, ',', ' ') }} CFA</span></td>
                                        <td><span class="text-success font-weight-bold">{{ number_format($paid, 0, ',', ' ') }} CFA</span></td>
                                        <td><span class="text-primary font-weight-bold">{{ number_format($pending + $paid, 0, ',', ' ') }} CFA</span></td>
                                        <td class="text-center">
                                            @if($pending > 0)
                                                <span class="badge badge-pill badge-warning-rgba text-warning p-2" style="font-size: 10px;">ACTION REQUISE</span>
                                            @else
                                                <span class="badge badge-pill badge-success-rgba text-success p-2" style="font-size: 10px;">À JOUR</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.agent-payments.show', $agent->id) }}" class="btn btn-sm btn-outline-info" title="Historique complet">
                                                    <i class="ri-history-line"></i>
                                                </a>
                                                @if($pending > 0)
                                                <form action="{{ route('admin.agent-payments.withdraw', $agent->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success ml-1 shadow-sm" onclick="return confirm('Procéder au paiement de tous les gains en attente pour cet agent ?')">
                                                        <i class="ri-hand-coin-line mr-1"></i> Payer
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">Aucun agent enregistré ou aucun gain trouvé.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3 : DÉTAILS ANALYTIQUES PAR DEMANDE (ACCORDIONS) --}}
            <div class="col-lg-12">
                <div class="section-title mb-3 mt-2">
                    <h5 class="mb-0">Détails de Rémunération par Demande</h5>
                    <p class="text-muted small">Analyse pointue du salaire net par contrat et type de vacation.</p>
                </div>

                <div class="accordion shadow-sm" id="agentDetailsAccordion">
                    @foreach($agents as $agent)
                        @if($agent->demandes && $agent->demandes->isNotEmpty())
                        <div class="card m-b-10 border-0 overflow-hidden">
                            <div class="card-header bg-white border-0 py-1" id="heading{{ $agent->id }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-left d-flex justify-content-between align-items-center py-3 px-4 collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $agent->id }}" aria-expanded="false" aria-controls="collapse{{ $agent->id }}" style="background: none; border: none;">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-user-location-line mr-2 text-primary"></i>
                                            <span class="font-weight-bold text-dark">{{ $agent->nom }} {{ $agent->prenom }}</span>
                                            <span class="badge badge-light ml-2">{{ $agent->demandes->count() }} demande(s)</span>
                                        </div>
                                        <i class="ri-arrow-down-s-line accordion-arrow"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $agent->id }}" class="collapse" aria-labelledby="heading{{ $agent->id }}" data-parent="#agentDetailsAccordion">
                                <div class="card-body bg-light-rgba p-4">
                                    <div class="row">
                                        @foreach($agent->demandes as $demande)
                                        <div class="col-xl-6 m-b-20">
                                            <div class="card border-0 shadow-sm h-100">
                                                <div class="card-header bg-white px-3 py-2 d-flex justify-content-between align-items-center">
                                                    <div class="small font-weight-bold text-info">DEMANDE #{{ $demande->id }}</div>
                                                    <a href="{{ route('admin.demandes.paiement', $demande->id) }}" class="btn btn-xs btn-link p-0 text-muted">Fiche Financière <i class="ri-external-link-line"></i></a>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="text-muted small"><i class="ri-map-pin-line mr-1"></i>{{ $demande->site->name ?? 'N/A' }}</div>
                                                        <div class="badge badge-success-rgba text-success">Salaire Fixe: {{ number_format($demande->salaire_par_agent, 0, ',', ' ') }} CFA</div>
                                                    </div>
                                                    
                                                    <div class="row no-gutters mb-0">
                                                        <div class="col-3 border-right p-2 text-center">
                                                            <div class="text-muted" style="font-size: 9px; text-transform: uppercase;">Groupe A</div>
                                                            <div class="font-weight-bold text-primary font-12">{{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }}</div>
                                                            <div class="text-muted smaller" style="font-size: 8px;">(Réelles)</div>
                                                        </div>
                                                        <div class="col-3 border-right p-2 text-center">
                                                            <div class="text-muted" style="font-size: 9px; text-transform: uppercase;">Groupe B</div>
                                                            <div class="font-weight-bold text-dark font-12">{{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }}</div>
                                                            <div class="text-muted smaller" style="font-size: 8px;">(Virtuelles)</div>
                                                        </div>
                                                        <div class="col-3 border-right p-2 text-center">
                                                            <div class="text-muted" style="font-size: 9px; text-transform: uppercase;">Groupe C</div>
                                                            <div class="font-weight-bold text-dark font-12">{{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }}</div>
                                                            <div class="text-muted smaller" style="font-size: 8px;">(Virtuelles)</div>
                                                        </div>
                                                        <div class="col-3 p-2 text-center">
                                                            <div class="text-muted" style="font-size: 9px; text-transform: uppercase;">Groupe D</div>
                                                            <div class="font-weight-bold text-dark font-12">{{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }}</div>
                                                            <div class="text-muted smaller" style="font-size: 8px;">(Virtuelles)</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-center">
                                                        <small class="text-muted">Valeur unitaire/vacation : <strong>{{ number_format($demande->montant_par_vacation ?? 0, 2, ',', ' ') }} CFA</strong></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-gradient {
        background: linear-gradient(135deg, #4c66fb 0%, #68e1fd 100%);
    }
    .bg-warning-rgba { background-color: rgba(255, 184, 34, 0.1); }
    .bg-success-rgba { background-color: rgba(0, 191, 191, 0.1); }
    .bg-info-rgba { background-color: rgba(68, 184, 255, 0.1); }
    .bg-primary-rgba { background-color: rgba(76, 102, 251, 0.1); }
    .bg-light-rgba { background-color: rgba(246, 249, 252, 1); }
    
    .card { border-radius: 12px; transition: transform 0.2s ease; }
    .section-title h5 { font-weight: 700; color: #3d4d5d; }
    
    .accordion .card-header .btn { 
        text-decoration: none; 
        transition: all 0.3s ease;
    }
    .accordion .card-header .btn:not(.collapsed) {
        background-color: #f8f9fa;
        border-left: 4px solid #4c66fb;
    }
    .accordion-arrow {
        transition: transform 0.3s ease;
    }
    .btn:not(.collapsed) .accordion-arrow {
        transform: rotate(180deg);
    }
    
    .table thead th { 
        text-transform: uppercase; 
        letter-spacing: 0.5px; 
        font-size: 11px; 
        color: #8a98ac;
    }
    .font-12 { font-size: 12px; }
    
    .btn-xs { padding: 0.1rem 0.4rem; font-size: 0.75rem; }
    
    @media print {
        .widgetbar, .btn-group, .breadcrumbbar { display: none !important; }
    }
</style>
@endsection