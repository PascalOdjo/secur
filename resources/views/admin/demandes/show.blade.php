@extends('layouts.app')

@section('content')

<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Administration</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Gestion des demandes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="{{route('admin.demandes.index')}}" class="btn btn-primary"><i class="ri-arrow-left-line mr-2"></i> Retour</a>
            </div>
        </div>
    </div>
</div>




<div class="contentbar">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <!-- Start row -->

    <!-- End row -->
    <!-- Start row -->
    <div class="row">

        <!-- Start col -->
        <div class="col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header text-center">
                    <h5 class="card-title mb-0">Photo de Profile</h5>
                </div>
                <div class="card-body text-center ">
                    @if($demandes->client->passport_photo)
                    <img src="{{asset($demandes->client->passport_photo ) }}" alt="Photo de {{ $demandes->client->nom }}" width="200" style="border-radius: 50%;">
                    @else
                    <p>Pas de photo</p>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-4 border-right px-0">
                            <p class="my-2">Nom</p>
                            <h5>{{old('nom', $demandes->client->nom) ?? '-'}}</h5>
                        </div>
                        <div class="col-4 border-right px-0">
                            <p class="my-2">Prénom</p>
                            <h5>{{old('prenom', $demandes->client->prenom) ?? '-'}}</h5>
                        </div>

                        <div class="col-4 px-0">
                            <p class="my-2">Email</p>
                            <h5> {{ isset($demandes->client->email) ? $demandes->client->email : '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>

    <!-- Start row -->
    <div class="row">

        <!-- Start col -->
        <div class="col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header text-center">
                    <h5 class="card-title mb-0">Autres Informations</h5>
                </div>
                <div class="card-body p-3">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="adresse">Adresse</label>
                            <input type="text" name="adresse" id="adresse" disabled required class="form-control" value="{{$demandes->client->adresse}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="site">Site</label>
                            <input type="text" disabled class="form-control" id="site" name="site" required value="{{$demandes->site ? $demandes->site->name : '-'}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nom">Email</label>
                            <input type="email" class="form-control" id="email" disabled name="email" required value="{{$demandes->client->email}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telephone">Téléphone</label>
                            <input type="text" disabled class="form-control" id="telephone" placeholder="telephone" name="telephone" required value="{{$demandes->client->telephone}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="montant">Montant (FCFA)</label>
                            <input type="number" class="form-control" id="montant" disabled name="montant" value="{{number_format($demandes->montant, 2, '.', '')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="start_date">Date de Début</label>
                            <input type="date" class="form-control" id="start_date" disabled name="start_date" value="{{$demandes->start_date}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="end_date">Date de Fin</label>
                            <input type="date" class="form-control" id="end_date" disabled name="end_date" value="{{$demandes->end_date}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nom">Type Vacation</label>
                            <input type="text" class="form-control" id="type_vacation" disabled name="type_vacation" required value="{{$demandes->type_vacation}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telephone">Status</label>
                            <input type="text" disabled class="form-control" id="status" placeholder="status" name="status" required value="{{$demandes->status}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nom">Nombre d'agents</label>
                            <input type="text" class="form-control" id="nombre_agents" disabled name="nombre_agents" required value="{{$demandes->nombre_agents}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea type="text" disabled class="form-control" id="description" placeholder="description" name="description" required>{{$demandes->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>

    <!-- Start row: Vacations & Payments -->
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vacations Associées</h5>
                </div>
                <div class="card-body p-0">
                    @if($demandes->vacations && $demandes->vacations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code Vacation</th>
                                    <th>Agent 1</th>
                                    <th>Agent 2</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Paiements Générés</th>
                                    <th>Montant Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($demandes->vacations as $vacation)
                                <tr>
                                    <td>{{ $vacation->id }}</td>
                                    <td><strong>{{ $vacation->code_vacation ?? '-' }}</strong></td>
                                    <td>{{ $vacation->agent1 ? $vacation->agent1->nom . ' ' . $vacation->agent1->prenom : '-' }}</td>
                                    <td>{{ $vacation->agent2 ? $vacation->agent2->nom . ' ' . $vacation->agent2->prenom : '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($vacation->start_time)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($vacation->end_time)->format('d/m/Y') }}</td>
                                    <td><span class="badge badge-primary">{{ $vacation->agentPayments ? $vacation->agentPayments->count() : 0 }}</span></td>
                                    <td><strong>{{ number_format($vacation->agentPayments ? $vacation->agentPayments->sum('amount') : 0, 2, ',', ' ') }} FCFA</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-3 text-center text-muted">
                        Aucune vacation créée pour cette demande.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Start row: Invoice Details -->
    @if($demandes->invoice)
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">Facture Associée (Facture #{{ $demandes->invoice->id }})</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <h6 class="text-muted">Montant Total</h6>
                                <h4 class="text-primary">{{ number_format($demandes->invoice->total_amount, 2, ',', ' ') }} FCFA</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <h6 class="text-muted">Paiement Agents</h6>
                                <h4 class="text-success">{{ number_format($demandes->invoice->agent_payment, 2, ',', ' ') }} FCFA</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <h6 class="text-muted">Paiement Agence</h6>
                                <h4 class="text-danger">{{ number_format($demandes->invoice->agency_payment, 2, ',', ' ') }} FCFA</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Statut:</strong> <span class="badge badge-{{ $demandes->invoice->status == 'paid' ? 'success' : 'warning' }}">{{ $demandes->invoice->status }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.invoices.show', $demandes->invoice->id) }}" class="btn btn-sm btn-info">Voir la Facture</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End row: Invoice Details -->

    <div class="btn-group mt-3">
        <a href="{{ route('admin.demandes.edit', $demandes->id) }}" class="btn btn-warning mr-2">Modifier</a>
        <form action="{{ route('admin.demandes.traiterDemande', ['id' => $demandes->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Valider la demande</button>
        </form>
    </div>



    @if(session()->has('success'))
    <div class="modal fade" id="validation-modal" tabindex="-1" role="dialog" aria-labelledby="validation-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validation-modal-label">Demande validée !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session()->get('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#validation-modal').modal('show');
        });
    </script>
    @endif



    @endsection