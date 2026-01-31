<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\Invoice;
use App\Models\Demande;
use App\Models\AgentPayment;
use App\Models\Agent;

class InvoiceController extends Controller
{

    public function index()
    {
        // Récupérer toutes les factures avec leurs demandes associées
        $invoices = Invoice::with('demande.client', 'demande.site')
            ->paginate(10);

        // Recalculer les montants pour chaque facture basé sur les paiements réels
        foreach ($invoices as $invoice) {
            $this->updateInvoiceAmounts($invoice);
        }

        // Récupérer les paiements agents en attente et les agréger par agent
        $agentPayments = \App\Models\AgentPayment::where('status', 'pending')
            ->selectRaw('agent_id, SUM(amount) as total')
            ->groupBy('agent_id')
            ->get();

        // Charger les informations des agents pour l'affichage
        $agentPayments->load('agent');

        return view('admin.invoices.index', compact('invoices', 'agentPayments'));
    }
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'demande_id' => 'required|exists:demandes,id',
        ]);

        // Vérifier qu'une facture n'existe pas déjà pour cette demande
        $existingInvoice = Invoice::where('demande_id', $request->demande_id)->first();
        if ($existingInvoice) {
            return redirect()->back()->with('error', 'Une facture existe déjà pour cette demande.');
        }

        // Récupérer la demande
        $demande = Demande::findOrFail($request->demande_id);

        // Création de la facture basée sur la demande
        $invoice = new Invoice();
        $invoice->demande_id = $demande->id;
        $invoice->total_amount = $demande->montant; // Utiliser le montant de la demande
        $invoice->agent_payment = 0; // Sera mis à jour avec les paiements quotidiens
        $invoice->agency_payment = 0; // À définir selon votre politique
        $invoice->status = 'pending'; // La facture est en attente
        $invoice->save();

        // Redirection avec un message de succès
        return redirect()->route('admin.invoices.index')->with('success', 'Facture créée avec succès pour la demande.');
    }



    public function show($invoiceId)
    {
        $invoice = Invoice::with('demande.client', 'demande.site', 'demande.vacations')->findOrFail($invoiceId);

        // Recalculer les montants basés sur les paiements réels des agents
        $this->updateInvoiceAmounts($invoice);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Recalcule les montants agents et agence basés sur les paiements générés
     */
    private function updateInvoiceAmounts(Invoice $invoice)
    {
        // Récupérer tous les paiements des agents pour cette demande
        $agentPaymentTotal = \App\Models\AgentPayment::whereHas('vacation', function ($query) {
            $query->where('demande_id', $this->demande_id ?? null);
        })->where('status', 'pending')
            ->sum('amount');

        // Si la facture a une demande associée
        if ($invoice->demande_id) {
            $agentPaymentTotal = \App\Models\AgentPayment::whereHas('vacation', function ($query) use ($invoice) {
                $query->where('demande_id', $invoice->demande_id);
            })->sum('amount');

            // Mettre à jour les montants
            $invoice->agent_payment = $agentPaymentTotal;
            $invoice->agency_payment = $invoice->total_amount - $agentPaymentTotal;
            $invoice->save();
        }
    }

    public function pay($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Logique de paiement ici
        $invoice->status = 'paid'; // Met à jour le statut de la facture
        $invoice->save(); // Enregistre les modifications

        return redirect()->route('admin.invoices.show', $id)->with('success', 'Facture payée avec succès.');
    }
    public function create($demande_id = null)
    {
        // Cette méthode n'est plus nécessaire car les factures sont créées automatiquement
        // lors de la création d'une demande. Rediriger vers l'index.
        return redirect()->route('admin.invoices.index')->with('info', 'Les factures sont créées automatiquement avec les demandes.');
    }

    public function processPayment(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'payment_method' => 'required|string',
            'card_number' => 'required_if:payment_method,card|string',
            'expiry_date' => 'required_if:payment_method,card|string',
            'cvv' => 'required_if:payment_method,card|string',
        ]);

        // Récupérer la facture
        $invoice = Invoice::findOrFail($id);

        // Traitement du paiement
        if ($request->payment_method === 'card') {
            // Logique pour traiter le paiement par carte
            // Par exemple, utiliser une API de paiement
            // $paymentResult = PaymentGateway::charge($request->card_number, $request->expiry_date, $request->cvv, $invoice->total_amount);

            // Simuler le résultat du paiement
            $paymentResult = true; // Remplacez ceci par la logique réelle

            if (!$paymentResult) {
                return redirect()->back()->with('error', 'Le paiement a échoué.');
            }
        } else {
            // Logique pour le paiement en espèces
            // Enregistrer le paiement comme effectué
        }

        // Marquer la facture comme payée
        $invoice->status = 'paid';
        $invoice->save();

        return redirect()->route('admin.invoices.index')->with('success', 'Le paiement a été effectué avec succès.');
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // Récupérer la facture
        $invoice = Invoice::findOrFail($id);

        // Mettre à jour les champs
        $invoice->total_amount = $request->total_amount;
        $invoice->status = $request->status; // Assurez-vous que le statut est mis à jour
        $invoice->save();

        return redirect()->route('admin.invoices.index')->with('success', 'La facture a été mise à jour avec succès.');
    }

    public function edit($id)
    {
        // Récupérer la facture
        $invoice = Invoice::findOrFail($id);

        // Afficher la vue de modification de la facture
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function destroy($id)
    {
        // Récupérer la facture
        $invoice = Invoice::findOrFail($id);

        // Supprimer la facture
        $invoice->delete();

        // Redirection avec un message de succès
        return redirect()->route('admin.invoices.index')->with('success', 'La facture a été supprimée avec succès.');
    }
}
