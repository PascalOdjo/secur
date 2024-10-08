<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\Agent;
use Carbon\Carbon;
use App\Models\site;
use App\Models\pointage;
use App\Services\VacationCodeGenerator;

class VacationController extends Controller
{
    public function index()
    {
    // Récupère les vacations avec les agents assignés et le site
    $vacations = Vacation::with(['agent1', 'agent2', 'site'])->paginate(5);

    return view('admin.vacations.index', compact('vacations'));
    }


    public function create()
{
    // Récupération de tous les agents disponibles
    $agents = Agent::all();
    $agentsDejaAffectes = Vacation::where('status', 'en_cours')
        ->orWhere('status', 'affecte')  
        ->pluck('agent_1_id') // Récupérer uniquement agent_1_id
        ->merge(Vacation::where('status', 'en_cours')->orWhere('status', 'affecte')->pluck('agent_2_id')) // Ajouter agent_2_id
        ->unique() // Éliminer les doublons
        ->toArray();

    // Liste des agents disponibles (ceux qui ne sont pas dans $agentsDejaAffectes)
    $agentsDisponibles = Agent::whereNotIn('id', $agentsDejaAffectes)->get();
    // Récupération de tous les sites
    $sites = Site::all();

    return view('admin.vacations.create', compact('agents', 'sites', 'agentsDisponibles')); // Passer les agents et les sites à la vue
}

public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'type_vacation' => 'required|in:sys_12,sys_08',
            'shift' => 'required|in:jour,nuit,journee_entiere',
            'status' => 'required|in:cree,en_cours,affecte,termine',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'agent_1_id' => 'required|exists:agents,id',
            'agent_2_id' => 'required|exists:agents,id',
            'site_id' => 'nullable|exists:sites,id',
        ]);

        $generator = new VacationCodeGenerator();

        $vacationCodes = [];
        switch ($validated['shift']) {
            case 'jour':
                $vacationCodes = array_merge(
                    $generator->generateVacationCodes($validated['agent_1_id'], false),
                    $generator->generateVacationCodes($validated['agent_2_id'], false)
                );
                break;
            case 'nuit':
                $vacationCodes = array_merge(
                    $generator->generateVacationCodes($validated['agent_1_id'], true),
                    $generator->generateVacationCodes($validated['agent_2_id'], true)
                );
                break;
            case 'journee_entiere':
                $vacationCodes = array_merge(
                    $generator->generateVacationCodes($validated['agent_1_id'], false, true), // Day agents
                    $generator->generateVacationCodes($validated['agent_2_id'], true, true)   // Night agents
                );
                break;
        }

        $vacation = Vacation::create([
            'code_vacation' => implode('-', $vacationCodes),
            'type_vacation' => $validated['type_vacation'],
            'shift' => $validated['shift'],
            'status' => $validated['status'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'agent_1_id' => $validated['agent_1_id'],
            'agent_2_id' => $validated['agent_2_id'],
            'site_id' => $validated['site_id'],
        ]);

        return redirect()->route('admin.vacations.index')->with('success', 'Vacation créée avec succès !');
    } catch (\Exception $e) {
        return redirect()->route('admin.vacations.index')->with('error', 'Erreur lors de la création de la vacation : ' . $e->getMessage());
    }
}


    public function show($id){
        $vacation = Vacation::find($id);
        return view('admin.vacations.show', compact('vacation'));
    }

    public function edit($id)
{
    $vacation = Vacation::findOrFail($id);
    
    // Récupération de tous les agents disponibles
    $agents = Agent::all();
    // Récupération de tous les sites
    $sites = Site::all();
    // Récupération des agents déjà affectés
    $agentsDejaAffectes = Vacation::where('status', 'en_cours')
        ->orWhere('status', 'affecte')  
        ->pluck('agent_1_id')
        ->merge(Vacation::where('status', 'en_cours')->orWhere('status', 'affecte')->pluck('agent_2_id'))
        ->unique()
        ->toArray();

    // Liste des agents disponibles (ceux qui ne sont pas dans $agentsDejaAffectes)
    $agentsDisponibles = Agent::whereNotIn('id', $agentsDejaAffectes)->get();

    return view('admin.vacations.edit', compact('vacation', 'agents', 'agentsDisponibles', 'sites'));
}
    
    public function update(Request $request, $id)
{
    $agents = Agent::all();
    try {
        // validation des données
        $request->validate([
            'type_vacation' => 'required|in:sys_12,sys_08',
            'shift' => 'required|in:jour,apres_midi,nuit,journee_entiere,evenementiel',
            'status' => 'required|in:cree,en_cours,affecte,termine',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'agent_1_id' => 'required|exists:agents,id',
            'agent_2_id' => 'required|exists:agents,id',
            // 'site_id' => 'nullable|exists:sites,id',
        ]);

        // mise à jour de la vacation
        $vacation = Vacation::findOrFail($id);
        $vacation->fill($request->only([
            'type_vacation', 'shift', 'status', 'start_time', 'end_time', 
            'agent_1_id', 'agent_2_id', 'site_id'
        ]));

        // Mise à jour des agents
        $vacation->agent_1_id = $request->agent_1_id;
        $vacation->agent_2_id = $request->agent_2_id;

        // Enregistrement des modifications
        $vacation->save();

        return redirect()->route('admin.vacations.index')->with('success', 'Vacation mise à jour avec succès !');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // En cas d'erreur de validation, rediriger avec les erreurs
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // En cas d'erreur, rediriger avec un message d'erreur
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la vacation: ' . $e->getMessage())->withInput();
    }
}



    public function destroy($id){
        $vacation = Vacation::find($id);
        $vacation->delete();
        return redirect()->route('admin.vacations.index')->with('success', 'Vacation supprimée avec succès !');
    }

    public function affecterVacation(Request $request, $id){

        $vacation = Vacation::findOrFail($id);
        // Validation des données
        $request->validate([
            'site_id' => 'required|exists:sites,id',
        ]);

        // Créer le pointage
        $pointage = new Pointage([
            'vacation_id' => $vacation->id,
            'site_id' => $request->input('site_id'),
            'status' => 'affecte',
            'debut_vacation' => $vacation->start_time,
            'fin_vacation' => $vacation->end_time,
        ]);

        // Mettre à jour le statut de la vacation
        $vacation->status = 'affecte';
        // Enregistrer le pointage
        $vacation->save();
        return redirect()->back()->with('success', 'Vacation affectée avec succès !');
    }

    // public function verifierStatus(){
    //     $vacationsEnCours = Vacation::where('status', 'affecte')
    //     ->where('start_time', '<=', Carbon::now())
    //     ->where('end_time', '>', Carbon::now())
    //     ->get();

    //     foreach ($vacationsEnCours as $vacation) {
    //         $vacation->status = 'en_cours';
    //         $vacation->save();
    //     }

    //     $vacationsTerminees = Vacation::where('status', 'en_cours')
    //     ->where('end_time', '<=', Carbon::now())
    //     ->get();

    //     foreach ($vacationsTerminees as $vacation) {
    //         $vacation->status = 'termine';
    //         $vacation->save();
    //     }
    // }

}