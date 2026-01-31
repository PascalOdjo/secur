@extends('layouts.app')

{{-- @var \App\Models\Demande $demande --}}
{{-- @var \Illuminate\Support\Collection $contracts --}}
{{-- @var float $montantParVacation --}}

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Détail des Vacations</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vacations-list.index') }}">Liste des Vacations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Demande #{{ $demande->id }}</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('vacations-list.index') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">
    <div class="row">
        <!-- Demande Info Card -->
        <div class="col-lg-12 m-b-30">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Informations de la Demande</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Demande ID:</strong> {{ $demande->id }}</p>
                            <p><strong>Client:</strong> {{ $demande->client ? $demande->client->nom : 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Site:</strong> {{ $demande->site ? $demande->site->nom : 'N/A' }}</p>
                            <p><strong>Nombre d'Agents:</strong> {{ $demande->nombre_agents }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Montant Brut:</strong> {{ number_format($demande->montant_brut, 0, '.', ' ') }} FCFA</p>
                            <p><strong>Montant Exploitation:</strong> {{ number_format($demande->montant_exploitation, 0, '.', ' ') }} FCFA</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Montant Trésorerie:</strong> {{ number_format($demande->montant_tresorerie, 0, '.', ' ') }} FCFA</p>
                            <p><strong>Montant par Vacation:</strong> <strong>{{ number_format($montantParVacation, 0, '.', ' ') }} FCFA</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Vacations Combined -->
        <div class="col-lg-12 m-b-30">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="badge badge-info">TOUS LES CONTRATS</span>
                        Tous les Contrats ({{ $contracts->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($contracts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code Contrat</th>
                                    <th>Groupe</th>
                                    <th>Sous-groupe</th>
                                    <th>Type</th>
                                    <th>Date Début</th>
                                    <th>Date Fin</th>
                                    <th>Agent 1</th>
                                    <th>Agent 2</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @var array $contract --}}
                                @foreach($contracts as $contract)
                                <tr @if(!$contract['has_vacation']) style="background-color: #f5f5f5; opacity: 0.7;" @endif>
                                    <td>{{ $contract['index'] + 1 }}</td>
                                    <td>
                                        <strong>{{ $contract['code'] }}</strong>
                                        @if(!$contract['has_vacation'])
                                        <br><small class="text-muted">(Aucune vacation)</small>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-primary">{{ $contract['group'] }}</span></td>
                                    <td><span class="badge badge-info">{{ $contract['sub_pair'] }}</span></td>
                                    <td>
                                        @if($contract['is_real'])
                                        <span class="badge badge-success">RÉEL</span>
                                        @else
                                        <span class="badge badge-warning">VIRTUEL</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract['has_vacation'] && $contract['vacation']['start_time'])
                                        {{ \Carbon\Carbon::parse($contract['vacation']['start_time'])->format('d/m/Y') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract['has_vacation'] && $contract['vacation']['end_time'])
                                        {{ \Carbon\Carbon::parse($contract['vacation']['end_time'])->format('d/m/Y') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract['has_vacation'] && $contract['vacation']['agent_1_id'])
                                        {{ $contract['vacation']['agent1']['nom'] ?? 'N/A' }} {{ $contract['vacation']['agent1']['prenom'] ?? '' }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract['has_vacation'] && $contract['vacation']['agent_2_id'])
                                        {{ $contract['vacation']['agent2']['nom'] ?? 'N/A' }} {{ $contract['vacation']['agent2']['prenom'] ?? '' }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td><strong>{{ number_format($montantParVacation, 0, '.', ' ') }} FCFA</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #f8f9fa;">
                                    <td colspan="9" class="text-right"><strong>Total ({{ $contracts->count() }} contrats):</strong></td>
                                    <td><strong>{{ number_format($contracts->count() * $montantParVacation, 0, '.', ' ') }} FCFA</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <p class="text-muted">Aucune vacation trouvée.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-12 m-b-30">
            <div class="card m-b-30" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h6>Contrats Réels</h6>
                            <h3>{{ $contracts->where('is_real', true)->count() }} × {{ number_format($montantParVacation, 0, '.', ' ') }} FCFA</h3>
                            <p>= {{ number_format($contracts->where('is_real', true)->count() * $montantParVacation, 0, '.', ' ') }} FCFA</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Contrats Virtuels</h6>
                            <h3>{{ $contracts->where('is_real', false)->count() }} × {{ number_format($montantParVacation, 0, '.', ' ') }} FCFA</h3>
                            <p>= {{ number_format($contracts->where('is_real', false)->count() * $montantParVacation, 0, '.', ' ') }} FCFA</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Groupes (K,L,M,N)</h6>
                            <h3>{{ $contracts->groupBy('group')->count() }}/4</h3>
                            <p>Groupes actifs</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Total Montant Exploitation</h6>
                            <h3>{{ number_format($demande->montant_exploitation, 0, '.', ' ') }} FCFA</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection