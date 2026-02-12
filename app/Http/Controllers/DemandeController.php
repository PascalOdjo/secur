<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Demande;
use App\Models\Vacation;
use App\Models\Invoice;
use App\Models\Contrat;
use App\Models\Agent;
use App\Services\VacationCodeGenerator;
use App\Services\PaymentCalculatorService;
use App\Services\AgentPaymentService;
use App\Services\ContractCalculationService;
use App\Services\ContractGeneratorService;
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
            'nombre_agents' => 'required|integer|min:4',
            'montant_par_agent' => 'required|numeric|min:1',
            'montant' => 'nullable|numeric|min:0',
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
            'montant_par_agent' => $request->montant_par_agent,
            'montant' => $request->montant ?? ($request->nombre_agents * $request->montant_par_agent),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        // Sauvegarde de la demande
        $demande->save();

        // Calculer les montants selon le NOUVEAU SYSTÈME (Février 2025)
        // Formule: Salaire par agent = Montant_par_agent / 2
        $nombreAgents = $request->nombre_agents;
        $montantParAgent = $request->montant_par_agent;
        $montantTotal = $nombreAgents * $montantParAgent;

        // Split 50/50
        $montantExploitation = $montantTotal / 2;
        $montantTresorerie = $montantTotal / 2;

        // Salaire par agent (clé du système)
        $salaireParAgent = $montantParAgent / 2;

        // Montant par vacation (divisé en 64: 16A + 16B + 16C + 16D = 64 par agent)
        $montantParVacation = $salaireParAgent / 64;

        // Mettre à jour les montants calculés
        $demande->update([
            'montant_brut' => $montantTotal,
            'montant_exploitation' => $montantExploitation,
            'montant_tresorerie' => $montantTresorerie,
            'salaire_par_agent' => $salaireParAgent,
            'montant_par_vacation' => $montantParVacation,
            'status_validation' => 'validé',
        ]);

        // Créer automatiquement une facture pour la demande
        $invoice = new Invoice();
        $invoice->demande_id = $demande->id;
        $invoice->total_amount = $montantExploitation; // Utiliser montant_exploitation
        $invoice->agent_payment = 0; // Sera calculé avec les paiements quotidiens
        $invoice->agency_payment = 0; // À définir selon votre politique
        $invoice->status = 'pending'; // La facture est en attente jusqu'à la fin du contrat
        $invoice->save();

        // Les vacations ne sont plus créées automatiquement au store, 
        // elles sont générées lors de l'attribution manuelle d'un agent.
        // $calculationService = new ContractCalculationService();
        // $calculationService->createVacationsForDemande($demande);

        // Créer les contrats automatiquement (256 contrats vides pour les slots)
        $contractGenerator = new ContractGeneratorService();
        $contractGenerator->createContractsForDemande($demande);

        // Redirection après la création
        return redirect()->route('admin.demandes.index')->with('success', 'Demande créée avec succès! Les contrats ont été préparés pour l\'attribution manuelle.');
    }


    public function index()
    {
        $query = Demande::with(['client', 'site', 'contrats.agent', 'contrats.vacation']);

        if ($search = request('search')) {
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $demandes = $query->latest()->get();
        $allAgents = Agent::orderBy('nom')->get();

        return view('admin.demandes.index', compact('demandes', 'allAgents'));
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

    /**
     * Traiter le paiement d'une demande avec le nouveau système (Février 2025)
     * Formule: Salaire par agent = Montant_par_agent / 2
     */
    public function processerPaiement(Request $request, $demandeId)
    {
        $demande = Demande::findOrFail($demandeId);

        // Valider les données
        $validated = $request->validate([
            'montant_par_agent' => 'required|numeric|min:1',
        ]);

        try {
            $nombreAgents = $demande->nombre_agents;
            $montantParAgent = $validated['montant_par_agent'];

            // Valider le nombre d'agents
            if ($nombreAgents < 4) {
                return redirect()->back()->with('error', "Minimum 4 agents requis. Demande a {$nombreAgents} agents.");
            }

            // Calculer selon le nouveau système
            $montantTotal = $nombreAgents * $montantParAgent;
            $montantExploitation = $montantTotal / 2;
            $montantTresorerie = $montantTotal / 2;
            $salaireParAgent = $montantParAgent / 2;
            $montantParVacation = $salaireParAgent / 64;

            // Mettre à jour la demande
            $demande->update([
                'montant_par_agent' => $montantParAgent,
                'montant_brut' => $montantTotal,
                'montant_exploitation' => $montantExploitation,
                'montant_tresorerie' => $montantTresorerie,
                'salaire_par_agent' => $salaireParAgent,
                'montant_par_vacation' => $montantParVacation,
                'status' => 'affecte',
                'status_validation' => 'validé',
            ]);

            return redirect()->back()->with('success', [
                'message' => 'Paiement traité avec succès!',
                'salaire_par_agent' => number_format($salaireParAgent, 0, ',', ' ') . ' CFA',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Erreur: {$e->getMessage()}");
        }
    }

    /**
     * Afficher les détails du paiement d'une demande
     */
    public function afficherPaiement($demandeId)
    {
        $demande = Demande::with(['client', 'site', 'contrats.agent'])->findOrFail($demandeId);

        if (!$demande->salaire_par_agent) {
             // Fallback: si ce n'est pas rempli, on peut tenter de le calculer à la volée ou avertir
            if ($demande->montant_par_agent > 0) {
                $demande->salaire_par_agent = $demande->montant_par_agent / 2;
                $demande->montant_par_vacation = $demande->salaire_par_agent / 64;
            } else {
                return redirect()->back()->with('warning', 'Cette demande n\'a pas encore de montants définis.');
            }
        }

        // Récupérer les agents uniques assignés à cette demande
        $agents = $demande->contrats->whereNotNull('agent_id')->pluck('agent')->unique('id');

        return view('admin.demandes.paiement', compact('demande', 'agents'));
    }

    /**
     * Attribuer manuellement un agent et son type de vacation (jour/nuit) à un slot de contrats.
     */
    public function assignAgent(Request $request, Demande $demande)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'shift' => 'required|in:jour,nuit',
        ]);

        $agent = Agent::find($request->agent_id);
        $shiftType = $request->shift; // 'jour' ou 'nuit'

        // 1. Trouver le premier slot de 64 contrats vides pour cette demande
        $unassignedContracts = $demande->contrats()->whereNull('agent_id')->orderBy('id')->get();
        
        if ($unassignedContracts->isEmpty()) {
            return redirect()->back()->with('error', 'Tous les agents ont déjà été attribués pour cette demande.');
        }

        // On prend les 64 premiers
        $contractsToUpdate = $unassignedContracts->take(64);

        // 2. Créer les 16 vacations réelles pour cet agent
        $vacations = [];
        $groups = ['K', 'L', 'M', 'N'];
        $codeGen = new \App\Services\VacationCodeGenerator();

        for ($i = 0; $i < 16; $i++) {
            $group = $groups[$i % 4];
            $code = $codeGen->generateSingleCode($demande->site, $group, 'A', ($shiftType === 'nuit'));
            
            $vacation = Vacation::create([
                'demande_id' => $demande->id,
                'agent_1_id' => $agent->id,
                'code_vacation' => $code,
                'vacation_type' => 'reel',
                'type_vacation' => $demande->type_vacation,
                'shift' => ($shiftType === 'nuit' ? 'nuit' : 'jour'),
                'start_time' => $demande->start_date,
                'end_time' => $demande->end_date,
                'status' => 'affecte',
            ]);
            $vacations[] = $vacation;
        }

        // 3. Lier au contrat (64 contrats : 16 réels tied to vacations, 48 virtuels)
        foreach ($contractsToUpdate as $index => $contract) {
            $isReal = ($index % 4 === 0);
            $vacationId = null;
            
            if ($isReal && isset($vacations[intdiv($index, 4)])) {
                $vacationId = $vacations[intdiv($index, 4)]->id;
            }

            $contract->update([
                'agent_id' => $agent->id,
                'vacation_id' => $vacationId,
                'type' => strtoupper($shiftType) // JOUR ou NUIT
            ]);
        }

        return redirect()->back()->with('message', "L'agent {$agent->nom} a été attribué avec succès en vacation de {$shiftType}.");
    }

    /**
     * Afficher les 64 contrats par agent pour une demande (4 agents × 64 = 256 = valeur exploitation).
     * Chaque agent : 16 contrats réels (avec vacation) + 48 virtuels.
     */
    public function contratsParAgent(Demande $demande)
    {
        $contractGenerator = new ContractGeneratorService();
        $data = $contractGenerator->getContractsByAgentForDemande($demande);
        return view('admin.demandes.contrats-par-agent', $data);
    }
}
