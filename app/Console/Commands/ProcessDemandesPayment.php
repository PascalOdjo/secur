<?php

namespace App\Console\Commands;

use App\Models\Demande;
use App\Services\PaymentCalculatorService;
use App\Services\AgentPaymentService;
use Illuminate\Console\Command;

class ProcessDemandesPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demande:process-payment {--demande-id= : Process a specific demande ID}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Process payment calculations for all demands using the new payment system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paymentCalculator = new PaymentCalculatorService();
        $agentPaymentService = new AgentPaymentService();

        // Get demands to process
        if ($this->option('demande-id')) {
            $demandes = Demande::where('id', $this->option('demande-id'))->get();
        } else {
            $demandes = Demande::all();
        }

        if ($demandes->isEmpty()) {
            $this->error('No demands found to process');
            return 1;
        }

        $this->info("Processing " . $demandes->count() . " demands...");
        $processed = 0;
        $failed = 0;

        foreach ($demandes as $demande) {
            try {
                // Validate and calculate payment
                if (!$demande->nombre_agents || $demande->nombre_agents < PaymentCalculatorService::MIN_AGENTS) {
                    $this->warn("Demand #{$demande->id}: Insufficient agents ({$demande->nombre_agents})");
                    $failed++;
                    continue;
                }

                // Process with agent payment service
                $result = $agentPaymentService->processDemande($demande);

                if (!$result['success']) {
                    $this->warn("Demand #{$demande->id}: " . $result['message']);
                    $failed++;
                    continue;
                }

                // Assign vacation codes
                $codeResult = $agentPaymentService->assignVacationCodes($result['demande']);

                if (!$codeResult['success']) {
                    $this->warn("Demand #{$demande->id}: " . $codeResult['message']);
                } else {
                    $this->line("  ✓ " . $codeResult['message']);
                }

                $this->info("✓ Demand #{$demande->id} processed successfully");
                $processed++;
            } catch (\Exception $e) {
                $this->error("Demand #{$demande->id}: " . $e->getMessage());
                $failed++;
            }
        }

        $this->line("");
        $this->info("Summary: $processed processed, $failed failed");

        return $processed > 0 ? 0 : 1;
    }
}
