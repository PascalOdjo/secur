@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Liste des Vacations</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liste des Vacations</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">
    @forelse($vacationsList as $item)
    <div class="row m-b-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">
                            Demande #{{ $item['demande']->id }} -
                            <strong>{{ $item['demande']->client ? $item['demande']->client->nom : 'N/A' }}</strong>
                        </h5>
                        <small class="text-muted">
                            Site: {{ $item['demande']->site ? $item['demande']->site->nom : 'N/A' }} |
                            Agents: {{ $item['demande']->nombre_agents }} |
                            Montant Exploitation: <strong>{{ number_format($item['demande']->montant_exploitation, 0, '.', ' ') }} FCFA</strong>
                        </small>
                    </div>
                    <a href="{{ route('vacations-list.show', $item['demande']->id) }}" class="btn btn-sm btn-info">
                        <i class="ri-eye-line mr-2"></i> Détails
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <small>
                            <strong>Montant par vacation:</strong> {{ number_format($item['montant_par_vacation'], 0, '.', ' ') }} FCFA |
                            <strong>Total vacations:</strong> {{ $item['vacations']->count() }}
                            ({{ isset($item['realVacations']) ? $item['realVacations']->count() * count($item['groups']) : 0 }} réel + {{ isset($item['virtualVacations']) ? $item['virtualVacations']->count() * count($item['groups']) : 0 }} virtuel) x 4 groupes (K, L, M, N)
                        </small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th>ID</th>
                                    <th>Code Vacation</th>
                                    <th>Type</th>
                                    <th>Groupe</th>
                                    <th>Sous-groupe</th>
                                    <th>Date Début</th>
                                    <th>Date Fin</th>
                                    <th>Agent 1</th>
                                    <th>Agent 2</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($item['vacations'] as $vacation)
                                <tr>
                                    <td>{{ $vacation->id }}</td>
                                    <td>
                                        <strong>{{ $vacation->generated_code ?? $vacation->code_vacation }}</strong>
                                    </td>
                                    <td>
                                        @if($vacation->vacation_type === 'reel')
                                        <span class="badge badge-success">RÉEL</span>
                                        @else
                                        <span class="badge badge-warning">VIRTUEL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $vacation->group ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $vacation->sub_pair ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ $vacation->start_time ? \Carbon\Carbon::parse($vacation->start_time)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $vacation->end_time ? \Carbon\Carbon::parse($vacation->end_time)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        @if($vacation->agent_id_1)
                                        <small>{{ $vacation->agent1->nom ?? 'N/A' }} {{ $vacation->agent1->prenom ?? '' }}</small>
                                        @else
                                        <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vacation->agent_id_2)
                                        <small>{{ $vacation->agent2->nom ?? 'N/A' }} {{ $vacation->agent2->prenom ?? '' }}</small>
                                        @else
                                        <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($item['montant_par_vacation'], 0, '.', ' ') }} FCFA</strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Aucune vacation trouvée</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <i class="ri-information-line mr-2"></i>
                Aucune demande avec des vacations trouvée.
            </div>
        </div>
        @endforelse
    </div>

    <style>
        .table-sm th,
        .table-sm td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
    @endsection