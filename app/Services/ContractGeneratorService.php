<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Contrat;
use App\Models\Agent;
use App\Models\Vacation;
use Illuminate\Support\Collection;

/**
 * ContractGeneratorService
 *
 * Génère les contrats (réels et virtuels) par agent.
 * - 64 contrats par agent : 16 réels + 48 virtuels (3 × 16)
 * - 4 agents × 64 = 256 = valeur en exploitation
 * - Seuls les contrats réels reçoivent une vacation
 */
class ContractGeneratorService
{
    public const CONTRACTS_PER_AGENT = 64;
    public const REAL_CONTRACTS_PER_AGENT = 16;
    public const VIRTUAL_CONTRACTS_PER_AGENT = 48; // 3 × 16

    protected VacationCodeGenerator $codeGenerator;

    public function __construct()
    {
        $this->codeGenerator = new VacationCodeGenerator();
    }

    /**
     * Récupère les agents de la demande (depuis les vacations ou les N premiers agents)
     */
    protected function getAgentsForDemande(Demande $demande): Collection
    {
        $vacations = $demande->vacations;
        if ($vacations->isNotEmpty()) {
            $agentIds = $vacations->pluck('agent_1_id')->merge($vacations->pluck('agent_2_id'))
                ->filter()->unique()->values();
            return Agent::whereIn('id', $agentIds)->orderBy('id')->get();
        }
        
        // On ne retourne plus d'agents par défaut pour forcer l'attribution manuelle
        return collect();
    }

    /**
     * Crée et enregistre tous les contrats pour une demande.
     * 64 contrats par agent (16 réels + 48 virtuels) → 256 contrats pour 4 agents.
     *
     * @param Demande $demande
     * @return Collection of saved contracts
     */
    public function createContractsForDemande(Demande $demande): Collection
    {
        Contrat::where('demande_id', $demande->id)->delete();

        $numAgentsExpected = $demande->nombre_agents ?: 4;
        $totalContractsExpected = $numAgentsExpected * self::CONTRACTS_PER_AGENT;
        
        $valeurExploitationPerContract = $demande->montant_exploitation
            ? ($demande->montant_exploitation / $totalContractsExpected)
            : 0;
        $valeurTresoreriePerContract = $demande->montant_tresorerie
            ? ($demande->montant_tresorerie / $totalContractsExpected)
            : 0;

        $groups = $this->codeGenerator->getGroups();
        $subPairs = $this->codeGenerator->getSubPairs();
        $savedContracts = collect();

        $assignedAgents = $this->getAgentsForDemande($demande);

        // On génère des slots pour chaque agent attendu (basé sur le nombre demandé)
        for ($a = 0; $a < $numAgentsExpected; $a++) {
            $agent = $assignedAgents->get($a); // Peut être null si non encore attribué
            
            $agentRealVacations = $agent ? $this->getRealVacationsForAgent($demande, $agent->id) : [];

            for ($i = 0; $i < self::CONTRACTS_PER_AGENT; $i++) {
                $groupIndex = intdiv($i, 4) % 4;
                $group = $groups[$groupIndex];
                $positionInGroup = $i % 4;
                $subPair = $subPairs[$positionInGroup];
                $isReal = ($positionInGroup === 0);

                $vacationId = null;
                if ($agent && $isReal && isset($agentRealVacations[intdiv($i, 4)])) {
                    $vacationId = $agentRealVacations[intdiv($i, 4)]->id;
                }

                $contractCode = $this->generateContractCode($demande, $group, $subPair);

                $contrat = Contrat::create([
                    'demande_id' => $demande->id,
                    'agent_id' => $agent ? $agent->id : null,
                    'vacation_id' => $vacationId,
                    'group' => $group,
                    'sub_pair' => $subPair,
                    'code' => $contractCode,
                    'type' => $isReal ? 'RÉEL' : 'VIRTUEL',
                    'is_real' => $isReal,
                    'nombre_agents' => $demande->nombre_agents,
                    'valeur_exploitation' => $valeurExploitationPerContract,
                    'valeur_tresorerie' => $valeurTresoreriePerContract,
                    'statut' => 'actif',
                ]);

                $savedContracts->push($contrat);
            }
        }

        return $savedContracts;
    }

