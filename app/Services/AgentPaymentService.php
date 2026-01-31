<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Agent;
use App\Models\AgentPayment;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * AgentPaymentService
 * 
 * Service for managing agent payments and vacation code assignments
 * Based on the new payment system:
 * - 1 agent = 128 units = 105,000 CFA francs
 * - Minimum 4 agents per demand (512 total units)
 * - Split: 50% exploitation, 50% treasury
 * - Exploitation breakdown creates real and virtual contracts
 * - 16 vacations per agent per month
 * - 4 groups (K, L, M, N) for vacation organization
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
     * Process payment for a demand
     * Calculates all payment breakdowns and returns detailed information
     *
     * @param Demande $demande
     * @return array
     */
    public function processDemande(Demande $demande): array
    {
        // Get or count agents
        $nombreAgents = $demande->nombre_agents ?? 0;
        $montantFourni = $demande->montant ?? null;

        // Calculate complete payment
        $payment = $this->paymentCalculator->calculateCompletePayment($nombreAgents, $montantFourni);

        if (!$payment['valid']) {
            return [
                'success' => false,
                'message' => $payment['error'],
            ];
        }

        // Update demande with calculated values
        $demande->update([
            'montant_brut' => $payment['total_cfa'],
            'montant_exploitation' => $payment['exploitation_cfa'],
            'montant_tresorerie' => $payment['tresorerie_cfa'],
            'valeur_base' => $montantFourni ?? $payment['total_value'], // Use provided montant directly as valeur_base when available
            'prix_par_agent' => $payment['price_per_contract_cfa'],
        ]);

        return [
            'success' => true,
            'demande' => $demande->fresh(),
            'payment' => $payment,
        ];
    }

    /**
     * Assign vacation codes to vacations for a demand
     * Each vacation gets a code based on its group and contract type
     *
     * @param Demande $demande
     * @return array
     */
    public function assignVacationCodes(Demande $demande): array
    {
        if (!$demande->site) {
            return [
                'success' => false,
                'message' => 'Demande does not have a site assigned',
            ];
        }

        $vacations = $demande->vacations;
        if ($vacations->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Demande does not have any vacations',
            ];
        }

        $updatedCount = 0;
        $groups = $this->codeGenerator->getGroups();
        $contractCounts = $this->codeGenerator->getContractCounts();

        foreach ($vacations as $index => $vacation) {
            // Determine group (K, L, M, N) based on vacation index mod 4
            $groupIndex = $index % count($groups);
            $group = $groups[$groupIndex];

            // Determine if this is a real or virtual contract
            // Based on the position in the 4-contract group
            $positionInGroup = ($index % $contractCounts['total']);
            $isReal = ($positionInGroup === 0);

            // Determine sub-pair (A for real, B/C/D for virtual)
            $subPair = $this->codeGenerator->getSubPairs()[$positionInGroup];

            // Check if night shift
            $isNight = strtolower($vacation->shift) === 'nuit' ||
                strtolower($vacation->shift) === 'nuit' ||
                strpos(strtolower($vacation->shift), 'nuit') !== false;

            // Generate code
            $code = $this->codeGenerator->generateSingleCode(
                $demande->site,
                $group,
                $subPair,
                $isNight
            );

            // Update vacation
            $vacation->update([
                'code_vacation' => $code,
                'vacation_type' => $isReal ? 'reel' : 'virtuel',
            ]);

            $updatedCount++;
        }

        return [
            'success' => true,
            'message' => "Vacation codes assigned to {$updatedCount} vacations",
            'updated_count' => $updatedCount,
        ];
    }

    /**
     * Get vacation distribution summary for a demand
     * Shows real contracts, virtual contracts, and monthly breakdown
     *
     * @param Demande $demande
     * @return array
     */
    public function getVacationSummary(Demande $demande): array
    {
        $vacations = $demande->vacations;
        $realCount = $vacations->where('vacation_type', 'reel')->count();
        $virtualCount = $vacations->where('vacation_type', 'virtuel')->count();

        // Calculate total contracts: 4 agents × 4 contracts per group = 16 contracts
        $totalContracts = $demande->nombre_agents * 4;

        // Option B: Each contract (real or virtual) costs 205 FCFA
        // This represents the cost per round performed by the agent
        $montantParVacation = 205; // Fixed amount per contract/round

        return [
            'total_vacations' => $vacations->count(),
            'real_vacations' => $realCount,
            'virtual_vacations' => $virtualCount,
            'total_contracts' => $totalContracts,
            'montant_exploitation' => $demande->montant_exploitation,
            'montant_par_vacation' => $montantParVacation,
            'total_montant_contracts' => $totalContracts * $montantParVacation,
            'vacations_per_month' => PaymentCalculatorService::VACATIONS_PER_MONTH,
            'agent_value_cfa' => PaymentCalculatorService::AGENT_VALUE_IN_CFA,
        ];
    }

    /**
     * Calculate agent payment for a specific period
     *
     * @param Agent $agent
     * @param int $month
     * @param int $year
     * @return array
     */
    public function calculateAgentMonthlyPayment(Agent $agent, int $month, int $year): array
    {
        // This would fetch all vacations for this agent in the given month
        // and calculate total payment based on real/virtual and amounts

        return [
            'agent_id' => $agent->id,
            'month' => $month,
            'year' => $year,
            // Payment calculation logic to be implemented
        ];
    }

    /**
     * Get payment breakdown for display
     *
     * @param Demande $demande
     * @return array
     */
    public function getPaymentBreakdown(Demande $demande): array
    {
        return [
            'agent_count' => $demande->nombre_agents,
            'agent_unit_value' => PaymentCalculatorService::AGENT_VALUE,
            'agent_cfa_value' => PaymentCalculatorService::AGENT_VALUE_IN_CFA,
            'total_units' => $demande->valeur_base ?? 0,
            'total_cfa' => $demande->montant_brut ?? 0,
            'exploitation_units' => ($demande->valeur_base ?? 0) / 2,
            'exploitation_cfa' => $demande->montant_exploitation ?? 0,
            'tresorerie_units' => ($demande->valeur_base ?? 0) / 2,
            'tresorerie_cfa' => $demande->montant_tresorerie ?? 0,
            'price_per_contract_cfa' => $demande->prix_par_agent ?? 0,
            'vacations_per_month' => PaymentCalculatorService::VACATIONS_PER_MONTH,
            'vacation_groups' => $this->codeGenerator->getGroups(),
            'real_contracts_per_group' => 1,
            'virtual_contracts_per_group' => 3,
        ];
    }

    /**
     * Generate AgentPayment rows for a demande immediately.
     * This mirrors the logic used in the scheduled `ProcessDailyPayments` command
     * but runs on-demand so the dashboard reflects the new demande right away.
     *
     * @param Demande $demande
     * @return array Summary of created payments
     */
    public function generatePaymentsForDemande(Demande $demande): array
    {
        $created = 0;

        $vacations = $demande->vacations;
        if ($vacations->isEmpty()) {
            return ['success' => false, 'message' => 'No vacations for demande', 'created' => 0];
        }

        $contractStart = Carbon::parse($demande->start_date)->startOfDay();
        $contractEnd = Carbon::parse($demande->end_date)->startOfDay();
        $today = Carbon::now()->startOfDay();

        $targetEndDate = $today->lt($contractEnd) ? $today : $contractEnd;

        $totalVacationsForDemande = $vacations->count();
        if ($totalVacationsForDemande <= 0 || !$demande->montant_exploitation) {
            return ['success' => false, 'message' => 'Invalid demande data', 'created' => 0];
        }

        $montantPerVacation = $demande->montant_exploitation / $totalVacationsForDemande;

        foreach ($vacations as $vacation) {
            $agentIds = array_filter([$vacation->agent_1_id, $vacation->agent_2_id]);
            $numberOfAgents = count($agentIds);

            if ($numberOfAgents === 0) {
                continue;
            }

            // Determine days to use: from contract start to target end (today or contract end)
            $daysToUse = $contractStart->diffInDays($targetEndDate) + 1;
            if ($daysToUse <= 0) {
                continue;
            }

            $dailyPaymentPerAgent = $montantPerVacation / $daysToUse / $numberOfAgents;

            foreach ($agentIds as $agentId) {
                // start from contract start (no previous payments since demand is new)
                $cursor = $contractStart->copy();
                while ($cursor->lte($targetEndDate)) {
                    $dateString = $cursor->toDateString();

                    $exists = AgentPayment::where('vacation_id', $vacation->id)
                        ->where('agent_id', $agentId)
                        ->whereDate('date', $dateString)
                        ->exists();

                    if (!$exists) {
                        try {
                            AgentPayment::create([
                                'agent_id' => $agentId,
                                'vacation_id' => $vacation->id,
                                'date' => $dateString,
                                'amount' => $dailyPaymentPerAgent,
                                'status' => 'pending',
                            ]);
                            $created++;
                        } catch (\Exception $e) {
                            Log::error('Error creating AgentPayment for demande ' . $demande->id . ': ' . $e->getMessage());
                        }
                    }

                    $cursor->addDay();
                }
            }
        }

        return ['success' => true, 'message' => 'Payments generated', 'created' => $created];
    }
}
