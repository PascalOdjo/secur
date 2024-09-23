<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\Agent;
use Carbon\Carbon;
use App\Models\site;
use App\Models\pointage;

class VacationController extends Controller
{
    public function index()
    {
        $vacations = Vacation::with(['agent1', 'agent2'])->get(); // Récupère les vacations avec les agents assignés
        return view('admin.vacations.index', compact('vacations'));

    }

    public function create()
    {
        $agents = Agent::all(); // Récupération de tous les agents
        $sites = Site::all();   // Récupération de tous les sites

        return view('admin.vacations.create', compact('agents', 'sites')); // Passer les agents et les sites à la vue
    }

    public function store(Request $request){
        try{
            $validated = $request->validate([
            'type_vacation'=>'required|in:sys_12,sys_08',
            'shift'=>'required|in:jour,apres_midi,nuit,journee_entiere,evenementiel',
            'status'=>'required|in:cree,en_cours,affecte,termine',
            'start_time' => 'required|date',
            'end_time' => 'required|date',    
            'agent_1_id' => 'required|exists:agents,id',
            'agent_2_id' => 'required|exists:agents,id',
            'site_id' => 'nullable|exists:sites,id', // validation du site
        ]);

        // Vérification si l'agent 1 est déjà affecté à une vacation
        $agent1Occupied = Vacation::where('agent_1_id', $validated['agent_1_id'])
        ->orWhere('agent_2_id', $validated['agent_1_id'])
        ->where('start_time', '<=', $validated['end_time'])
        ->where('end_time', '>=', $validated['start_time'])
        ->exists();

        // Vérification si l'agent 2 est déjà affecté à une vacation
        $agent2Occupied = Vacation::where('agent_1_id', $validated['agent_2_id'])
        ->orWhere('agent_2_id', $validated['agent_2_id'])
        ->where('start_time', '<=', $validated['end_time'])
        ->where('end_time', '>=', $validated['start_time'])
        ->exists();

        if ($agent1Occupied || $agent2Occupied) {
            return redirect()->back()->with('error', 'Un ou plusieurs agents sont déjà assignés à une vacation pendant cette période.');
        }

        $code_vacation = strtoupper(uniqid('VAC - ')); // génération de code unique pour la vacation

        $vacation = new Vacation([
            'code_vacation'=>$code_vacation,
            'type_vacation'=>$validated['type_vacation'],
            'shift'=>$validated['shift'],
            'status'=>$validated['status'],
            'start_time'=>$validated['start_time'],
            'end_time'=>$validated['end_time'],
            'agent_1_id' => $validated['agent_1_id'],
            'agent_2_id' => $validated['agent_2_id'],
            
            
        ]);

        // Mettre à jour le statut de la vacation selon le pointage
        // if ($validated['status'] === 'affecte') {
        //     $vacation->status = 'en_cours';
        // }

        $vacation->save();

        return redirect()->route('admin.vacations.index')->with('success', 'Vacation créée avec succès !');
        }catch(\Exception $e){
            return redirect()->route('admin.vacations.index')->with('error', 'Erreur lors de la création de la vacation : ' . $e->getMessage());
        }
    }

    public function show($id){
        $vacation = Vacation::find($id);
        return view('admin.vacations.show', compact('vacation'));
    }

    public function edit($id){
        $vacation = Vacation::findOrFail($id);
        // $sites = Site::all();
        $agents = Agent::all();
        return view('admin.vacations.edit', compact('vacation', 'agents'));
    }
    
    public function update(Request $request, $id)
{
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
