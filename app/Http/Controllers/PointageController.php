<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Site;
use App\Models\pointage;

class PointageController extends Controller
{

    public function index(){
        $pointages = Pointage::with(['vacation', 'site'])->get();
        return view('admin.pointages.index', compact('pointages'));
    }

    public function create(){
        
        $sites = Site::all();
        $vacations = Vacation::all();
        return view('admin.pointages.create', compact('sites', 'vacations'));
    }
    public function store(Request $request)
    {
    // Valider les données
    $request->validate([
        'vacation_id' => 'required|exists:vacations,id',
        'site_id' => 'required|exists:sites,id', // Rendre le site optionnel
    ]);

    // Récupérer la vacation
    $vacation = Vacation::findOrFail($request->vacation_id);

    // Créer le pointage avec les données
    $pointage = new Pointage([
        'vacation_id' => $vacation->id,
        'site_id' => $request->site_id,
        'debut_vacation' => $vacation->start_time,
        'fin_vacation' => $vacation->end_time,
        'status' => 'affecte', // Définir le statut comme "affecté"
    ]);

    // Enregistrer le pointage dans la base de données
    $pointage->save();

    // Redirection après l'enregistrement du pointage
    return redirect()->route('admin.pointages.index')->with('success', 'Pointage effectué avec succès.');
    }

    // Affecter une vacation
    public function affecter($vacationId)
    {
        $vacation = Vacation::findOrFail($vacationId);
        $vacation->status = 'affecte';
        $vacation->save();

        return redirect()->back()->with('success', 'Vacation affectée avec succès.');
    }

    // Mettre une vacation en cours
    public function enCours($vacationId)
    {
        $vacation = Vacation::findOrFail($vacationId);

        // Vérifier si la vacation doit commencer maintenant
        if (Carbon::now()->between($vacation->start_time, $vacation->end_time)) {
            $vacation->status = 'en_cours';
            $vacation->save();

            return redirect()->back()->with('success', 'Vacation en cours.');
        } else {
            return redirect()->back()->with('error', 'La vacation n’est pas encore prête à être mise en cours.');
        }
    }

    // Terminer une vacation
    public function terminer($vacationId)
    {
        $vacation = Vacation::findOrFail($vacationId);

        // Vérifier si la vacation est terminée
        if (Carbon::now()->gt($vacation->end_time)) {
            $vacation->status = 'termine';
            $vacation->save();

            return redirect()->back()->with('success', 'Vacation terminée avec succès.');
        } else {
            return redirect()->back()->with('error', 'La vacation n’est pas encore terminée.');
        }
    }

    public function show($id)
{
    // Récupérer le pointage avec ses relations
    $pointages = Pointage::with('vacation', 'site')->findOrFail($id);

    // Récupérer toutes les vacations et sites pour les afficher dans les sélections
    $vacations = Vacation::all();
    $sites = Site::all();

    return view('admin.pointages.show', compact('pointages', 'vacations', 'sites'));
}


    public function update(Request $request, $id)
{
    // Valider les données
    $request->validate([
        'vacation_id' => 'required|exists:vacations,id',
        'site_id' => 'nullable|exists:sites,id', // Site optionnel
    ]);

    // Récupérer le pointage
    $pointage = Pointage::findOrFail($id);

    // Mettre à jour les informations
    $pointage->vacation_id = $request->vacation_id;
    $pointage->site_id = $request->site_id;
    $pointage->status = $request->status; // Si vous souhaitez permettre de modifier le statut
    $pointage->save();

    // Rediriger avec un message de succès
    return redirect()->route('admin.pointages.index')->with('success', 'Pointage mis à jour avec succès.');
}

    public function destroy($id)
    {
        $pointage = Pointage::findOrFail($id);
        $pointage->delete();
        return redirect()->back()->with('success', 'Pointage supprimé avec succès.');

    }

public function edit($id)
{
    $pointages = Pointage::with('vacation', 'site')->findOrFail($id);
    $vacations = Vacation::all();
    $sites = Site::all();
    return view('admin.pointages.edit', compact('pointages', 'vacations', 'sites'));
}
}