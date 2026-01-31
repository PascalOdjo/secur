<?php

namespace App\Services;

use App\Models\Demande;
use Illuminate\Support\Collection;

/**
 * ContractGeneratorService
 * 
 * Génère les contrats (réels et virtuels) basés sur les demandes
 * Chaque agent = 128 unités
 * 4 agents minimum = 512 unités
 * Exploitation = 50% = 256 unités pour 4 agents
 * 256 / 64 = 4 contrats réels
 * Chaque contrat réel a 3 contrats virtuels
 * Total = 4 × 4 = 16 contrats par demande
 */
class ContractGeneratorService
{
    protected VacationCodeGenerator $codeGenerator;

    public function __construct()
    {
        $this->codeGenerator = new VacationCodeGenerator();
    }

    /**
     * Generate all contracts (real and virtual) for a demand
     * Maps existing vacations to real contracts (A subgroup)
     * 
     * @param Demande $demande
     * @return Collection of contracts with vacation data
     */
    public function generateContractsWithVacations(Demande $demande): Collection
    {
        $groups = $this->codeGenerator->getGroups(); // ['K', 'L', 'M', 'N']
        $subPairs = $this->codeGenerator->getSubPairs(); // ['A', 'B', 'C', 'D']

        // Get existing vacations (should be 4 for 4 agents)
        $vacations = $demande->vacations->load('agent1', 'agent2');

        // Calculate number of contracts: 4 real + 12 virtual = 16 total per 4 agents
        $realContracts = intdiv($demande->nombre_agents, 1); // 4 agents = 4 real contracts
        $totalContracts = $realContracts * 4; // 4 real × 4 (1 real + 3 virtual per group) = 16

        $contracts = collect();
        $vacationIndex = 0;

        // Generate contracts for each group
        for ($i = 0; $i < $totalContracts; $i++) {
            // Determine group: each group has 4 contracts (0-3=K, 4-7=L, 8-11=M, 12-15=N)
            $groupIndex = intdiv($i, 4);
            $group = $groups[$groupIndex % count($groups)];

            // Position within group (0=A real, 1-3=B,C,D virtual)
            $positionInGroup = $i % 4;
            $subPair = $subPairs[$positionInGroup];
            $isReal = ($positionInGroup === 0);

            // Get vacation data only for real contracts (A subgroup)
            $vacationData = null;
            if ($isReal && $vacationIndex < $vacations->count()) {
                $vacation = $vacations->get($vacationIndex);
                $vacationData = [
                    'id' => $vacation->id,
                    'code_vacation' => $vacation->code_vacation,
                    'shift' => $vacation->shift,
                    'start_time' => $vacation->start_time,
                    'end_time' => $vacation->end_time,
                    'vacation_type' => $vacation->vacation_type,
                    'agent_1_id' => $vacation->agent_1_id,
                    'agent_2_id' => $vacation->agent_2_id,
                    'agent1' => $vacation->agent1 ? $vacation->agent1->toArray() : null,
                    'agent2' => $vacation->agent2 ? $vacation->agent2->toArray() : null,
                ];
                $vacationIndex++;
            }

            // Generate contract code
            $contractCode = $this->generateContractCode($demande, $group, $subPair);

            // Create contract with vacation data (if any)
            $contract = [
                'index' => $i,
                'group' => $group,
                'sub_pair' => $subPair,
                'code' => $contractCode,
                'is_real' => $isReal,
                'type' => $isReal ? 'RÉEL' : 'VIRTUEL',
                'has_vacation' => $vacationData !== null,
                'vacation' => $vacationData,
            ];

            $contracts->push($contract);
        }

        return $contracts;
    }

    /**
     * Generate contract code
     * Format: [SITE_CODE]VAC[GROUP][SUBPAIR][SHIFT]
     * 
     * @param Demande $demande
     * @param string $group K, L, M, or N
     * @param string $subPair A, B, C, or D
     * @return string
     */
    private function generateContractCode(Demande $demande, string $group, string $subPair): string
    {
        if (!$demande->site) {
            return 'VAC' . $group . $subPair . 'P'; // Default to day shift
        }

        $siteCode = $demande->site->site_code ?? 'UNKNOWN';
        $shift = 'P'; // Day shift (P for jour, S for nuit)

        return $siteCode . 'VAC' . $group . $subPair . $shift;
    }
}
