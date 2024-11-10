<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\Invoice;
use App\Models\Demande;

class InvoiceController extends Controller
{

    public function index(){
        $invoices = Invoice::paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }
    public function store(Request $request)
    {
    // Validation des champs
    $request->validate([
        'demande_id' => 'required|exists:demandes,id',
        'total_amount' => 'required|numeric|min:0',
    ]);

    // Création de la facture
    $invoice = new Invoice();
    $invoice->demande_id = $request->input('demande_id');
    $invoice->total_amount = $request->input('total_amount');
    $invoice->agent_payment = $invoice->total_amount * 0.25; // Calcul du paiement agent
    $invoice->agency_payment = $invoice->total_amount * 0.75; // Calcul du paiement agence
    $invoice->status = 'pending'; // Statut par défaut
    $invoice->save();

    // Redirection avec un message de succès
    return redirect()->route('admin.invoices.index')->with('success', 'Facture créée avec succès.');
}



    public function show($invoiceId){
        $invoice = Invoice::with('agents')->findOrFail($invoiceId);

        return view('admin.invoices.show', compact('invoice'));
    }

    private function calculateAmount($vacation){
        $rate = 100;
        return $rate;
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
        $demandes = Demande::all(); // Récupérer toutes les demandes
        $demande = $demande_id ? Demande::find($demande_id) : null; // Récupérer la demande si l'ID est fourni
        return view('admin.invoices.create', compact('demandes', 'demande')); // Passer les demandes et la demande à la vue
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
    

    
}
