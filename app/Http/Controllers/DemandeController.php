<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Demande;
use App\Models\Vacation;
use App\Services\VacationCodeGenerator;

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
        'nombre_contrats' => 'required|integer|min:1',
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
        'nombre_contrats' => $request->nombre_contrats,
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
        return view('admin.demandes.show', compact('demandes'));
    }



}