    /**
     * Récupère les 16 vacations réelles pour un agent (ordre par groupe)
     */
    protected function getRealVacationsForAgent(Demande $demande, int $agentId): array
    {
        $vacations = Vacation::where('demande_id', $demande->id)
            ->where(function ($q) use ($agentId) {
                $q->where('agent_1_id', $agentId)->orWhere('agent_2_id', $agentId);
            })
            ->where('vacation_type', 'reel')
            ->orderBy('id')
            ->get();

        return $vacations->take(self::REAL_CONTRACTS_PER_AGENT)->values()->all();
    }

    /**
     * Génère tous les contrats (réels et virtuels) pour affichage, groupés par agent.
     * 64 contrats par agent avec données vacation pour les réels.
     *
     * @param Demande $demande
     * @return array ['agents' => [...], 'total_contracts' => 256]
     */
    public function getContractsByAgentForDemande(Demande $demande): array
    {
        $agents = $this->getAgentsForDemande($demande);
        $groups = $this->codeGenerator->getGroups();
        $subPairs = $this->codeGenerator->getSubPairs();

        $byAgent = [];
        foreach ($agents as $agent) {
            $agentRealVacations = $this->getRealVacationsForAgent($demande, $agent->id);
            $contracts = [];
            for ($i = 0; $i < self::CONTRACTS_PER_AGENT; $i++) {
                $groupIndex = intdiv($i, 4) % 4;
                $group = $groups[$groupIndex];
                $positionInGroup = $i % 4;
                $subPair = $subPairs[$positionInGroup];
                $isReal = ($positionInGroup === 0);
                $vacation = $isReal && isset($agentRealVacations[intdiv($i, 4)])
                    ? $agentRealVacations[intdiv($i, 4)]
                    : null;

                $contracts[] = [
                    'index' => $i + 1,
                    'group' => $group,
                    'sub_pair' => $subPair,
                    'type' => $isReal ? 'RÉEL' : 'VIRTUEL',
                    'is_real' => $isReal,
                    'code' => $this->generateContractCode($demande, $group, $subPair),
                    'vacation' => $vacation ? [
                        'id' => $vacation->id,
                        'code_vacation' => $vacation->code_vacation,
                        'shift' => $vacation->shift,
                        'start_time' => $vacation->start_time,
                        'end_time' => $vacation->end_time,
                    ] : null,
                ];
            }
            $byAgent[] = [
                'agent' => $agent,
                'contracts' => $contracts,
                'real_count' => self::REAL_CONTRACTS_PER_AGENT,
                'virtual_count' => self::VIRTUAL_CONTRACTS_PER_AGENT,
                'total' => self::CONTRACTS_PER_AGENT,
            ];
        }

        return [
            'demande' => $demande,
            'agents_contracts' => $byAgent,
            'total_contracts' => $agents->count() * self::CONTRACTS_PER_AGENT,
            'exploitation_value' => $agents->count() * self::CONTRACTS_PER_AGENT, // 256 pour 4 agents
        ];
    }

    /**
     * Génère 16 contrats (1 réel + 3 virtuels × 4 groupes) pour la vue détail vacations.
     * Format attendu par admin.vacations.detail-demand : index, code, group, sub_pair, is_real, has_vacation, vacation (agent1, agent2, start_time, end_time).
     */
    public function generateContractsWithVacations(Demande $demande): Collection
    {
        $groups = $this->codeGenerator->getGroups();
        $subPairs = $this->codeGenerator->getSubPairs();
        $vacations = $demande->vacations->load('agent1', 'agent2');
        $contracts = collect();
        $vacationIndex = 0;
        $totalContracts = 16;

        for ($i = 0; $i < $totalContracts; $i++) {
            $groupIndex = intdiv($i, 4);
            $group = $groups[$groupIndex % count($groups)];
            $positionInGroup = $i % 4;
            $subPair = $subPairs[$positionInGroup];
            $isReal = ($positionInGroup === 0);

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

            $contracts->push([
                'index' => $i,
                'group' => $group,
                'sub_pair' => $subPair,
                'code' => $this->generateContractCode($demande, $group, $subPair),
                'is_real' => $isReal,
                'has_vacation' => $vacationData !== null,
                'vacation' => $vacationData,
            ]);
        }

        return $contracts;
    }

    private function generateContractCode(Demande $demande, string $group, string $subPair): string
    {
        if (!$demande->site) {
            return 'VAC' . $group . $subPair . 'P';
        }
        $siteCode = $demande->site->site_code ?? 'UNKNOWN';
        return $siteCode . 'VAC' . $group . $subPair . 'P';
    }
}
