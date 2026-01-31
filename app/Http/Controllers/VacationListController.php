<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Services\VacationCodeGenerator;
use App\Services\PaymentCalculatorService;
use App\Services\AgentPaymentService;
use App\Services\ContractGeneratorService;
use Illuminate\View\View;

class VacationListController extends Controller
{
    protected PaymentCalculatorService $paymentCalculator;
    protected VacationCodeGenerator $codeGenerator;
    protected AgentPaymentService $agentPaymentService;
    protected ContractGeneratorService $contractGenerator;

    public function __construct()
    {
        $this->paymentCalculator = new PaymentCalculatorService();
        $this->codeGenerator = new VacationCodeGenerator();
        $this->agentPaymentService = new AgentPaymentService();
        $this->contractGenerator = new ContractGeneratorService();
    }

    /**
     * Afficher toutes les vacations réelles et virtuelles avec leurs montants
     * 
     * New payment system:
     * - Minimum 4 agents required (4 * 128 = 512 units = 2 * 256)
     * - 256 exploitation, 256 treasury (50% split)
     * - Exploitation 256 → /2=128 → /2=64 contracts → /4=16 → /16=1 base contract
     * - 1 base contract / 4 = 1 real + 3 virtual contracts
     * - 1 agent (128 units) = 105,000 CFA francs
     * - Each contract = 205 CFA francs
     */
    public function index(): View
    {
        $demandes = Demande::with(['vacations', 'client', 'site'])
            ->whereHas('vacations')
            ->get();

        $vacationsList = [];
        $groups = $this->codeGenerator->getGroups(); // ['K', 'L', 'M', 'N']
        $contractCounts = $this->codeGenerator->getContractCounts(); // real: 1, virtual: 3, total: 4

        foreach ($demandes as $demande) {
            if ($demande->vacations->isEmpty() || !$demande->montant_exploitation) {
                continue;
            }

            // Get payment breakdown
            $paymentBreakdown = $this->agentPaymentService->getPaymentBreakdown($demande);
            $vacationSummary = $this->agentPaymentService->getVacationSummary($demande);

            // Calculer le montant par vacation
            $montantParVacation = $vacationSummary['montant_par_vacation'];

            $realVacations = $demande->vacations->where('vacation_type', 'reel');
            $virtualVacations = $demande->vacations->where('vacation_type', 'virtuel');

            // Créer les vacations pour chaque groupe
            $allVacations = collect();
            foreach ($demande->vacations as $index => $vacation) {
                // Déterminer le groupe : groupes assignés par blocs de 4 vacations
                // Vacations 0-3: Groupe K, 4-7: Groupe L, 8-11: Groupe M, 12-15: Groupe N
                $groupIndex = intdiv($index, 4); // 4 vacations per group
                $group = $groups[$groupIndex % count($groups)];

                // Déterminer la position dans le groupe (0=réel, 1-3=virtuel)
                $positionInGroup = $index % $contractCounts['total'];
                $isReal = ($positionInGroup === 0);

                // Sub-pair (A pour réel, B/C/D pour virtuel)
                $subPair = $this->codeGenerator->getSubPairs()[$positionInGroup];

                // Vérifier si c'est un shift nuit
                $isNight = strtolower($vacation->shift) === 'nuit' ||
                    strpos(strtolower($vacation->shift), 'nuit') !== false;

                // Générer le code vacation
                if ($demande->site) {
                    $generatedCode = $this->codeGenerator->generateSingleCode(
                        $demande->site,
                        $group,
                        $subPair,
                        $isNight
                    );
                } else {
                    $generatedCode = 'VAC' . $group . $subPair . ($isNight ? 'S' : 'P');
                }

                // Créer une copie avec les informations du groupe
                $vacationCopy = clone $vacation;
                $vacationCopy->group = $group;
                $vacationCopy->sub_pair = $subPair;
                $vacationCopy->generated_code = $generatedCode;
                $vacationCopy->is_real = $isReal;
                $vacationCopy->contract_type = $isReal ? 'Réel' : 'Virtuel';

                $allVacations->push($vacationCopy);
            }

            $demandeData = [
                'demande' => $demande,
                'payment_breakdown' => $paymentBreakdown,
                'vacation_summary' => $vacationSummary,
                'montant_par_vacation' => $montantParVacation,
                'vacations' => $allVacations->sortBy('id'),
                'realVacations' => $realVacations,
                'virtualVacations' => $virtualVacations,
                'groups' => $groups,
                'contract_counts' => $contractCounts,
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
        $demande = Demande::with(['vacations.agent1', 'vacations.agent2', 'client', 'site'])->findOrFail($demandeId);

        if ($demande->vacations->isEmpty()) {
            return back()->with('error', 'Cette demande n\'a pas de vacations.');
        }

        // Get payment information
        $paymentBreakdown = $this->agentPaymentService->getPaymentBreakdown($demande);
        $vacationSummary = $this->agentPaymentService->getVacationSummary($demande);

        $montantParVacation = $vacationSummary['montant_par_vacation'];

        // Generate all 16 contracts with vacation mapping
        $contracts = $this->contractGenerator->generateContractsWithVacations($demande);

        return view('admin.vacations.detail-demand', compact(
            'demande',
            'paymentBreakdown',
            'vacationSummary',
            'montantParVacation',
            'contracts'
        ));
    }
}
