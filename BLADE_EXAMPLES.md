# Exemples d'utilisation dans les vues Blade

## Vue: admin/vacations/list.blade.php

```blade
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1>Liste des Vacations et Paiements</h1>

    @forelse($vacationsList as $data)
        <div class="card mb-4">
            <div class="card-header">
                <h5>
                    Demande #{{ $data['demande']->id }} -
                    {{ $data['demande']->client->name }} -
                    {{ $data['demande']->site->name }}
                </h5>
            </div>
            <div class="card-body">

                <!-- Résumé des paiements -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Montant exploitation:</strong><br>
                        {{ number_format($data['payment_breakdown']['exploitation_cfa'] ?? 0, 0, ',', ' ') }} CFA
                    </div>
                    <div class="col-md-3">
                        <strong>Montant trésorerie:</strong><br>
                        {{ number_format($data['payment_breakdown']['tresorerie_cfa'] ?? 0, 0, ',', ' ') }} CFA
                    </div>
                    <div class="col-md-3">
                        <strong>Montant par vacation:</strong><br>
                        {{ number_format($data['montant_par_vacation'] ?? 0, 2, ',', ' ') }} CFA
                    </div>
                    <div class="col-md-3">
                        <strong>Prix par contrat:</strong><br>
                        {{ number_format($data['payment_breakdown']['price_per_contract_cfa'] ?? 0, 2, ',', ' ') }} CFA
                    </div>
                </div>

                <!-- Résumé des vacations -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Vacations réelles:</strong>
                        <span class="badge badge-success">
                            {{ $data['vacation_summary']['real_vacations'] }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <strong>Vacations virtuelles:</strong>
                        <span class="badge badge-warning">
                            {{ $data['vacation_summary']['virtual_vacations'] }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <strong>Total vacations:</strong>
                        <span class="badge badge-info">
                            {{ $data['vacation_summary']['total_vacations'] }}
                        </span>
                    </div>
                </div>

                <!-- Tableau des vacations -->
                <table class="table table-sm table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Groupe</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Shift</th>
                            <th>Agent 1</th>
                            <th>Agent 2</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['vacations'] as $vacation)
                            <tr>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $vacation->group ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <code>{{ $vacation->generated_code ?? $vacation->code_vacation ?? 'N/A' }}</code>
                                </td>
                                <td>
                                    @if($vacation->vacation_type === 'reel')
                                        <span class="badge badge-success">Réel</span>
                                    @else
                                        <span class="badge badge-warning">Virtuel</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $vacation->shift === 'nuit' ? 'badge-dark' : 'badge-light' }}">
                                        {{ ucfirst($vacation->shift) }}
                                    </span>
                                </td>
                                <td>{{ $vacation->agent1->name ?? '-' }}</td>
                                <td>{{ $vacation->agent2->name ?? '-' }}</td>
                                <td>{{ number_format($data['montant_par_vacation'] ?? 0, 2, ',', ' ') }} CFA</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucune vacation</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Aucune demande avec vacations trouvée.
        </div>
    @endforelse

</div>
@endsection
```

## Vue: admin/vacations/detail-demand.blade.php

