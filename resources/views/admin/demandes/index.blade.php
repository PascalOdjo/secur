@extends('layouts.app')

@section('content')

<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Gestion des Demandes & Contrats</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Demandes & Contrats</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar" style="color: white;">
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbbar -->
    <div class="contentbar">
        {{-- Recherche --}}
        <div class="row mb-3">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('admin.demandes.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom, prénom, email ou contact" value="{{ request()->get('search') }}">
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        @include('_message')
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif

        @if($demandes->isEmpty())
            <div class="alert alert-info text-center">
                Aucune demande n'a été trouvée !
            </div>
        @else
            @foreach ($demandes as $demande)
            <div class="card m-b-30">
                {{-- En-tête : infos de base de la demande --}}
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                        {{-- Photo client --}}
                        @if($demande->client && $demande->client->passport_photo)
                            <img src="{{ asset($demande->client->passport_photo) }}" alt="Photo" width="45" height="45" style="border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width:45px;height:45px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;">
                                <i class="ri-user-line" style="font-size:20px;color:#999;"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-0">
                                {{ $demande->client->nom ?? '-' }} {{ $demande->client->prenom ?? '' }}
                                <span class="badge badge-{{ $demande->status == 'validée' ? 'success' : ($demande->status == 'en_attente' ? 'warning' : 'secondary') }} ml-2">{{ $demande->status }}</span>
                            </h5>
                            <small class="text-muted">
                                <i class="ri-mail-line"></i> {{ $demande->client->email ?? '-' }}
                                &nbsp;|&nbsp;
                                <i class="ri-phone-line"></i> {{ $demande->client->telephone ?? '-' }}
                                &nbsp;|&nbsp;
                                <i class="ri-map-pin-line"></i> {{ $demande->client->adresse ?? '-' }}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <span class="badge badge-primary" title="Montant">
                            <i class="ri-money-dollar-circle-line"></i> {{ number_format($demande->montant ?? 0, 0, ',', ' ') }} FCFA
                        </span>
                        <span class="badge badge-info" title="Site">
                            <i class="ri-building-2-line"></i> {{ $demande->site->name ?? '-' }}
                        </span>
                        <span class="badge badge-dark" title="Agents demandés">
                            <i class="ri-team-line"></i> {{ $demande->nombre_agents ?? '-' }} agents
                        </span>
                        <span class="badge badge-secondary" title="Type vacation">
                            {{ $demande->type_vacation ?? '-' }}
                        </span>
                    </div>
                    <div class="d-flex" style="gap: 5px;">
                        <a href="{{ route('admin.demandes.paiement', $demande->id) }}" class="btn btn-sm btn-success" title="Prix et Salaires">
                            <i class="ri-money-cny-box-line"></i>
                        </a>
                        <a href="{{ route('admin.demandes.show', $demande->id) }}" class="btn btn-sm btn-info" title="Voir détails">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="{{ route('admin.demandes.edit', $demande->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('admin.demandes.destroy', $demande->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Corps : liste des contrats --}}
                <div class="card-body p-0">
                    @php
                        $contrats = $demande->contrats;
                        $contratsAssignes = $contrats->whereNotNull('agent_id')->groupBy('agent_id');
                        $contratsNonAssignes = $contrats->whereNull('agent_id');
                        $numAgentsExpected = $demande->nombre_agents ?: 4;
                        $numAgentsAssignes = $contratsAssignes->count();
                        $numSlotsRestants = $numAgentsExpected - $numAgentsAssignes;
                    @endphp

                    @if($contrats->count() > 0)
                        <div class="px-3 pt-3 pb-1">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">
                                    <i class="ri-file-list-3-line"></i> Contrats
                                    <span class="badge badge-primary">{{ $contrats->count() }} contrat(s) au total</span>
                                </h6>
                            </div>
                        </div>

                        {{-- 1. Affichage des agents déjà assignés --}}
                        @foreach($contratsAssignes as $agentId => $agentContrats)
                            @php
                                $agent = $agentContrats->first()->agent;
                                $reels = $agentContrats->where('is_real', true)->count();
                                $virtuels = $agentContrats->where('is_real', false)->count();
                                $shiftType = $agentContrats->first()->type ?? 'JOUR';
                            @endphp
                            <div class="px-3 pb-2 border-bottom mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <strong>
                                            <i class="ri-user-star-line text-success"></i>
                                            {{ $agent ? $agent->prenom . ' ' . $agent->nom : 'Agent #' . $agentId }}
                                        </strong>
                                        <span class="badge badge-{{ $shiftType == 'NUIT' ? 'dark' : 'info' }} ml-2">
                                            <i class="ri-{{ $shiftType == 'NUIT' ? 'moon-clear' : 'sun' }}-line"></i> {{ $shiftType }}
                                        </span>
                                        <span class="badge badge-success ml-1">{{ $reels }} réel(s)</span>
                                        <span class="badge badge-warning text-dark ml-1">{{ $virtuels }} virtuel(s)</span>
                                    </div>
                                    <a href="{{ route('admin.demandes.contrats-par-agent', $demande) }}" class="btn btn-xs btn-outline-secondary">Détails</a>
                                </div>
                            </div>
                        @endforeach

                        {{-- 2. Affichage des slots d'attribution manuelle --}}
                        @for($s = 0; $s < $numSlotsRestants; $s++)
                            <div class="px-3 py-3 mb-3 bg-light border-top border-bottom">
                                <h6 class="text-primary mb-3">
                                    <i class="ri-user-add-line"></i> Attribution manuelle — Agent #{{ $numAgentsAssignes + $s + 1 }}
                                </h6>
                                <form action="{{ route('admin.demandes.assign-agent', $demande) }}" method="POST">
                                    @csrf
                                    <div class="form-row align-items-end">
                                        <div class="form-group col-md-5 mb-0">
                                            <label class="small font-weight-bold">Sélectionner l'agent</label>
                                            <select name="agent_id" class="form-control form-control-sm select2" required>
                                                <option value="">-- Choisir un agent --</option>
                                                @foreach($allAgents as $agentOpt)
                                                    <option value="{{ $agentOpt->id }}">{{ $agentOpt->nom }} {{ $agentOpt->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-0">
                                            <label class="small font-weight-bold">Type de Vacation</label>
                                            <select name="shift" class="form-control form-control-sm" required>
                                                <option value="jour">☀️ Vacation de JOUR (P)</option>
                                                <option value="nuit">🌙 Vacation de NUIT (S)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-0">
                                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                <i class="ri-check-line"></i> Attribuer
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <p class="small text-muted mt-2 mb-0">
                                    <i class="ri-information-line"></i> Cette action générera 16 vacations réelles et attribuera 64 contrats à cet agent.
                                </p>
                            </div>
                        @endfor

                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="ri-file-unknow-line" style="font-size: 32px; opacity: 0.5;"></i>
                            <p class="mb-2 mt-2">Aucun contrat généré.</p>
                            <form action="{{ route('admin.demandes.traiterDemande', ['id' => $demande->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Générer les emplacements de contrats</button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- Pied de carte : dates --}}
                <div class="card-footer bg-white py-2">
                    <div class="row align-items-center">
                        <div class="col-sm-6 text-muted small">
                            <i class="ri-calendar-line"></i>
                            Période : {{ $demande->start_date ? \Carbon\Carbon::parse($demande->start_date)->format('d/m/Y') : '-' }} 
                            au {{ $demande->end_date ? \Carbon\Carbon::parse($demande->end_date)->format('d/m/Y') : '-' }}
                        </div>
                        <div class="col-sm-6 text-right">
                            <span class="badge badge-light">Demande #{{ $demande->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

@endsection