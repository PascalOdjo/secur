<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Demande;
use App\Services\ContractCalculationService;

class UpdateDemandesWithNewSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demandes:update-new-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mettre à jour toutes les demandes avec le nouveau système de calcul';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mise à jour des demandes avec le nouveau système...');

        $demandes = Demande::all();
        $calculationService = new ContractCalculationService();
        $count = 0;

        foreach ($demandes as $demande) {
            try {
                // Calculer les nouveaux montants
                $amounts = $calculationService->calculateContractAmounts(
                    $demande->nombre_agents,
                    $demande->start_date,
                    $demande->end_date
                );

                // Mettre à jour la demande
                $demande->update([
                    'valeur_base' => 128,
                    'prix_par_agent' => 1015,
                    'valeur_contrat' => $amounts['valeur_contrat'],
                    'montant_brut' => $amounts['montant_brut'],
                    'montant_exploitation' => $amounts['montant_exploitation'],
                    'montant_tresorerie' => $amounts['montant_tresorerie'],
                    'status_validation' => $amounts['status_validation'],
                ]);

                // Mettre à jour la facture associée
                if ($demande->invoice) {
                    $demande->invoice->update([
                        'total_amount' => $amounts['montant_exploitation'],
                    ]);
                }

                // Créer les vacations si validé et qu'elles n'existent pas
                if ($amounts['status_validation'] === 'validé' && $demande->vacations()->count() == 0) {
                    $calculationService->createVacationsForDemande($demande);
                    $this->line("✓ Demande {$demande->id}: Mise à jour + Vacations créées (Valeur: {$amounts['valeur_contrat']})");
                } else {
                    $this->line("✓ Demande {$demande->id}: Mise à jour (Valeur: {$amounts['valeur_contrat']}, Status: {$amounts['status_validation']})");
                }

                $count++;
            } catch (\Exception $e) {
                $this->error("✗ Erreur pour Demande {$demande->id}: " . $e->getMessage());
            }
        }

        $this->info("\n✓ Mise à jour terminée: {$count} demande(s) mises à jour!");
        return 0;
    }
}
