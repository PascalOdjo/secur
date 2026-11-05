@extends('layouts.app')

@section('content')

<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Détails Financiers : Prix & Salaires</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.demandes.index') }}">Demandes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Prix et Salaires</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 text-right">
                <a href="{{ route('admin.demandes.index') }}" class="btn btn-outline-primary">
                    <i class="ri-arrow-left-line mr-2"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="contentbar">
        <div class="row">
            {{-- Résumé de la demande --}}
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <div class="d-flex align-items-center">
                            @if($demande->client && $demande->client->passport_photo)
                                <img src="{{ asset($demande->client->passport_photo) }}" alt="Photo" width="60" class="rounded-circle mr-3">
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $demande->client->nom }} {{ $demande->client->prenom }}</h5>
                                <p class="text-muted mb-0">Demande #{{ $demande->id }} | Site : {{ $demande->site->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 1 : LES PRIX (Client & Entreprise) --}}
            <div class="col-lg-6">
                <div class="card m-b-30 border-primary">
                    <div class="card-header bg-primary py-3">
                        <h5 class="card-title text-white mb-0"><i class="ri-money-dollar-box-line mr-2"></i> Structure des Prix (Contrat)</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4 p-3 bg-light rounded">
                            <h6 class="text-uppercase text-muted small mb-1">Montant Brut Total Client</h6>
                            <h2 class="text-primary font-weight-bold mb-0">{{ number_format($demande->montant_brut, 0, ',', ' ') }} FCFA</h2>
                            <p class="small text-muted mb-0">{{ $demande->nombre_agents }} agents × {{ number_format($demande->montant_par_agent, 0, ',', ' ') }} FCFA</p>
                        </div>

                        <div class="row text-center mt-4">
                            <div class="col-6 border-right">
                                <h6 class="text-info small text-uppercase">Exploitation (50%)</h6>
                                <h4 class="mb-0 font-weight-bold">{{ number_format($demande->montant_exploitation, 0, ',', ' ') }}</h4>
                                <small class="text-muted">CFA</small>
                            </div>
                            <div class="col-6">
                                <h6 class="text-info small text-uppercase">Trésorerie (50%)</h6>
                                <h4 class="mb-0 font-weight-bold">{{ number_format($demande->montant_tresorerie, 0, ',', ' ') }}</h4>
                                <small class="text-muted">CFA</small>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Montant par agent (Contrat) :</span>
                                <span class="font-weight-bold">{{ number_format($demande->montant_par_agent, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Nombre de vacations totales :</span>
                                <span class="badge badge-primary">{{ $demande->nombre_agents * 64 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center py-2">
                        <small class="text-muted"><i class="ri-information-line"></i> Ce prix représente ce que le client paie à l'entreprise.</small>
                    </div>
                </div>
            </div>

            {{-- SECTION 2 : LES SALAIRES (Agents) --}}
            <div class="col-lg-6">
                <div class="card m-b-30 border-success">
                    <div class="card-header bg-success py-3">
                        <h5 class="card-title text-white mb-0"><i class="ri-user-smile-line mr-2"></i> Rémunération des Agents</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4 p-3 bg-light rounded" style="border-left: 4px solid #28a745;">
                            <h6 class="text-uppercase text-muted small mb-1">Salaire Net par Agent</h6>
                            <h2 class="text-success font-weight-bold mb-0">{{ number_format($demande->salaire_par_agent, 0, ',', ' ') }} FCFA</h2>
                            <p class="small text-muted mb-0">Formule : Montant par agent / 2</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small mb-3">Breakdown par Vacation (64 au total)</h6>
                            <div class="row no-gutters text-center border rounded overflow-hidden">
                                <div class="col-3 py-3 bg-white">
                                    <div class="badge badge-success mb-1">A (16)</div>
                                    <div class="font-weight-bold small">{{ number_format($demande->montant_par_vacation, 2, ',', ' ') }}</div>
                                    <div class="text-muted smaller" style="font-size: 10px;">Réelle</div>
                                </div>
                                <div class="col-3 py-3 bg-light border-left">
                                    <div class="badge badge-secondary mb-1">B (16)</div>
                                    <div class="font-weight-bold small">{{ number_format($demande->montant_par_vacation, 2, ',', ' ') }}</div>
                                    <div class="text-muted smaller" style="font-size: 10px;">Virtuelle</div>
                                </div>
                                <div class="col-3 py-3 bg-white border-left">
                                    <div class="badge badge-secondary mb-1">C (16)</div>
                                    <div class="font-weight-bold small">{{ number_format($demande->montant_par_vacation, 2, ',', ' ') }}</div>
                                    <div class="text-muted smaller" style="font-size: 10px;">Virtuelle</div>
                                </div>
                                <div class="col-3 py-3 bg-light border-left">
                                    <div class="badge badge-secondary mb-1">D (16)</div>
                                    <div class="font-weight-bold small">{{ number_format($demande->montant_par_vacation, 2, ',', ' ') }}</div>
                                    <div class="text-muted smaller" style="font-size: 10px;">Virtuelle</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted text-uppercase small mb-3">Agents Assignés & Rémunération</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th>Agent</th>
                                            <th class="text-right">Salaire Prévu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($agents as $agent)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-success rounded-circle mr-2" style="width: 8px; height: 8px;"></div>
                                                        <span class="small font-weight-bold">{{ $agent->nom }} {{ $agent->prenom }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-right font-weight-bold small">{{ number_format($demande->salaire_par_agent, 0, ',', ' ') }} CFA</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-2 smaller text-muted italic">Aucun agent assigné pour le moment</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-2 pt-3 border-top">
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span class="font-weight-bold">Total reversement Agents :</span>
                                <span class="font-weight-bold">{{ number_format($demande->salaire_par_agent * $agents->count(), 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center py-2">
                        <small class="text-muted"><i class="ri-information-line"></i> Les agents sont payés sur la base de 64 vacations par agent.</small>
                    </div>
                </div>
            </div>

            {{-- SECTION 3 : DÉDOUANEMENT / NOTES --}}
            <div class="col-lg-12">
                <div class="card m-b-30 bg-info-gradient">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-white mb-1"><i class="ri-shield-check-line mr-2"></i> Validation du Système Financier</h5>
                                <p class="text-white-50 mb-0">Ce calcul suit la politique mise en place en Février 2025. La répartition 50/50 assure l'équilibre entre l'exploitation et la trésorerie de l'entreprise tout en garantissant un salaire fixe aux agents.</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <button onclick="window.print()" class="btn btn-light shadow-sm">
                                    <i class="ri-printer-line mr-2"></i> Imprimer le récapitulatif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-info-gradient {
        background: linear-gradient(45deg, #2d3436 0%, #0984e3 100%);
        border: none;
    }
    .smaller {
        font-size: 11px;
    }
    @media print {
        .btn, .breadcrumbbar, .card-footer {
            display: none !important;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>

@endsection