```blade
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Détails Demande #{{ $demande->id }}</h1>
        </div>
        <div class="col-md-4">
            <a href="{{ route('vacations.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <!-- Informations de la demande -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Informations Générales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <strong>Client:</strong> {{ $demande->client->name }}
                    </p>
                    <p>
                        <strong>Site:</strong> {{ $demande->site->name }}
                    </p>
                    <p>
                        <strong>Nombre d'agents:</strong> {{ $demande->nombre_agents }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Début:</strong> {{ $demande->start_date ? $demande->start_date->format('d/m/Y') : 'N/A' }}
                    </p>
                    <p>
                        <strong>Fin:</strong> {{ $demande->end_date ? $demande->end_date->format('d/m/Y') : 'N/A' }}
                    </p>
                    <p>
                        <strong>Statut:</strong>
                        <span class="badge badge-info">{{ $demande->status ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé des paiements -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Synthèse des Paiements</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>Montant Total</h6>
                        <h4 class="text-primary">
                            {{ number_format($payment_breakdown['total_cfa'] ?? 0, 0, ',', ' ') }}
                        </h4>
                        <small>CFA francs</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>Exploitation (50%)</h6>
                        <h4 class="text-success">
                            {{ number_format($payment_breakdown['exploitation_cfa'] ?? 0, 0, ',', ' ') }}
                        </h4>
                        <small>CFA francs</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>Trésorerie (50%)</h6>
                        <h4 class="text-info">
                            {{ number_format($payment_breakdown['tresorerie_cfa'] ?? 0, 0, ',', ' ') }}
                        </h4>
                        <small>CFA francs</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>Prix/Contrat</h6>
                        <h4 class="text-warning">
                            {{ number_format($payment_breakdown['price_per_contract_cfa'] ?? 0, 2, ',', ' ') }}
                        </h4>
                        <small>CFA francs</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des vacations réelles -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Vacations Réelles <span class="badge badge-success">{{ $realVacations->count() }}</span></h5>
        </div>
        <div class="card-body">
            @if($realVacations->count() > 0)
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Shift</th>
                            <th>Agent 1</th>
                            <th>Agent 2</th>
                            <th>Montant/Vacation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($realVacations as $vacation)
                            <tr>
                                <td><code>{{ $vacation->code_vacation ?? $vacation->generated_code ?? 'N/A' }}</code></td>
                                <td>{{ ucfirst($vacation->shift) }}</td>
                                <td>{{ $vacation->agent1->name ?? '-' }}</td>
                                <td>{{ $vacation->agent2->name ?? '-' }}</td>
                                <td>{{ number_format($montantParVacation ?? 0, 2, ',', ' ') }} CFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucune vacation réelle</p>
            @endif
        </div>
    </div>

    <!-- Tableau des vacations virtuelles -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Vacations Virtuelles <span class="badge badge-warning">{{ $virtualVacations->count() }}</span></h5>
        </div>
        <div class="card-body">
            @if($virtualVacations->count() > 0)
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Shift</th>
                            <th>Agent 1</th>
                            <th>Agent 2</th>
                            <th>Montant/Vacation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($virtualVacations as $vacation)
                            <tr>
                                <td><code>{{ $vacation->code_vacation ?? $vacation->generated_code ?? 'N/A' }}</code></td>
                                <td>{{ ucfirst($vacation->shift) }}</td>
                                <td>{{ $vacation->agent1->name ?? '-' }}</td>
                                <td>{{ $vacation->agent2->name ?? '-' }}</td>
                                <td>{{ number_format($montantParVacation ?? 0, 2, ',', ' ') }} CFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucune vacation virtuelle</p>
            @endif
        </div>
    </div>

</div>
@endsection
```

## Vue: admin/payments/calculate.blade.php

