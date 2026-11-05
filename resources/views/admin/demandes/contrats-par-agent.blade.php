@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Contrats par agent</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.demandes.index') }}">Demandes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contrats (64 par agent)</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.demandes.show', $demande->id) }}" class="btn btn-primary">
                        <i class="ri-arrow-left-line mr-2"></i> Retour à la demande
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">
    {{-- Simple référence à la demande --}}
    <div class="row mb-3">
        <div class="col-12">
            <h5>
                Demande #{{ $demande->id }}
                @if($demande->client)
                    — {{ $demande->client->nom }}
                @endif
                ({{ $total_contracts }} contrats au total)
            </h5>
        </div>
    </div>

    {{-- Pour chaque agent : 64 contrats --}}
    @foreach($agents_contracts as $block)
    @php $agent = $block['agent']; @endphp
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Agent : {{ $agent->prenom }} {{ $agent->nom }}
                        <span class="badge bg-secondary ms-2">ID {{ $agent->id }}</span>
                    </h5>
                    <span class="badge bg-success">{{ $block['real_count'] }} réels</span>
                    <span class="badge bg-warning text-dark">{{ $block['virtual_count'] }} virtuels</span>
                    <span class="badge bg-primary">{{ $block['total'] }} total</span>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Les <strong>16 contrats réels</strong> ont une vacation attribuée. Les <strong>48 contrats virtuels</strong> (3 × 16) n'ont pas de vacation.
                        Ces 64 contrats × {{ count($agents_contracts) }} agents = <strong>{{ $total_contracts }}</strong> = valeur en exploitation (256 pour 4 agents).
                    </p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Groupe</th>
                                    <th>Sous-paire</th>
                                    <th>Type</th>
                                    <th>Code</th>
                                    <th>Vacation (réels uniquement)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($block['contracts'] as $c)
                                <tr class="{{ $c['is_real'] ? 'table-success' : '' }}">
                                    <td>{{ $c['index'] }}</td>
                                    <td><span class="badge bg-primary">{{ $c['group'] }}</span></td>
                                    <td><span class="badge bg-info">{{ $c['sub_pair'] }}</span></td>
                                    <td>
                                        @if($c['is_real'])
                                        <span class="badge bg-success">RÉEL</span>
                                        @else
                                        <span class="badge bg-secondary">VIRTUEL</span>
                                        @endif
                                    </td>
                                    <td><code>{{ $c['code'] }}</code></td>
                                    <td>
                                        @if($c['vacation'])
                                        <small>
                                            {{ $c['vacation']['code_vacation'] ?? '-' }}
                                            @if(!empty($c['vacation']['shift']))
                                            ({{ $c['vacation']['shift'] }})
                                            @endif
                                            @if(!empty($c['vacation']['start_time']))
                                            <br>{{ \Carbon\Carbon::parse($c['vacation']['start_time'])->format('d/m/Y') }}
                                            @endif
                                        </small>
                                        @else
                                        <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if(empty($agents_contracts))
    <div class="alert alert-info">
        Aucun agent associé à cette demande pour le moment. Les agents sont déduits des vacations de la demande.
        Créez ou affectez des vacations pour voir les contrats par agent.
    </div>
    @endif
</div>
@endsection
