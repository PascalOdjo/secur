{{--
  Payment Breakdown Card Component
  Usage: @include('admin.demandes.payment-breakdown-card', ['demande' => $demande])
  
  Shows 4 vacation types breakdown:
  - 16A (Real): 16 vacations
  - 16B, 16C, 16D (Virtual): 16 vacations each
  - Total: 64 vacations per agent
--}}

@if($demande && $demande->salaire_par_agent)
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">
            <i class="fas fa-calendar-alt"></i> Distribution par type de vacation
        </h5>
        <small class="text-light">(64 vacations total: 1 réelle + 3 virtuelles)</small>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- 16A - Réelle -->
            <div class="col-md-6 mb-3">
                <div class="card border-primary h-100">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-star"></i> 16A - Réelle (Real)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Montant total:</strong>
                            <br>
                            <span class="h5 text-primary">
                                {{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }} CFA
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Nombre:</strong>
                            <span class="badge badge-primary">16 vacations</span>
                        </p>
                        <p class="mb-0">
                            <strong>Par vacation:</strong>
                            <br>
                            <span class="text-muted">
                                {{ number_format($demande->montant_par_vacation ?? 0, 2, ',', ' ') }} CFA
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 16B - Virtuelle -->
            <div class="col-md-6 mb-3">
                <div class="card border-info h-100">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-ghost"></i> 16B - Virtuelle (Virtual)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Montant total:</strong>
                            <br>
                            <span class="h5 text-info">
                                {{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }} CFA
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Nombre:</strong>
                            <span class="badge badge-info">16 vacations</span>
                        </p>
                        <p class="mb-0">
                            <strong>Par vacation:</strong>
                            <br>
                            <span class="text-muted">
                                {{ number_format($demande->montant_par_vacation ?? 0, 2, ',', ' ') }} CFA
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 16C - Virtuelle -->
            <div class="col-md-6 mb-3">
                <div class="card border-warning h-100">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="fas fa-ghost"></i> 16C - Virtuelle (Virtual)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Montant total:</strong>
                            <br>
                            <span class="h5 text-warning">
                                {{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }} CFA
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Nombre:</strong>
                            <span class="badge badge-warning">16 vacations</span>
                        </p>
                        <p class="mb-0">
                            <strong>Par vacation:</strong>
                            <br>
                            <span class="text-muted">
                                {{ number_format($demande->montant_par_vacation ?? 0, 2, ',', ' ') }} CFA
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 16D - Virtuelle -->
            <div class="col-md-6 mb-3">
                <div class="card border-danger h-100">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-ghost"></i> 16D - Virtuelle (Virtual)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Montant total:</strong>
                            <br>
                            <span class="h5 text-danger">
                                {{ number_format($demande->salaire_par_agent / 4, 0, ',', ' ') }} CFA
                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Nombre:</strong>
                            <span class="badge badge-danger">16 vacations</span>
                        </p>
                        <p class="mb-0">
                            <strong>Par vacation:</strong>
                            <br>
                            <span class="text-muted">
                                {{ number_format($demande->montant_par_vacation ?? 0, 2, ',', ' ') }} CFA
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Résumé total -->
        <div class="alert alert-light mt-3 mb-0">
            <div class="row">
                <div class="col-md-8">
                    <strong>TOTAL (1 réelle + 3 virtuelles = 64 vacations):</strong>
                </div>
                <div class="col-md-4 text-right">
                    <span class="h5 text-success">
                        <strong>{{ number_format($demande->salaire_par_agent, 0, ',', ' ') }} CFA</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif