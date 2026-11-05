<?php

namespace App\Console\Commands;

use App\Models\Demande;
use App\Models\Vacation;
use App\Services\ContractCalculationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixVacationDates extends Command
{
    protected $signature = 'vacations:fix-dates {demande_id?}';
    protected $description = 'Fix vacation dates to match demande start_date and end_date';

    public function handle()
    {
        $demandeId = $this->argument('demande_id');

        if ($demandeId) {
            $demandes = Demande::where('id', $demandeId)->get();
        } else {
            $demandes = Demande::whereHas('vacations')->get();
        }

        foreach ($demandes as $demande) {
            $this->info("Fixing vacations for Demande #{$demande->id}");

            // Supprimer les anciennes vacations
            $count = Vacation::where('demande_id', $demande->id)->delete();
            $this->line("  Deleted $count vacations");

            // Recréer les vacations
            $service = new ContractCalculationService();
            $service->createVacationsForDemande($demande);

            // Vérifier
            $vacations = Vacation::where('demande_id', $demande->id)->get();
            $this->line("  Created " . $vacations->count() . " new vacations:");

            foreach ($vacations as $v) {
                $startDate = $v->start_time ? Carbon::parse($v->start_time)->format('d/m/Y') : 'null';
                $endDate = $v->end_time ? Carbon::parse($v->end_time)->format('d/m/Y') : 'null';
                $this->line("    - {$v->code_vacation} ({$v->vacation_type}) {$startDate} - {$endDate}");
            }
        }

        $this->info('Vacation dates fixed successfully!');
    }
}
