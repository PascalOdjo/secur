<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Demande;
use App\Models\Vacation;

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
        'type_contrat' => 'required|string',
        'nombre_contrats' => 'required|integer|min:1',
        'description' => 'nullable|string',
        // 'agent_1_id' => 'required|exists:agents,id', // Validation de l'agent de jour
        // 'agent_2_id' => 'required|exists:agents,id', // Validation de l'agent de nuit
    ]);

    // Vérifier que les agents ne sont pas déjà affecté à une autre vacation
    // $agentsDejaAffectes = Vacation::where('agent_1_id', [$request->agent_1_id, $request->agent_2_id])
    // ->orWhereIn('agent_2_id', [$request->agent_1_id, $request->agent_2_id])
    // ->where('status', '!=', 'termine')
    // ->exists();

    // if ($agentsDejaAffectes) {
    //     return redirect()->back()->with('error', 'Un ou plusieurs agents sont déjà assignés à une vacation pendant cette periode.');
    // }                     

    // Création de la demande dans la base de données
    $demande = new Demande([
        'client_id' => $request->client_id,
        'site_id' => $request->site_id,
        'status' => $request->status,
        'type_contrat' => $request->type_contrat,
        'nombre_contrats' => $request->nombre_contrats,
        'description' => $request->description,
    ]);

    // Sauvegarde de la demande
    $demande->save();

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