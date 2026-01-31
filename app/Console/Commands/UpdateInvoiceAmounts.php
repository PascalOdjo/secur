<?php

namespace App\Console\Commands;

use App\Models\Demande;
use App\Models\Invoice;
use Illuminate\Console\Command;

class UpdateInvoiceAmounts extends Command
{
    protected $signature = 'invoices:update-amounts';
    protected $description = 'Update invoice amounts based on agent payments';

    public function handle()
    {
        $demandes = Demande::all();
        $count = 0;

        foreach ($demandes as $demande) {
            $invoice = $demande->invoice;
            if (!$invoice) {
                continue;
            }

            // Calculate total agent payments from all vacations for this demande
            $agentPaymentTotal = $demande->vacations()
                ->with('agentPayments')
                ->get()
                ->sum(function ($vacation) {
                    return $vacation->agentPayments->sum('amount');
                });

            // agent_payment = montant_exploitation (déjà versé aux agents)
            $invoice->agent_payment = $demande->montant_exploitation ?? $agentPaymentTotal;

            // agency_payment = montant_tresorerie (à l'agence)
            $invoice->agency_payment = $demande->montant_tresorerie ?? 0;

            $invoice->save();

            $count++;
            $this->info("Updated invoice {$invoice->id} (demande {$demande->id}): agent_payment={$invoice->agent_payment}, agency_payment={$invoice->agency_payment}");
        }

        $this->info("Updated {$count} invoices");
        return 0;
    }
}