```blade
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Calculatrice de Paiement</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('payments.calculate') }}">
                <div class="form-group">
                    <label for="nombre_agents">Nombre d'agents (minimum 4)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="nombre_agents"
                        name="nombre_agents"
                        min="4"
                        value="{{ request('nombre_agents') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="montant">Montant (optionnel, en CFA)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="montant"
                        name="montant"
                        min="0"
                        step="0.01"
                        value="{{ request('montant') }}"
                    >
                </div>

                <button type="submit" class="btn btn-primary">Calculer</button>
            </form>
        </div>
    </div>

    @if(isset($payment) && $payment['valid'])
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h5>Résultats du Calcul</h5>
            </div>
            <div class="card-body">

                <!-- Résumé principal -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <h6>Agents</h6>
                        <h4>{{ $payment['nombre_agents'] }}</h4>
                    </div>
                    <div class="col-md-3">
                        <h6>Valeur totale (unités)</h6>
                        <h4>{{ number_format($payment['total_value'], 2) }}</h4>
                    </div>
                    <div class="col-md-3">
                        <h6>Valeur totale (CFA)</h6>
                        <h4>{{ number_format($payment['total_cfa'], 0, ',', ' ') }} CFA</h4>
                    </div>
                    <div class="col-md-3">
                        <h6>Par agent</h6>
                        <h4>{{ number_format($payment['total_cfa'] / $payment['nombre_agents'], 0, ',', ' ') }} CFA</h4>
                    </div>
                </div>

                <!-- Répartition -->
                <h6 class="mb-3">Répartition Exploitation / Trésorerie (50% chacun)</h6>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Exploitation</h6>
                                <p class="mb-0">
                                    <strong>Unités:</strong> {{ number_format($payment['exploitation_value'], 2) }}<br>
                                    <strong>CFA:</strong> {{ number_format($payment['exploitation_cfa'], 0, ',', ' ') }} CFA
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Trésorerie</h6>
                                <p class="mb-0">
                                    <strong>Unités:</strong> {{ number_format($payment['tresorerie_value'], 2) }}<br>
                                    <strong>CFA:</strong> {{ number_format($payment['tresorerie_cfa'], 0, ',', ' ') }} CFA
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détail des contrats -->
                <h6 class="mb-3">Détail des Contrats (Exploitation)</h6>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Étape 1 (exploitation / 2)</td>
                            <td><strong>{{ number_format($payment['contract_breakdown']['step1'], 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Étape 2 (step1 / 2)</td>
                            <td><strong>{{ number_format($payment['contract_breakdown']['step2'], 2) }}</strong> contrats abstraits</td>
                        </tr>
                        <tr>
                            <td>Étape 3 (step2 / 4)</td>
                            <td><strong>{{ number_format($payment['contract_breakdown']['step3'], 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Étape 4 (step3 / 16)</td>
                            <td><strong>{{ number_format($payment['contract_breakdown']['step4'], 2) }}</strong> unité/contrat de base</td>
                        </tr>
                        <tr class="table-info">
                            <td><strong>Division finale (step4 / 4)</strong></td>
                            <td>
                                <strong>{{ $payment['contract_breakdown']['real_contracts'] }} contrat réel</strong> +
                                <strong>{{ $payment['contract_breakdown']['virtual_contracts'] }} virtuels</strong>
                            </td>
                        </tr>
                        <tr class="table-success">
                            <td><strong>Prix par contrat</strong></td>
                            <td>
                                <strong>{{ number_format($payment['price_per_contract_cfa'], 2, ',', ' ') }} CFA</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Groupes de vacations -->
                <h6 class="mb-3">Groupes de Vacations</h6>
                <p>
                    <strong>Groupes:</strong>
                    {{ implode(', ', $payment['vacation_code_groups']) }}
                </p>
                <p>
                    <strong>Vacations par agent par mois:</strong>
                    {{ $payment['vacations_per_month'] }}
                </p>

            </div>
        </div>
    @elseif(isset($payment) && !$payment['valid'])
        <div class="alert alert-danger mt-4">
            {{ $payment['error'] }}
        </div>
    @endif

</div>
@endsection
```

## Composant de résumé paiement (réutilisable)

```blade
@if($demande && $demande->montant_exploitation)
    <div class="payment-summary">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-box">
                    <small>Exploitation</small>
                    <h5>{{ number_format($demande->montant_exploitation, 0, ',', ' ') }}</h5>
                    <small>CFA</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <small>Trésorerie</small>
                    <h5>{{ number_format($demande->montant_tresorerie, 0, ',', ' ') }}</h5>
                    <small>CFA</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <small>Prix/Contrat</small>
                    <h5>{{ number_format($demande->prix_par_agent, 0, ',', ' ') }}</h5>
                    <small>CFA</small>
                </div>
            </div>
        </div>
    </div>
@endif
```

## CSS pour les badges (optionnel)

```css
.stat-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
    text-align: center;
}

.stat-box small {
    color: #6c757d;
    font-size: 0.875rem;
    display: block;
}

.stat-box h5 {
    margin: 10px 0;
    color: #495057;
}

.badge-real {
    background-color: #28a745;
}

.badge-virtual {
    background-color: #ffc107;
    color: #000;
}
```
