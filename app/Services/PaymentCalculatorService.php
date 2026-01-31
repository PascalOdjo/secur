<?php

namespace App\Services;

class PaymentCalculatorService
{
    /**
     * Valeur par défaut d'un agent en unités abstraites
     */
    const AGENT_VALUE = 128;

    /**
     * Nombre minimum d'agents pour une demande valide
     */
    const MIN_AGENTS = 4;

    /**
     * Valeur d'un agent en CFA francs
     */
    const AGENT_VALUE_IN_CFA = 105000;

    /**
     * Nombre de vacations par agent par mois (16 vacations)
     */
    const VACATIONS_PER_MONTH = 16;

    /**
     * Validate if the number of agents is sufficient
     *
     * @param int $nombreAgents
     * @return bool
     */
    public function isValidNumberOfAgents(int $nombreAgents): bool
    {
        return $nombreAgents >= self::MIN_AGENTS;
    }

    /**
     * Calculate the total value for a demand
     * 
     * Total Value = nombre_agents * AGENT_VALUE
     * Example: 4 agents * 128 = 512
     *
     * @param int $nombreAgents
     * @return float
     */
    public function calculateTotalValue(int $nombreAgents): float
    {
        return $nombreAgents * self::AGENT_VALUE;
    }

    /**
     * Split the total value into exploitation and treasury
     * Each gets 50% of total value
     *
     * @param float $totalValue
     * @return array ['exploitation' => float, 'tresorerie' => float]
     */
    public function splitValue(float $totalValue): array
    {
        $half = $totalValue / 2;
        return [
            'exploitation' => $half,
            'tresorerie' => $half,
        ];
    }

    /**
     * Calculate contract breakdown from exploitation value
     * 
     * Logic:
     * - 256 / 2 = 128
     * - 128 / 2 = 64 contracts
     * - 64 / 4 = 16
     * - 16 / 16 = 1 contract
     * - 1 / 4 = 1 real contract + 3 virtual contracts
     *
     * @param float $exploitationValue
     * @return array
     */
    public function calculateContractBreakdown(float $exploitationValue): array
    {
        $step1 = $exploitationValue / 2;  // 256 / 2 = 128
        $step2 = $step1 / 2;               // 128 / 2 = 64 (contracts)
        $step3 = $step2 / 4;               // 64 / 4 = 16
        $step4 = $step3 / 16;              // 16 / 16 = 1 (contract)

        $realContracts = 1;
        $virtualContracts = 3;
        $totalContracts = $realContracts + $virtualContracts;

        // Price per contract
        $pricePerContract = $step4 / $totalContracts;

        return [
            'step1' => $step1,              // 128
            'step2' => $step2,              // 64 (contracts count)
            'step3' => $step3,              // 16
            'step4' => $step4,              // 1 (base contract value)
            'real_contracts' => $realContracts,
            'virtual_contracts' => $virtualContracts,
            'total_contracts' => $totalContracts,
            'price_per_contract' => $pricePerContract,
        ];
    }

    /**
     * Calculate CFA equivalent for a unit value
     * 1 agent (128 units) = 105,000 CFA
     * Therefore: 1 unit = 105,000 / 128 = 820.3125 CFA
     *
     * @param float $unitValue
     * @return float
     */
    public function calculateCFAFromUnit(float $unitValue): float
    {
        $cfaPerUnit = self::AGENT_VALUE_IN_CFA / self::AGENT_VALUE;
        return $unitValue * $cfaPerUnit;
    }

    /**
     * Calculate unit value from CFA
     *
     * @param float $cfaValue
     * @return float
     */
    public function calculateUnitFromCFA(float $cfaValue): float
    {
        $cfaPerUnit = self::AGENT_VALUE_IN_CFA / self::AGENT_VALUE;
        return $cfaValue / $cfaPerUnit;
    }

    /**
     * Calculate complete payment breakdown for a demand
     *
     * @param int $nombreAgents
     * @param float $montantFourni (optional) - Custom amount in CFA. If null, calculated from agent count
     * @return array
     */
    public function calculateCompletePayment(int $nombreAgents, ?float $montantFourni = null): array
    {
        // Validate agent count
        if (!$this->isValidNumberOfAgents($nombreAgents)) {
            return [
                'valid' => false,
                'error' => "Minimum " . self::MIN_AGENTS . " agents required. Provided: {$nombreAgents}",
            ];
        }

        // If montantFourni is provided, use it as the base for all calculations
        if ($montantFourni !== null) {
            // Convert the provided CFA amount to unit value
            $totalValue = $this->calculateUnitFromCFA($montantFourni);
        } else {
            // Calculate total value from agent count
            $totalValue = $this->calculateTotalValue($nombreAgents);
        }

        // Split into exploitation and treasury (50/50)
        $split = $this->splitValue($totalValue);
        $exploitationValue = $split['exploitation'];
        $tresorerieValue = $split['tresorerie'];

        // Calculate contract breakdown
        $contractBreakdown = $this->calculateContractBreakdown($exploitationValue);

        // Convert to CFA - if montantFourni was provided, use it, otherwise calculate
        $montantCFA = $montantFourni ?? $this->calculateCFAFromUnit($totalValue);
        $exploitationCFA = $this->calculateCFAFromUnit($exploitationValue);
        $tresorerieCFA = $this->calculateCFAFromUnit($tresorerieValue);
        $pricePerContractCFA = $this->calculateCFAFromUnit($contractBreakdown['price_per_contract']);

        return [
            'valid' => true,
            'nombre_agents' => $nombreAgents,
            'total_value' => $totalValue,
            'total_cfa' => $montantCFA,
            'exploitation_value' => $exploitationValue,
            'exploitation_cfa' => $exploitationCFA,
            'tresorerie_value' => $tresorerieValue,
            'tresorerie_cfa' => $tresorerieCFA,
            'contract_breakdown' => $contractBreakdown,
            'price_per_contract_cfa' => $pricePerContractCFA,
            'vacations_per_month' => self::VACATIONS_PER_MONTH,
            'vacation_code_groups' => ['K', 'L', 'M', 'N'], // 4 groups for 4 vacations per agent
        ];
    }

    /**
     * Calcule la paie journalière d'un agent basée sur la valeur d'exploitation.
     * (Kept for backward compatibility)
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
