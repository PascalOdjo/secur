<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(){
        $agents = Agent::all();
        return view('admin.agents.index', compact('agents'));
    }

    // Afficher le formulaire pourcréer un nouvel agent
    public function create(){
        return view('admin.agents.create');
    }

    // pour enregistrer un nouvel agent dans la base de donnée
    public function store(Request $request){
        $request->validate([
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:agents',
            'telephone'=>'required|string|max:255|unique:agents',
            'adresse'=>'required|string|max:255',
            'sexe'=>'required|string|max:255',
            'nationalite'=>'required|string|max:255',
            'taille'=>'required|string|max:255',
            'type_contrat'=>'required|string|max:255',
            'date_debut_contrat'=>'date|max:255',
            'date_fin_contrat'=>'date|max:255',
            'carte_identite'=>'file|mimes:pdf,jpeg,png|max:2048',
            'passport_photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'casier_judiciaire'=>'file|mimes:pdf,jpeg,png|max:2048',
            'certificat_naissance'=>'file|mimes:pdf,jpeg,png|max:2048',
            'certificat_medical'=>'file|mimes:pdf,jpeg,png|max:2048',
            'permit_residence'=>'file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $agent = Agent::create($request->all());

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
    
        $agent->save();
    

        return redirect()->route('agents.index')->with('success', 'Agent créé avec succès !');
    }

    // pour afficher un agent spécifique
    public function show(Agent $agent){
        return view('admin.agents.show', compact('agent'));
    }

    // Afficher le formulaire pour editer un agent
    public function edit(Agent $agent){
        return view('admin.agents.edit', compact('agent'));
    }

    // pour mettre à jour un agent dans la base de donnée
    public function update(Request $request, Agent $agent){
        $request->validate([
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:agents',
            'telephone'=>'required|string|max:255|unique:agents',
            'adresse'=>'required|string|max:255',
            'sexe'=>'required|string|max:255',
            'nationalite'=>'required|string|max:255',
            'taille'=>'required|string|max:255',
            'type_contrat'=>'required|string|max:255',
            'date_debut_contrat'=>'date|max:255',
            'date_fin_contrat'=>'date|max:255',
            'carte_identite'=>'file|mimes:pdf,jpeg,png|max:2048',
            'passport_photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'casier_judiciaire'=>'file|mimes:pdf,jpeg,png|max:2048',
            'certificat_naissance'=>'file|mimes:pdf,jpeg,png|max:2048',
            'certificat_medical'=>'file|mimes:pdf,jpeg,png|max:2048',
            'permit_residence'=>'file|mimes:pdf,jpeg,png|max:2048',
        ]);

        $agent->update($request->all());

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

        $agent->save();

        return redirect()->route('admin.agents.index')->with('success', 'Agent mise à jour avec succès.');
    }

    // Supprimer un agent de la base de donnée
    public function destroy(Agent $agent){
        $agent->delete();
        return redirect()->route('admin.agents.index')->with('success', 'Agent supprimé avec succès.');
    }
}
