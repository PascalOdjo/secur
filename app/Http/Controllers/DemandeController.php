<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Demande;
use App\Models\Vacation;
use App\Models\Contrat;
use App\Services\VacationCodeGenerator;
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
        'client_id' => 'required|exists:clients,id',
        'site_id' => 'required|exists:sites,id',
        'status' => 'required|in:en_cours,affecte,termine,annule',
        'type_vacation' => 'required|in:sys_12,sys_08',
        'nombre_agents' => 'required|integer|min:1',
        'description' => 'nullable|string',
        // 'agent_1_id' => 'required|exists:agents,id', // Validation de l'agent de jour
        // 'agent_2_id' => 'required|exists:agents,id', // Validation de l'agent de nuit
    ]);

                        

    // Création de la demande dans la base de données
    $client = Client::findOrFail($request->client_id);
    $demande = new Demande([
        'client_id' => $request->client_id,
        'site_id' => $request->site_id,
        'status' => $request->status,
        'type_vacation' => $request->type_vacation,
        'nombre_agents' => $request->nombre_contrats,
        'description' => $request->description,
    ]);

    // Sauvegarde de la demande
    $demande->save();

    
    // Instanciation du générateur de codes de vacations
    $generator = new VacationCodeGenerator();

    // Création des vacations en fonction du nombre de contrats
    for ($i = 1; $i <= $request->nombre_contrats; $i++) {
        // Création d'une nouvelle vacation
        $vacation = new Vacation();
        $vacation->demande_id = $demande->id; // Association à la demande
        $vacation->site_id = $request->site_id; // Affectation au site
        $vacation->shift_jour_start_time = '06:00';
        $vacation->shift_jour_end_time = '18:00';
        $vacation->shift_nuit_start_time = '18:01';
        $vacation->shift_nuit_end_time = '06:00';
        $vacation->status = 'affecte'; // Par défaut, une vacation est affectée

        // Déterminer si c'est une vacation de nuit ou de jour
        $isNight = ($vacation->shift_jour_start_time > $vacation->shift_nuit_start_time); // Exemple de logique
        $isFullDay = false; // Changez cette logique si nécessaire

        // Génération des codes de vacation
        $vacationCodes = $generator->generateVacationCodes($demande->id, $isNight, $isFullDay);
        $vacation->code_vacation = implode('  ', $vacationCodes); // Combine les codes générés

        $vacation->save();

        // Affectation des agents pour chaque vacation
        // $vacation->agent_1_id = $request->input('agent_1_id'); // Agent de jour
        // $vacation->agent_2_id = $request->input('agent_2_id'); // Agent de nuit
        // $vacation->save();
    }

    // Redirection après la création de toutes les vacations
    return redirect()->route('admin.demandes.index')->with('success', 'Demande et vacations créées avec succès.');
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
        $demande->update($request->all());
        return redirect()->route('admin.demandes.index')->with('success', 'Demande modifié avec succès.');
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