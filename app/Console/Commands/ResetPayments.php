<?php

namespace App\Console\Commands;

use App\Models\Demande;
use App\Models\AgentPayment;
use Illuminate\Console\Command;

class ResetPayments extends Command
{
    protected $signature = 'payments:reset';
    protected $description = 'Delete and recalculate all agent payments correctly (limited to contract period)';

    public function handle()
    {
        $this->info('Deleting all existing agent payments...');
        AgentPayment::truncate();
        $this->info('✓ All agent payments deleted');

        // Reset invoice amounts
        $this->info('Resetting invoice amounts to 0...');
        \App\Models\Invoice::query()->update([
            'agent_payment' => 0,
            'agency_payment' => 0,
        ]);
        $this->info('✓ Invoice amounts reset');

        // Now run the payment processor
        $this->info('Running payment processor with corrected logic...');
        $this->call('payments:process-daily');

        $this->info('✓ Payments recalculated successfully!');
        return 0;
    }
}
