<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Demande;
use App\Models\Vacation;
use App\Models\Invoice;
use App\Models\Contrat;
use App\Services\VacationCodeGenerator;
use App\Services\ContractCalculationService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class DemandeController extends Controller
{
    // Afficher le formulaire de demande
    public function create()
    {
        // Récupérer la liste des clients et des sites pour les sélectionner dans le formulaire
        $clients = Client::all();
        $sites = Site::all();

        // Afficher le formulaire de création
        return view('admin.demandes.create', compact('clients', 'sites'));
    }

    // Enregistrer la demande
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'client_nom' => 'required|string|max:255',
            'client_prenom' => 'nullable|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_telephone' => 'nullable|string|max:20',
            'client_adresse' => 'nullable|string|max:255',
            'client_passport_photo' => 'nullable|image|max:5120', // 5MB max
            'site_name' => 'required|string|max:255',
            'site_code' => 'required|string|max:255',
            'site_address' => 'nullable|string|max:255',
            'site_type' => 'required|in:LION,LIONNE',
            'status' => 'required|in:en_cours,affecte,termine,annule',
            'type_vacation' => 'required|in:sys_12,sys_08,sys_06',
            'nombre_agents' => 'required|integer|min:1',
            'montant' => 'required|numeric|min:0',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'description' => 'nullable|string',
        ]);

        // Gérer l'upload de la photo passport
        $passportPhotoPath = null;
        if ($request->hasFile('client_passport_photo') && $request->file('client_passport_photo')->isValid()) {
            try {
                $file = $request->file('client_passport_photo');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('documents'), $fileName);
                $passportPhotoPath = 'documents/' . $fileName;
            } catch (\Exception $e) {
                // Si l'upload échoue, continuer sans photo
                \Illuminate\Support\Facades\Log::error('Error uploading passport photo: ' . $e->getMessage());
            }
        }

        // Créer ou récupérer le client par nom et email
        $client = Client::firstOrCreate(
            ['nom' => $request->client_nom, 'email' => $request->client_email],
            [
                'prenom' => $request->client_prenom ?? '',
                'telephone' => $request->client_telephone,
                'adresse' => $request->client_adresse,
                'passport_photo' => $passportPhotoPath,
            ]
        );

        // Créer ou récupérer le site par nom
        $site = Site::firstOrCreate(
            ['name' => $request->site_name],
            [
                'address' => $request->site_address,
                'site_code' => $request->site_code,
                'site_type' => $request->site_type,
                'client_id' => $client->id,
            ]
        );

        // Création de la demande dans la base de données
        $demande = new Demande([
            'client_id' => $client->id,
            'site_id' => $site->id,
            'status' => $request->status,
            'type_vacation' => $request->type_vacation,
            'nombre_agents' => $request->nombre_agents,
            'montant' => $request->montant,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        // Sauvegarde de la demande
        $demande->save();

        // Calculer les montants selon le nouveau système
        $calculationService = new ContractCalculationService();
        $amounts = $calculationService->calculateContractAmounts(
            $request->nombre_agents,
            $request->start_date,
            $request->end_date
        );

        // Mettre à jour les montants calculés
        $demande->update([
            'valeur_contrat' => $amounts['valeur_contrat'],
            'montant_brut' => $amounts['montant_brut'],
            'montant_exploitation' => $amounts['montant_exploitation'],
            'montant_tresorerie' => $amounts['montant_tresorerie'],
            'status_validation' => $amounts['status_validation'],
        ]);

        // Créer automatiquement une facture pour la demande
        $invoice = new Invoice();
        $invoice->demande_id = $demande->id;
        $invoice->total_amount = $amounts['montant_exploitation']; // Utiliser montant_exploitation
        $invoice->agent_payment = 0; // Sera calculé avec les paiements quotidiens
        $invoice->agency_payment = 0; // À définir selon votre politique
        $invoice->status = 'pending'; // La facture est en attente jusqu'à la fin du contrat
        $invoice->save();

        // Créer les vacations automatiquement (4 réels + 12 virtuels par agent)
        if ($amounts['status_validation'] === 'validé') {
            $calculationService->createVacationsForDemande($demande);
        }

        // Redirection après la création
        return redirect()->route('admin.demandes.index')->with('success', 'Demande créée avec succès.' . ($amounts['status_validation'] === 'en_attente' ? ' (En attente de validation)' : ' (Validée - Vacations créées)'));
    }


    public function index()
    {
        $demandes = Demande::all();
        return view('admin.demandes.index', compact('demandes'));
    }

    public function edit($id)
    {
        $clients = Client::all();
        $sites = Site::all();
        $demande = Demande::findOrFail($id);
        return view('admin.demandes.edit', compact('demande', 'clients', 'sites'));
    }

    public function update(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        // Valider les données
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'site_id' => 'required|exists:sites,id',
            'nombre_agents' => 'required|integer|min:1',
            'montant' => 'required|numeric|min:0',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);

        // Mettre à jour les champs de base
        $demande->update($request->only([
            'client_id',
            'site_id',
            'status',
            'type_vacation',
            'nombre_agents',
            'montant',
            'start_date',
            'end_date',
            'description',
        ]));

        // Recalculer les montants selon le nouveau système
        $calculationService = new ContractCalculationService();
        $amounts = $calculationService->calculateContractAmounts(
            $request->nombre_agents,
            $request->start_date,
            $request->end_date
        );

        // Mettre à jour les montants calculés
        $demande->update([
            'valeur_contrat' => $amounts['valeur_contrat'],
            'montant_brut' => $amounts['montant_brut'],
            'montant_exploitation' => $amounts['montant_exploitation'],
            'montant_tresorerie' => $amounts['montant_tresorerie'],
            'status_validation' => $amounts['status_validation'],
        ]);

        // Mettre à jour la facture
        if ($demande->invoice) {
            $demande->invoice->update([
                'total_amount' => $amounts['montant_exploitation'],
            ]);
        }

        // Recréer les vacations si validé
        if ($amounts['status_validation'] === 'validé') {
            $calculationService->createVacationsForDemande($demande);
        }

        return redirect()->route('admin.demandes.index')->with('success', 'Demande modifiée avec succès.');
    }

    public function destroy($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->delete();
        return redirect()->route('admin.demandes.index')->with('success', 'Demande supprimée avec succès.');
    }

    public function show($id)
    {

        $demandes = Demande::findOrFail($id);
        // dd($demandes->status);
        return view('admin.demandes.show', compact('demandes'));
    }

    // Traitement de la demande des clients
    public function traiterDemande(Request $request, $demandeId)
    {
        // Récupération de la demande à partir de l'ID
        $demande = Demande::find($demandeId);

        if (!$demande) {
            return redirect()->back()->with('error', 'Demande non trouvée.');
        }

        // Récupération du nombre d'agents demandés
        $nombreAgentsDemandes = $demande->nombre_agents;

        // Définition des valeurs de calcul par agent
        $valeurParAgentExploitation = 32;
        $valeurParAgentTresorerie = 96;

        // Calculer les valeurs totales pour l'exploitation et la trésorerie
        $valeurExploitation = $nombreAgentsDemandes * $valeurParAgentExploitation;
        $valeurTresorerie = $nombreAgentsDemandes * $valeurParAgentTresorerie;

        // Initialiser les variables de type de contrat et de validation
        $typeContrat = null;
        $valide = false;

        // Vérification des critères pour un demi-contrat (2 agents)
        if ($nombreAgentsDemandes == 2) {
            if ($valeurExploitation >= 64 && $valeurTresorerie >= 192) {
                $typeContrat = 'Demi-contrat';
                $valide = true;
            }
        }
        // Vérification des critères pour un contrat d'une journée entière (4 agents)
        elseif ($nombreAgentsDemandes >= 4) {
            if ($valeurExploitation >= 128 && $valeurTresorerie >= 384) {
                $typeContrat = 'Journée complète';
                $valide = true;
            }
        }

        // Si la demande est valide, créer et enregistrer le contrat
        if ($valide) {
            try {
                $contrat = Contrat::create([
                    'demande_id' => $demande->id,
                    'nombre_agents' => $nombreAgentsDemandes,
                    'type' => $typeContrat,
                    'valide' => $valide,
                    'valeur_exploitation' => $valeurExploitation,
                    'valeur_tresorerie' => $valeurTresorerie,
                    'statut' => 'Validé',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Erreur lors de la création du contrat : ' . $e->getMessage());
            }

            // Mettre à jour le statut de la demande
            $demande->status = 'affecte';
            $demande->save();
        } else {
            return redirect()->back()->with('error', 'Les critères pour valider cette demande ne sont pas remplis.');
        }

        // Rediriger vers la vue `traiter` avec un message de succès et le nombre de contrats générés
        return redirect()->route('admin.demandes.traiter', ['contratId' => $contrat->id])->with([
            'message' => 'La demande a été validée avec succès !',
            'nombreContrats' => $nombreAgentsDemandes / 2, // Nombre de contrats générés
        ]);
    }

    // Afficher la vue `traiter`
    public function afficherTraitement($contratId)
    {
        $contrat = Contrat::findOrFail($contratId);
        return view('admin.demandes.traiter', compact('contrat'));
    }
}
