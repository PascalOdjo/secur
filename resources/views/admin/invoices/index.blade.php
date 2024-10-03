@extends('layouts.app')

@section('content')
<div id="containerbar">
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Liste des Factures</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Factures</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary"><i class="ri-add-line mr-2"></i> Créer une nouvelle facture</a>
                </div>                        
            </div>
        </div>
    </div>

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title text-center font-25">Liste des Factures</h5>
                    </div>
                    <div class="card-body">
                        <!-- Messages de succès -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Tableau des factures -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Demande ID</th>
                                        <th>Montant Total</th>
                                        <th>Paiement Agents</th>
                                        <th>Paiement Agence</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->vacation_id }}</td>
                                            <td>{{ number_format($invoice->total_amount, 2) }} Francs CFA</td>
                                            <td>{{ number_format($invoice->agent_payment, 2) }} Francs CFA</td>
                                            <td>{{ number_format($invoice->agency_payment, 2) }} Francs CFA</td>
                                            <td>
                                                <span class="badge badge-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-info btn-sm"><i class="ri-eye-line"></i></a>
                                                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm"><i class="ri-edit-line"></i></a>
                                                <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')"><i class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Aucune facture trouvée</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
