<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\View\View;

class VacationListController extends Controller
{
    /**
     * Display list of all vacations by demands
     */
    public function index(): View
    {
        $demandes = Demande::with('vacations')
            ->whereHas('vacations')
            ->get();

        $vacationsList = [];

        foreach ($demandes as $demande) {
            if (!$demande->vacations->count()) {
                continue;
            }

            $montantParVacation = $demande->montant_exploitation / $demande->vacations->count();

            $realVacations = $demande->vacations->where('vacation_type', 'reel')->values();
            $virtualVacations = $demande->vacations->where('vacation_type', 'virtuel')->values();

            $demandeData = [
                'demande' => $demande,
                'montant_par_vacation' => $montantParVacation,
                'vacations' => $demande->vacations,
                'realVacations' => $realVacations,
                'virtualVacations' => $virtualVacations,
            ];

            $vacationsList[] = $demandeData;
        }

        return view('admin.vacations.list', compact('vacationsList'));
    }

    /**
     * Display details of vacations for a specific demand
     */
    public function show($demandeId): View
    {
        $demande = Demande::with('vacations')->findOrFail($demandeId);

        if (!$demande->vacations->count()) {
            return back()->with('error', 'Cette demande n\'a pas de vacations.');
        }

        $montantParVacation = $demande->montant_exploitation / $demande->vacations->count();
        $realVacations = $demande->vacations->where('vacation_type', 'reel')->values();
        $virtualVacations = $demande->vacations->where('vacation_type', 'virtuel')->values();

        return view('admin.vacations.detail-demand', compact(
            'demande',
            'montantParVacation',
            'realVacations',
            'virtualVacations'
        ));
    }
}
