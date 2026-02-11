<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Demande;
use App\Services\AgentPaymentService;
use App\Services\PaymentCalculatorService;

class ProcessDemandesPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:process {demande_id? : ID de la demande à traiter}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Traite les paiements des demandes: Calcule les salaires par agent et assigne les codes de vacations';

    protected PaymentCalculatorService $paymentCalculator;
    protected AgentPaymentService $agentPayment;

    /**
     * Create a new command instance.
     */
    public function __construct(PaymentCalculatorService $paymentCalculator, AgentPaymentService $agentPayment)
    {
        parent::__construct();
        $this->paymentCalculator = $paymentCalculator;
        $this->agentPayment = $agentPayment;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demandeId = $this->argument('demande_id');

        if ($demandeId) {
            // Traiter une demande spécifique
            $this->processSpecificDemande($demandeId);
        } else {
            // Traiter toutes les demandes non traitées
            $this->processAllDemandes();
        }
    }

    /**
     * Traiter une demande spécifique
     */
    private function processSpecificDemande($demandeId)
    {
        $demande = Demande::find($demandeId);

        if (!$demande) {
            $this->error("Demande #{$demandeId} non trouvée.");
            return;
        }

        $this->info("Traitement de la demande #{$demandeId}...");

        try {
            // Valider le nombre d'agents
            if (!$this->paymentCalculator->isValidNumberOfAgents($demande->nombre_agents)) {
                $this->warn("  ✗ Nombre d'agents insuffisant. Minimum 4 agents requis.");
                return;
            }

            // Récupérer le montant par agent depuis la demande
            // Note: Pour cet exemple, on suppose que le montant est stocké dans description ou un champ à ajouter
            // En production, ajouter un champ "montant_par_agent" à la table demandes
            $montantParAgent = $demande->montant_par_agent ?? 105000; // Valeur par défaut pour test

            // Calculer les paiements
            $calculation = $this->paymentCalculator->calculateComplete($demande->nombre_agents, $montantParAgent);

            if (!$calculation['valid']) {
                $this->warn("  ✗ Calcul invalide: " . $calculation['error']);
                return;
            }

            // Mettre à jour la demande avec les valeurs calculées
            $demande->update([
                'montant_brut' => $calculation['montant_total'],
                'montant_exploitation' => $calculation['exploitation'],
                'montant_tresorerie' => $calculation['tresorerie'],
                'salaire_par_agent' => $calculation['salaire_par_agent'],
                'montant_par_vacation' => $calculation['montant_par_vacation'],
            ]);

            // Assigner les codes de vacations
            // Note: Cette fonctionnalité nécessite une configuration supplémentaire
            // Pour l'instant, on affiche juste les informations

            $this->info("  ✓ Demande traitée avec succès!");
            $this->line("    Montant brut: " . number_format($calculation['montant_total'], 0, ',', ' ') . " CFA");
            $this->line("    Exploitation: " . number_format($calculation['exploitation'], 0, ',', ' ') . " CFA");
            $this->line("    Trésorerie: " . number_format($calculation['tresorerie'], 0, ',', ' ') . " CFA");
            $this->line("    Salaire par agent: " . number_format($calculation['salaire_par_agent'], 0, ',', ' ') . " CFA");
            $this->line("    Montant par vacation: " . number_format($calculation['montant_par_vacation'], 2, ',', ' ') . " CFA");
        } catch (\Exception $e) {
            $this->error("  ✗ Erreur: " . $e->getMessage());
        }
    }

    /**
     * Traiter toutes les demandes non traitées
     */
    private function processAllDemandes()
    {
        // Récupérer les demandes qui n'ont pas encore été traitées (salaire_par_agent = NULL)
        $demandes = Demande::whereNull('salaire_par_agent')->get();

        if ($demandes->isEmpty()) {
            $this->info("Aucune demande à traiter. Toutes les demandes ont déjà été traitées.");
            return;
        }

        $this->info("Traitement de " . $demandes->count() . " demande(s)...\n");

        $processed = 0;
        $failed = 0;

        foreach ($demandes as $demande) {
            $this->line("Demande #{$demande->id} ({$demande->nombre_agents} agents)...");

            try {
                // Valider le nombre d'agents
                if (!$this->paymentCalculator->isValidNumberOfAgents($demande->nombre_agents)) {
                    $this->warn("  ✗ Nombre d'agents insuffisant (minimum 4)");
                    $failed++;
                    continue;
                }

                // Récupérer le montant par agent
                $montantParAgent = $demande->montant_par_agent ?? 105000;

                // Calculer les paiements
                $calculation = $this->paymentCalculator->calculateComplete($demande->nombre_agents, $montantParAgent);

                if (!$calculation['valid']) {
                    $this->warn("  ✗ Calcul invalide");
                    $failed++;
                    continue;
                }

                // Mettre à jour la demande
                $demande->update([
                    'montant_brut' => $calculation['montant_total'],
                    'montant_exploitation' => $calculation['exploitation'],
                    'montant_tresorerie' => $calculation['tresorerie'],
                    'salaire_par_agent' => $calculation['salaire_par_agent'],
                    'montant_par_vacation' => $calculation['montant_par_vacation'],
                ]);

                $this->info("  ✓ Traitée (Salaire: " . number_format($calculation['salaire_par_agent'], 0, ',', ' ') . " CFA)");
                $processed++;
            } catch (\Exception $e) {
                $this->error("  ✗ Erreur: " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Résumé: {$processed} demande(s) traitée(s), {$failed} échec(s)");
    }
}
