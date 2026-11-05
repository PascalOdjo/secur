<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\AgentPayment;

class RecalculateInvoicePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate agent_payment and agency_payment for all invoices based on existing AgentPayments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting invoice recalculation...');

        $invoices = Invoice::with(['demande.vacations'])->get();

        foreach ($invoices as $invoice) {
            $this->info("Processing Invoice ID: {$invoice->id}");

            if (!$invoice->demande) {
                $this->warn("Invoice {$invoice->id} has no associated demande. Skipping.");
                continue;
            }

            // Get all vacation IDs for the demande
            $vacationIds = $invoice->demande->vacations->pluck('id');

            if ($vacationIds->isEmpty()) {
                // Try to check if invoice links mainly to vacation (backward compatibility or if logic changes)
                // But current logic is Invoice -> Demande -> Vacations
                // Also check if Invoice has vacation_id directly
                if ($invoice->vacation_id) {
                    $vacationIds->push($invoice->vacation_id);
                }
            }

            // Sum all agent payments for these vacations
            $totalAgentPayments = AgentPayment::whereIn('vacation_id', $vacationIds)->sum('amount');

            $invoice->agent_payment = $totalAgentPayments;
            $invoice->agency_payment = $invoice->total_amount - $totalAgentPayments;
            $invoice->save();

            $this->info("Updated Invoice {$invoice->id}: Agent Payment = {$invoice->agent_payment}, Agency Payment = {$invoice->agency_payment}");
        }

        $this->info('Recalculation complete.');
    }
}
