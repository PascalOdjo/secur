<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Agent;
use App\Models\Vacation;

/**
 * AgentPaymentService
 * 
 * Service principal pour la gestion des paiements d'agents
 * Basé sur:
 * - Montant pour 4 agents minimum
 * - Split 50/50 exploitation/trésorerie
 * - Salaire = exploitation / nombre_agents
 * - 16 vacations (A, B, C, D) par agent
 */
class AgentPaymentService
{
    protected PaymentCalculatorService $paymentCalculator;
    protected VacationCodeGenerator $codeGenerator;

    public function __construct()
    {
        $this->paymentCalculator = new PaymentCalculatorService();
        $this->codeGenerator = new VacationCodeGenerator();
    }

    /**
     * Traiter une demande complète
     * 
     * @param Demande $demande
     * @return array
     */
    public function processDemande(Demande $demande): array
    {
        if (!$demande->nombre_agents || !$demande->montant) {
            return [
                'success' => false,
                'message' => 'Nombre d\'agents et montant requis',
            ];
        }

        try {
            // Calculer les paiements
            $calculation = $this->paymentCalculator->calculateComplete(
                $demande->nombre_agents,
                $demande->montant
            );

            if (!$calculation['valid']) {
                return [
                    'success' => false,
                    'message' => $calculation['error'],
                ];
            }

            // Mettre à jour la demande
            $demande->update([
                'montant_brut' => $calculation['montant_total'],
                'montant_exploitation' => $calculation['exploitation'],
                'montant_tresorerie' => $calculation['tresorerie'],
                'salaire_par_agent' => $calculation['salaire_par_agent'],
                'montant_par_vacation' => $calculation['montant_par_vacation'],
            ]);

            return [
                'success' => true,
                'demande' => $demande->fresh(),
                'calculation' => $calculation,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Assigner les codes de vacation
     * 
     * @param Demande $demande
     * @return array
     */
    public function assignVacationCodes(Demande $demande): array
    {
        if (!$demande->site) {
            return [
                'success' => false,
                'message' => 'Site requis pour générer les codes',
            ];
        }

        $vacations = $demande->vacations ?? collect();

        if ($vacations->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Pas de vacations à traiter',
            ];
        }

        $updatedCount = 0;
        $groups = $this->codeGenerator->getGroups();

        foreach ($vacations as $index => $vacation) {
            // Déterminer le groupe (K, L, M, N)
            $groupIndex = ($index % count($groups));
            $group = $groups[$groupIndex];

            // Déterminer la position dans le groupe (0-3)
            $subPairs = $this->codeGenerator->getSubPairs();
            $positionInGroup = ($index % 4);
            $subPair = $subPairs[$positionInGroup];

            // Déterminer le type (réel ou virtuel)
            $isReal = ($positionInGroup === 0);

            // Générer le code
            $isNight = strtolower($vacation->shift ?? 'jour') === 'nuit';
            if ($demande->site) {
                $code = $this->codeGenerator->generateSingleCode(
                    $demande->site,
                    $group,
                    $subPair,
                    $isNight
                );

                $vacation->update([
                    'code_vacation' => $code,
                    'vacation_type' => $isReal ? 'reel' : 'virtuel',
                ]);

                $updatedCount++;
            }
        }

        return [
            'success' => true,
            'message' => "$updatedCount vacations traitées",
            'updated_count' => $updatedCount,
        ];
    }

    /**
     * Obtenir le résumé des vacations
     * 
     * @param Demande $demande
     * @return array
     */
    public function getVacationSummary(Demande $demande): array
    {
        $vacations = $demande->vacations ?? collect();
        $realCount = $vacations->where('vacation_type', 'reel')->count();
        $virtualCount = $vacations->where('vacation_type', 'virtuel')->count();

        return [
            'total_vacations' => $vacations->count(),
            'real_vacations' => $realCount,
            'virtual_vacations' => $virtualCount,
            'salaire_par_agent' => $demande->salaire_par_agent,
            'montant_par_vacation' => $demande->montant_par_vacation,
            'nombre_agents' => $demande->nombre_agents,
        ];
    }

    /**
     * Obtenir le détail des paiements
     * 
     * @param Demande $demande
     * @return array
     */
    public function getPaymentBreakdown(Demande $demande): array
    {
        return [
            'nombre_agents' => $demande->nombre_agents,
            'montant_enregistrement' => $demande->montant,
            'montant_total' => $demande->montant_brut,
            'exploitation' => $demande->montant_exploitation,
            'tresorerie' => $demande->montant_tresorerie,
            'salaire_par_agent' => $demande->salaire_par_agent,
            'montant_par_vacation' => $demande->montant_par_vacation,
            'vacations_reelles_par_agent' => 16,
            'vacations_virtuels_par_agent' => 48,
            'total_vacations_par_agent' => 64,
        ];
    }

    /**
     * Obtenir le détail pour les agents
     * 
     * @param Demande $demande
     * @return array
     */
    public function getAgentDetails(Demande $demande): array
    {
        if (!$demande->salaire_par_agent) {
            return [];
        }

        $vacationsPerType = $this->paymentCalculator->calculateVacationsPerType(
            $demande->salaire_par_agent
        );

        return [
            'salaire_total' => $demande->salaire_par_agent,
            '16A_reelles' => $vacationsPerType['16A_reelles'],
            '16B_virtuels' => $vacationsPerType['16B_virtuels'],
            '16C_virtuels' => $vacationsPerType['16C_virtuels'],
            '16D_virtuels' => $vacationsPerType['16D_virtuels'],
            'total' => $demande->salaire_par_agent,
        ];
    }
}
