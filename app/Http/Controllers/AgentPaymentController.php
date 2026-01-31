<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\AgentPayment;
use App\Models\Vacation;
use App\Models\Demande;
use App\Services\PaymentCalculatorService;
use App\Services\AgentPaymentService;

class AgentPaymentController extends Controller
{
    protected PaymentCalculatorService $paymentCalculator;
    protected AgentPaymentService $agentPaymentService;

    public function __construct()
    {
        $this->paymentCalculator = new PaymentCalculatorService();
        $this->agentPaymentService = new AgentPaymentService();
    }

    /**
     * Afficher le tableau de bord des gains de l'agent
     */
    public function dashboard()
    {
        // Récupérer tous les agents avec leurs paiements
        $agents = Agent::with(['agentPayments' => function ($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        return view('admin.agent-payments.dashboard', compact('agents'));
    }

    /**
     * Afficher les gains détaillés d'un agent
     */
    public function show($agentId)
    {
        $agent = Agent::findOrFail($agentId);

        // Récupérer tous les paiements de cet agent avec les relations
        $allPayments = AgentPayment::where('agent_id', $agentId)
            ->with(['vacation.demande'])
            ->orderBy('vacation_id', 'desc')
            ->orderBy('date', 'desc')
            ->get();

        // Filtrer les paiements: ne garder que ceux DANS la période [start_date, end_date] du contrat
        $filteredPayments = $allPayments->filter(function ($payment) {
            if (!$payment->vacation || !$payment->vacation->demande) {
                return false;
            }

            $demande = $payment->vacation->demande;
            $paymentDate = \Carbon\Carbon::parse($payment->date);
            $startDate = \Carbon\Carbon::parse($demande->start_date);
            $endDate = \Carbon\Carbon::parse($demande->end_date);

            return $paymentDate->between($startDate, $endDate);
        });

        // Grouper par vacation_id
        $paymentsByVacation = $filteredPayments->groupBy('vacation_id');

        // Calculer les totaux sur les paiements filtrés
        $totalPending = $filteredPayments
            ->where('status', 'pending')
            ->sum('amount');

        $totalPaid = $filteredPayments
            ->where('status', 'paid')
            ->sum('amount');

        return view('admin.agent-payments.show', compact('agent', 'paymentsByVacation', 'totalPending', 'totalPaid'));
    }

    /**
     * Demander un retrait (uniquement à la fin du contrat)
     */
    public function requestWithdrawal($agentId)
    {
        $agent = Agent::findOrFail($agentId);

        // Récupérer tous les paiements en attente de cet agent
        $pendingPayments = AgentPayment::where('agent_id', $agentId)
            ->where('status', 'pending')
            ->with('vacation')
            ->get();

        if ($pendingPayments->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun paiement en attente pour cet agent.');
        }

        // Vérifier que TOUS les contrats associés aux paiements en attente sont terminés
        $vacationIds = $pendingPayments->pluck('vacation_id')->unique();
        $ongoingVacations = Vacation::whereIn('id', $vacationIds)
            ->where('status', '!=', 'termine')
            ->count();

        if ($ongoingVacations > 0) {
            return redirect()->back()->with('error', 'Vous ne pouvez retirer que lorsque tous vos contrats sont terminés.');
        }

        // Marquer tous les paiements comme payés
        AgentPayment::where('agent_id', $agentId)
            ->where('status', 'pending')
            ->update(['status' => 'paid']);

        $totalAmount = $pendingPayments->sum('amount');

        return redirect()->back()->with('success', "Retrait de {$totalAmount} FCFA effectué avec succès.");
    }

    /**
     * Afficher le résumé des gains de tous les agents
     */
    public function summary()
    {
        $agents = Agent::all();

        $agentsSummary = $agents->map(function ($agent) {
            $pending = AgentPayment::where('agent_id', $agent->id)
                ->where('status', 'pending')
                ->sum('amount');

            $paid = AgentPayment::where('agent_id', $agent->id)
                ->where('status', 'paid')
                ->sum('amount');

            return [
                'agent' => $agent,
                'total_pending' => $pending,
                'total_paid' => $paid,
                'total' => $pending + $paid,
            ];
        })->sortByDesc('total_pending');

        return view('admin.agent-payments.summary', compact('agentsSummary'));
    }

    /**
     * Display new payment overview for all demands
     */
    public function demandPayments()
    {
        $demandes = Demande::with(['client', 'site', 'vacations'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $summaryData = [];
        foreach ($demandes as $demande) {
            if ($demande->nombre_agents && $demande->vacations->count() > 0) {
                $summaryData[$demande->id] = $this->agentPaymentService->getPaymentBreakdown($demande);
            }
        }

        return view('admin.payments.index', compact('demandes', 'summaryData'));
    }

    /**
     * Show new payment details for a specific demand
     */
    public function demandPaymentShow(Demande $demande)
    {
        $demande->load(['client', 'site', 'vacations']);

        $paymentBreakdown = $this->agentPaymentService->getPaymentBreakdown($demande);
        $vacationSummary = $this->agentPaymentService->getVacationSummary($demande);

        // Group vacations by vacation type
        $realVacations = $demande->vacations->where('vacation_type', 'reel');
        $virtualVacations = $demande->vacations->where('vacation_type', 'virtuel');

        return view('admin.payments.show', compact(
            'demande',
            'paymentBreakdown',
            'vacationSummary',
            'realVacations',
            'virtualVacations'
        ));
    }

    /**
     * Process payment for a demand (calculate and save)
     */
    public function processDemandPayment(Request $request, Demande $demande)
    {
        $request->validate([
            'nombre_agents' => 'required|integer|min:' . PaymentCalculatorService::MIN_AGENTS,
            'montant' => 'nullable|numeric|min:0',
        ]);

        try {
            // Update demand with agents count
            $demande->update([
                'nombre_agents' => $request->nombre_agents,
                'montant' => $request->montant ?? null,
            ]);

            // Process payment
            $result = $this->agentPaymentService->processDemande($demande);

            if (!$result['success']) {
                return redirect()->back()->with('error', $result['message']);
            }

            // Assign vacation codes
            $codeResult = $this->agentPaymentService->assignVacationCodes($result['demande']);

            // Generate initial AgentPayment rows so the dashboard reflects the new demande immediately
            $genResult = $this->agentPaymentService->generatePaymentsForDemande($result['demande']);

            $message = 'Payment processed successfully.';
            if ($codeResult['success'] ?? false) {
                $message .= ' ' . $codeResult['message'];
            }
            if ($genResult['success'] ?? false) {
                $message .= ' Payments generated: ' . ($genResult['created'] ?? 0);
            }

            return redirect()->route('payments.show', $result['demande'])
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    /**
     * Show payment calculation form
     */
    public function calculate(Request $request)
    {
        $nombreAgents = $request->input('nombre_agents');
        $montantFourni = $request->input('montant');

        if (!$nombreAgents) {
            return view('admin.payments.calculate');
        }

        try {
            $payment = $this->paymentCalculator->calculateCompletePayment(
                (int) $nombreAgents,
                $montantFourni ? (float) $montantFourni : null
            );

            if (!$payment['valid']) {
                return view('admin.payments.calculate')
                    ->with('error', $payment['error']);
            }

            return view('admin.payments.calculate', compact('payment'));
        } catch (\Exception $e) {
            return view('admin.payments.calculate')
                ->with('error', 'Calculation error: ' . $e->getMessage());
        }
    }

    /**
     * Get payment statistics
     */
    public function statistics()
    {
        $stats = [
            'total_demands' => Demande::count(),
            'total_agents_paid' => Demande::sum('nombre_agents') ?? 0,
            'total_exploitation' => Demande::sum('montant_exploitation') ?? 0,
            'total_tresorerie' => Demande::sum('montant_tresorerie') ?? 0,
            'avg_agents_per_demand' => round(Demande::avg('nombre_agents') ?? 0, 2),
            'vacations_created' => Demande::withCount('vacations')
                ->get()
                ->sum('vacations_count') ?? 0,
        ];

        // Monthly breakdown
        $monthlyStats = Demande::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as demand_count, SUM(nombre_agents) as total_agents, SUM(montant_brut) as total_paid')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('admin.payments.statistics', compact('stats', 'monthlyStats'));
    }

    /**
     * Export payment data to CSV
     */
    public function export(Request $request)
    {
        $demandes = Demande::with(['client', 'site', 'vacations'])
            ->get();

        $filename = 'agent-payments-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($demandes) {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'Demand ID',
                'Client',
                'Site',
                'Number of Agents',
                'Total Value (Units)',
                'Total Value (CFA)',
                'Exploitation (CFA)',
                'Treasury (CFA)',
                'Price per Contract (CFA)',
                'Real Vacations',
                'Virtual Vacations',
                'Created At',
            ], ',', '"');

            // CSV Data
            foreach ($demandes as $demande) {
                if ($demande->nombre_agents) {
                    $breakdown = $this->agentPaymentService->getPaymentBreakdown($demande);

                    fputcsv($file, [
                        $demande->id,
                        $demande->client->name ?? '',
                        $demande->site->name ?? '',
                        $demande->nombre_agents,
                        $breakdown['total_units'],
                        $breakdown['total_cfa'],
                        $breakdown['exploitation_cfa'],
                        $breakdown['tresorerie_cfa'],
                        $breakdown['price_per_contract_cfa'],
                        $demande->vacations->where('vacation_type', 'reel')->count(),
                        $demande->vacations->where('vacation_type', 'virtuel')->count(),
                        $demande->created_at,
                    ], ',', '"');
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
