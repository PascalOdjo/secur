<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Demande;
use App\Models\Vacation;
use Carbon\Carbon;

class ContractCalculationService
{
    const VALEUR_BASE = 128;
    const PRIX_PAR_AGENT = 1015;
    const MONTANT_MINIMUM = 512;
    const VACATIONS_PAR_AGENT = 4; // 1 réelle + 3 virtuelles
    const VACATIONS_REELS = 1;
    const VACATIONS_VIRTUELS = 3;

    /**
     * Calculer les montants du contrat
     */
    public function calculateContractAmounts($nombreAgents, $startDate = null, $endDate = null)
    {
        // Valeur du contrat = nombre_agents × 128
        $valeurContrat = $nombreAgents * self::VALEUR_BASE;

        // Montant du contrat = valeur_contrat × 1015
        $montantBrut = $valeurContrat * self::PRIX_PAR_AGENT;

        // Division 50/50
        $montantExploitation = $montantBrut / 2;
        $montantTresorerie = $montantBrut / 2;

        // Validation: La VALEUR du contrat doit être >= 512
        $statusValidation = $valeurContrat >= self::MONTANT_MINIMUM ? 'validé' : 'en_attente';

        // Montant par agent en exploitation
        $montantParAgentExploitation = $nombreAgents > 0 ? $montantExploitation / $nombreAgents : 0;

        // Montant par vacation (exploitation divisée en 16 vacations par agent)
        $montantParVacation = $nombreAgents > 0 ? $montantParAgentExploitation / self::VACATIONS_PAR_AGENT : 0;

        return [
            'valeur_contrat' => $valeurContrat,
            'montant_brut' => $montantBrut,
            'montant_exploitation' => $montantExploitation,
            'montant_tresorerie' => $montantTresorerie,
            'status_validation' => $statusValidation,
            'montant_par_agent_exploitation' => $montantParAgentExploitation,
            'montant_par_vacation' => $montantParVacation,
            'nombre_vacations_total' => $nombreAgents * self::VACATIONS_PAR_AGENT,
        ];
    }

    /**
     * Créer les vacations automatiquement (1 réelle + 3 virtuelles par agent)
     */
    public function createVacationsForDemande(Demande $demande)
    {
        // Supprimer les anciennes vacations si elles existent
        Vacation::where('demande_id', $demande->id)->delete();

        $nombreAgents = $demande->nombre_agents;
        $startDate = Carbon::parse($demande->start_date);
        $endDate = Carbon::parse($demande->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Récupérer les agents (les agents les plus anciens ou les premiers)
        $agents = Agent::limit($nombreAgents)->get();
        $agentIds = $agents->pluck('id')->toArray();

        if (count($agentIds) < 2) {
            // Besoin d'au moins 2 agents par vacation
            $agentIds = array_pad($agentIds, 2, $agentIds[0] ?? null);
        }

        // Créer les vacations (1 réelle + 3 virtuelles PER AGENT)
        $vacationNumber = 1;

        // 1 vacation RÉELLE pour TOUS les agents ensemble (couvrant toute la période du contrat)
        $this->createVacation($demande, $startDate, $endDate, $vacationNumber, 'reel', $agentIds);
        $vacationNumber++;

        // 3 vacations VIRTUELLES pour TOUS les agents ensemble (sans dates)
        for ($i = 0; $i < self::VACATIONS_VIRTUELS; $i++) {
            $this->createVacation($demande, null, null, $vacationNumber, 'virtuel', $agentIds);
            $vacationNumber++;
        }
    }

    /**
     * Créer une seule vacation
     */
    private function createVacation(Demande $demande, $startDate, $endDate, $vacationNumber, $type, $agentIds)
    {
        $amounts = $this->calculateContractAmounts($demande->nombre_agents);
        $montantParVacation = $amounts['montant_par_vacation'];

        // Générer le code vacation (KA...ND)
        $code = $this->generateVacationCode($demande->id, $vacationNumber);

        $vacation = new Vacation([
            'demande_id' => $demande->id,
            'site_id' => $demande->site_id,
            'start_time' => $startDate,
            'end_time' => $endDate,
            'type_vacation' => $demande->type_vacation,
            'vacation_type' => $type,
            'code_vacation' => $code,
            'status' => 'affecte',
        ]);

        // Assigner 2 agents
        if (count($agentIds) >= 2) {
            $vacation->agent_1_id = $agentIds[0];
            $vacation->agent_2_id = $agentIds[1];
        } elseif (count($agentIds) == 1) {
            $vacation->agent_1_id = $agentIds[0];
            $vacation->agent_2_id = $agentIds[0];
        }

        $vacation->save();

        return $vacation;
    }

    /**
     * Générer un code vacation unique (KA...ND)
     */
    public function generateVacationCode($demandeId, $vacationNumber)
    {
        // Format: KA + demandeId + vacationNumber + ND
        // Exemple: KA0001001ND, KA0001002ND, etc.
        return sprintf('KA%04d%03dND', $demandeId, $vacationNumber);
    }
}
