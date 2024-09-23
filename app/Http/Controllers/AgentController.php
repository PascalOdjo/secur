<?php

namespace App\Http\Controllers;

use App\Models\Agent;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PersonneAPrevenir;

class AgentController extends Controller
{
    public function index(Request $request){
        $search = $request->get('search'); // Récuperer la valeur de la recherche

        // rechercher les agents selon le nom ou le prenom etc ...
        $agents = Agent::when($search, function ($query) use ($search) {
            $query->where('nom', 'like', '%' . $search . '%')
                ->orWhere('prenom', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('telephone', 'like', '%' . $search . '%')
                ->orWhere('addresse', 'like', '%' . $search . '%');

        })->get();
        // $agents = Agent::all();
        return view('admin.agents.index', compact('agents'));
    }

    // Afficher le formulaire pour créer un nouvel agent
    public function create(){
        return view('admin.agents.create');
    }

    // pour enregistrer un nouvel agent dans la base de donnée


    public function store(Request $request)
{
    // dd($request->all());
    DB::beginTransaction();
    try {
        // Validation des données de l'agent
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'telephone' => 'required|string|max:255|unique:agents',
            'addresse' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'taille' => 'required|numeric|between:0.50,2.50',
            'age' => 'required|integer|min:18|max:65',  // Exemple de règle pour valider l'âge entre 18 et 65 ans
            'type_contrat' => 'required|string|in:CDD,CDI',
            'date_debut_contrat' => 'required|date',
            'date_fin_contrat' => 'required|date|after_or_equal:date_debut_contrat',
            'carte_identite' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'passport_photo' => 'nullable|image|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'casier_judiciaire' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'certificat_naissance' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'certificat_medical' => 'required|file|mimes:pdf,jpeg,png|max:2048',
            'permit_residence' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'status' => 'required|string|in:actif,inactif,en attente',
            // Validation des personnes à prévenir
            'personnes.*.nom' => 'required|string|max:255',
            'personnes.*.prenom' => 'required|string|max:255',
            'personnes.*.contact' => 'required|string|max:255',
            'personnes.*.profession' => 'nullable|string|max:255',
            'personnes.*.adresse' => 'nullable|string|max:255',
        ]);

        // Créer l'agent avec les données validées
        $agent = Agent::create($validatedData);

        // Gérer les fichiers
        $fileFields = ['carte_identite', 'passport_photo', 'casier_judiciaire', 'certificat_naissance', 'certificat_medical', 'permit_residence'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $fileName = time() . '_' . $field . '.' . $request->file($field)->extension();  
                $request->file($field)->move(public_path('documents'), $fileName);
                // Enregistrez le chemin dans la base de données
                $agent->$field = 'documents/' . $fileName;
            }
        }

        $agent->save();

        // Enregistrer les personnes à prévenir
        foreach ($request->input('personnes', []) as $personne) {
            $agent->personneaprevenir()->create([
                'nom' => $personne['nom'],
                'prenom' => $personne['prenom'],
                'contact' => $personne['contact'],
                'profession' => $personne['profession'] ?? null,
                'adresse' => $personne['adresse'] ?? null,
            ]);
        }

        DB::commit();
        return redirect()->route('admin.agents.index')->with('success', 'Agent créé avec succès !');
    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        Log::error('Erreur de validation:', $e->errors());
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de l\'enregistrement de l\'agent:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'agent: ' . $e->getMessage())->withInput();
    }
}




    public function show($id)
    {
    $agent = Agent::with('personneaprevenir')->findOrFail($id); // Récupère l'agent par son ID
    return view('admin.agents.show', compact('agent')); // Retourne la vue avec les informations de l'agent
    }

    // Afficher le formulaire pour editer un agent
    public function edit($id){
        $agent = Agent::with('personneaprevenir')->findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    // pour mettre à jour un agent dans la base de donnée
    public function update(Request $request, Agent $agent)
{
    // Validation des données de l'agent et des personnes à prévenir
    $validatedData = $request->validate([
        'nom' => 'nullable|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255|unique:agents,email,' . $agent->id, // Ignorer l'email de l'agent actuel
        'telephone' => 'nullable|string|max:255|unique:agents,telephone,' . $agent->id, // Ignorer le téléphone de l'agent actuel
        'addresse' => 'nullable|string|max:255',
        'sexe' => 'nullable|string|max:255',
        'nationalite' => 'nullable|string|max:255',
        'taille' => 'nullable|string|max:255',
        'type_contrat' => 'nullable|string|max:255',
        'date_debut_contrat' => 'date|max:255',
        'date_fin_contrat' => 'date|max:255',
        'carte_identite' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'casier_judiciaire' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        'certificat_naissance' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        'certificat_medical' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        'permit_residence' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        // Validation des personnes à prévenir
        'personnes.*.nom' => 'nullable|string|max:255',
        'personnes.*.prenom' => 'nullable|string|max:255',
        'personnes.*.contact' => 'nullable|string|max:255',
        'personnes.*.profession' => 'nullable|string|max:255',
        'personnes.*.adresse' => 'nullable|string|max:255',
    ]);

    // Mettre à jour les informations de l'agent
    $agent->update($validatedData);

    // Gérer les fichiers
    if ($request->hasFile('carte_identite')) {
        $agent->carte_identite = $request->file('carte_identite')->store('documents/carte_identite');
    }

    if ($request->hasFile('passport_photo')) {
        $agent->passport_photo = $request->file('passport_photo')->store('documents/passport_photos');
    }

    if ($request->hasFile('casier_judiciaire')) {
        $agent->casier_judiciaire = $request->file('casier_judiciaire')->store('documents/casier_judiciaire');
    }

    if ($request->hasFile('certificat_naissance')) {
        $agent->certificat_naissance = $request->file('certificat_naissance')->store('documents/certificat_naissance');
    }

    if ($request->hasFile('certificat_medical')) {
        $agent->certificat_medical = $request->file('certificat_medical')->store('documents/certificat_medical');
    }

    if ($request->hasFile('permit_residence')) {
        $agent->permit_residence = $request->file('permit_residence')->store('documents/permit_residence');
    }

    // Mettre à jour les informations des personnes à prévenir
    foreach ($request->input('personnes', []) as $personneData) {
        // Vérifiez si 'id' est défini
        if (isset($personneData['id'])) {
            $personne = $agent->personneaprevenir()->find($personneData['id']) ?? new PersonneAPrevenir();
        } else {
            // Si 'id' n'est pas défini, créez une nouvelle instance
            $personne = new PersonneAPrevenir();
        }

        // Remplir les données de la personne
        $personne->fill([
            'nom' => $personneData['nom'],
            'prenom' => $personneData['prenom'],
            'contact' => $personneData['contact'],
            'profession' => $personneData['profession'] ?? null,
            'adresse' => $personneData['adresse'] ?? null,
        ]);

        // Associer la personne à l'agent
        $personne->agent_id = $agent->id;
        $personne->save();
    }

    // Sauvegarder les modifications de l'agent
    $agent->save();

    return redirect()->route('admin.agents.index')->with('success', 'Agent mis à jour avec succès.');
}


    // Supprimer un agent de la base de donnée
    public function destroy(Agent $agent){
        $agent->delete();
        return redirect()->route('admin.agents.index')->with('success', 'Agent supprimé avec succès.');
    }
}
