<?php

namespace App\Services;

/**
 * PaymentCalculatorService
 * 
 * Nouveau système de paiement:
 * - Montant par agent à l'enregistrement
 * - Split 50/50 entre exploitation et trésorerie
 * - Salaire agent = exploitation / nombre_agents = montant / 2
 * - Les 16 vacations (A, B, C, D) constituent le salaire de l'agent
 * 
 * Exemple avec 4 agents à 105,000 CFA:
 * - Total: 4 × 105,000 = 420,000 CFA
 * - Exploitation: 420,000 / 2 = 210,000 CFA
 * - Salaire par agent: 210,000 / 4 = 52,500 CFA
 * - 16A (réelles) + 16B (virtuels) + 16C (virtuels) + 16D (virtuels) = 52,500 CFA
 */
class PaymentCalculatorService
{
    /**
     * Constantes
     */
    const MIN_AGENTS = 4;

    /**
     * Valider le nombre minimum d'agents
     */
    public function isValidNumberOfAgents(int $nombre): bool
    {
        return $nombre >= self::MIN_AGENTS;
    }

    /**
     * Calculer le montant total
     * 
     * @param int $nombreAgents
     * @param float $montantParAgent Montant d'enregistrement par agent
     * @return float
     */
    public function calculateTotalAmount(int $nombreAgents, float $montantParAgent): float
    {
        return $nombreAgents * $montantParAgent;
    }

    /**
     * Diviser en exploitation et trésorerie (50/50)
     * 
     * @param float $montantTotal
     * @return array
     */
    public function splitExploitationTresorerie(float $montantTotal): array
    {
        $exploitation = $montantTotal / 2;
        $tresorerie = $montantTotal / 2;

        return [
            'exploitation' => $exploitation,
            'tresorerie' => $tresorerie,
        ];
    }

    /**
     * Calculer le salaire par agent
     * 
     * Formula: Salaire = Exploitation / nombre_agents = Montant total / 2 / nombre_agents
     * 
     * @param int $nombreAgents
     * @param float $montantParAgent
     * @return float
     */
    public function calculateSalaireParAgent(int $nombreAgents, float $montantParAgent): float
    {
        // Le salaire est la moitié du montant d'enregistrement
        // Car exploitation = total / 2, et salaire = exploitation / nombre_agents
        // = (nombre_agents * montant) / 2 / nombre_agents
        // = montant / 2
        return $montantParAgent / 2;
    }

    /**
     * Calculer la répartition des vacations par type (A, B, C, D)
     * 
     * 16 vacations par agent par type
     * Salaire = 16A + 16B + 16C + 16D
     * 
     * @param float $salaireParAgent
     * @return array
     */
    public function calculateVacationsPerType(float $salaireParAgent): array
    {
        // Chaque type (A, B, C, D) a 16 vacations
        $montantPar16Vacations = $salaireParAgent / 4;

        return [
            '16A_reelles' => $montantPar16Vacations,  // 16 vacations réelles
            '16B_virtuels' => $montantPar16Vacations, // 16 vacations virtuels
            '16C_virtuels' => $montantPar16Vacations, // 16 vacations virtuels
            '16D_virtuels' => $montantPar16Vacations, // 16 vacations virtuels
            'total' => $salaireParAgent,
        ];
    }

    /**
     * Calculer le montant par vacation
     * 
     * @param float $salaireParAgent
     * @param int $vacationsParType 16 vacations
     * @return float
     */
    public function calculateMontantParVacation(float $salaireParAgent, int $vacationsParType = 16): float
    {
        return $salaireParAgent / $vacationsParType;
    }

    /**
     * Calcul complet pour un contrat
     * 
     * @param int $nombreAgents
     * @param float $montantParAgent
     * @return array
     */
    public function calculateComplete(int $nombreAgents, float $montantParAgent): array
    {
        // Validation
        if (!$this->isValidNumberOfAgents($nombreAgents)) {
            return [
                'valid' => false,
                'error' => "Minimum " . self::MIN_AGENTS . " agents required. Got: $nombreAgents",
            ];
        }

        // Montant total
        $montantTotal = $this->calculateTotalAmount($nombreAgents, $montantParAgent);

        // Split exploitation/trésorerie
        $split = $this->splitExploitationTresorerie($montantTotal);

        // Salaire par agent
        $salaireParAgent = $this->calculateSalaireParAgent($nombreAgents, $montantParAgent);

        // Répartition par type de vacation
        $vacationsPerType = $this->calculateVacationsPerType($salaireParAgent);

        // Montant par vacation
        $montantParVacation = $this->calculateMontantParVacation($salaireParAgent);

        return [
            'valid' => true,
            'nombre_agents' => $nombreAgents,
            'montant_par_agent_enregistrement' => $montantParAgent,
            'montant_total' => $montantTotal,
            'exploitation' => $split['exploitation'],
            'tresorerie' => $split['tresorerie'],
            'salaire_par_agent' => $salaireParAgent,
            'vacations_par_type' => $vacationsPerType,
            'montant_par_vacation' => $montantParVacation,
            'total_vacations_par_agent' => 64, // 16A + 16B + 16C + 16D
            'vacations_reelles_par_agent' => 16, // A
            'vacations_virtuels_par_agent' => 48, // B + C + D (16 chaque)
        ];
    }

    /**
     * Calcul du paiement journalier (backward compatibility)
     *
     * @param float $exploitation
     * @return array
     */
    public function calculateDailyAgentPay(float $exploitation): array
    {
        $halfExploitation = $exploitation / 2;
        $squadBase = $halfExploitation / 4;
        $dailySquadValue = $squadBase / 16;
        $finalAgentPay = $dailySquadValue / 4;

        return [
            'exploitation' => $exploitation,
            'half_exploitation' => $halfExploitation,
            'squad_base' => $squadBase,
            'daily_squad_value' => $dailySquadValue,
            'final_agent_pay' => $finalAgentPay,
        ];
    }
}
