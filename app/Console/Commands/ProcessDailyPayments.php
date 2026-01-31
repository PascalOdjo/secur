<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vacation;
use App\Models\AgentPayment;
use App\Models\Demande;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessDailyPayments extends Command
{
    protected $signature = 'payments:process-daily';
    protected $description = 'Process daily agent payments when vacations end';

    public function handle()
    {
        $now = Carbon::now();

        // Get all vacations that have started (not necessarily ended)
        // We process daily payments for all vacations up to today
        $vacations = Vacation::where('start_time', '<=', $now)->get();

        foreach ($vacations as $vacation) {
            $agentIds = array_filter([$vacation->agent_1_id, $vacation->agent_2_id]);
            $numberOfAgents = count($agentIds);

            if ($numberOfAgents === 0) {
                // No agents assigned, skip
                continue;
            }

            // Get the associated demand to fetch montant_exploitation
            $demande = Demande::find($vacation->demande_id);
            if (!$demande || !$demande->montant_exploitation) {
                // No demand or montant_exploitation specified, skip
                continue;
            }

            // Calculate CONTRACT duration in days (NOT vacation duration)
            // The payment covers the entire contract period
            $contractStart = Carbon::parse($demande->start_date)->startOfDay();
            $contractEnd = Carbon::parse($demande->end_date)->startOfDay();
            $today = Carbon::now()->startOfDay();

            // Utiliser le nombre de jours écoulés jusqu'à aujourd'hui (ou jusqu'à la fin du contrat si elle est passée)
            $daysToUse = $contractStart->diffInDays($today) + 1; // +1 to include start day

            // Si la fin du contrat est avant aujourd'hui, utiliser la durée totale du contrat
            if ($contractEnd->lt($today)) {
                $daysToUse = $contractStart->diffInDays($contractEnd) + 1;
            }

            if ($daysToUse <= 0) {
                continue;
            }

            // COUNT TOTAL VACATIONS FOR THIS DEMANDE TO DISTRIBUTE THE MONTANT_EXPLOITATION CORRECTLY
            $totalVacationsForDemande = Vacation::where('demande_id', $vacation->demande_id)->count();

            // Distribute montant_exploitation across all vacations for this demande
            $montantPerVacation = $demande->montant_exploitation / $totalVacationsForDemande;

            // Calculate daily payment per agent: montant_per_vacation / DAYS_ELAPSED / number_of_agents
            // This is the daily rate for ONE agent, based on days elapsed
            $dailyPaymentPerAgent = $montantPerVacation / $daysToUse / $numberOfAgents;

            // Determine contract date range (dates when payments should be applied)
            // PAY ONLY DURING THE CONTRACT PERIOD: from contract start_date to end_date
            $contractStartDay = $contractStart;
            $contractEndDay = $contractEnd;

            foreach ($agentIds as $agentId) {
                // find last payment date for this agent + vacation
                $lastPaymentDate = AgentPayment::where('vacation_id', $vacation->id)
                    ->where('agent_id', $agentId)
                    ->max('date');

                if ($lastPaymentDate) {
                    $startDate = Carbon::parse($lastPaymentDate)->addDay()->startOfDay();
                } else {
                    $startDate = $contractStartDay;
                }

                // The date we should stop creating payments for this vacation/agent
                // Don't go beyond contract end or today, whichever is first
                $targetEndDate = Carbon::now()->startOfDay()->lt($contractEndDay) ? Carbon::now()->startOfDay() : $contractEndDay;

                if ($startDate->gt($targetEndDate)) {
                    // nothing to do
                    continue;
                }

                // loop days from startDate to targetEndDate and create missing payments
                $cursor = $startDate->copy();
                while ($cursor->lte($targetEndDate)) {
                    $dateString = $cursor->toDateString();

                    // avoid duplicates
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
                            $this->info("Created payment for agent {$agentId} for vacation {$vacation->id} on {$dateString}: {$dailyPaymentPerAgent} FCFA");

                            // Update Invoice
                            if ($demande->invoice) {
                                $invoice = $demande->invoice;
                                $invoice->agent_payment += $dailyPaymentPerAgent;
                                $invoice->agency_payment = $invoice->total_amount - $invoice->agent_payment;
                                $invoice->save();
                            }
                        } catch (\Exception $e) {
                            Log::error('Error creating AgentPayment: ' . $e->getMessage());
                        }
                    }

                    $cursor->addDay();
                }
            }
        }

        return 0;
    }
}
