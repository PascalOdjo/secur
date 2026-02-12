<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Demande;
use App\Services\ContractGeneratorService;

class GenerateContractsForExistingDemandes extends Command
{
    protected $signature = 'contrats:generate {--demande= : ID d\'une demande spécifique (optionnel)} {--force : Forcer la régénération sans confirmation}';
    protected $description = 'Générer les contrats pour les demandes existantes';

    public function handle()
    {
        $service = new ContractGeneratorService();
        $demandeId = $this->option('demande');
        $force = $this->option('force');

        if ($demandeId) {
            $demandes = Demande::where('id', $demandeId)->get();
            if ($demandes->isEmpty()) {
                $this->error("Demande #{$demandeId} non trouvée.");
                return 1;
            }
        } else {
            $demandes = Demande::with(['vacations', 'site'])->get();
        }

        $this->info("=== Génération des contrats pour {$demandes->count()} demande(s) ===");
        $this->newLine();

        $totalGenerated = 0;

        foreach ($demandes as $demande) {
            $existingCount = $demande->contrats()->count();

            $this->info("Demande #{$demande->id} - Client: " .
                ($demande->client ? $demande->client->nom . ' ' . $demande->client->prenom : 'N/A'));
            $this->line("  → Contrats existants: {$existingCount}");

            if ($existingCount > 0 && !$force) {
                if (!$this->confirm("  ⚠ Cette demande a déjà {$existingCount} contrats. Les régénérer ? (les anciens seront supprimés)")) {
                    $this->line("  → Ignorée.");
                    $this->newLine();
                    continue;
                }
            }

            try {
                $contracts = $service->createContractsForDemande($demande);
                $count = $contracts->count();
                $totalGenerated += $count;

                if ($count > 0) {
                    $reels = $contracts->where('is_real', true)->count();
                    $virtuels = $contracts->where('is_real', false)->count();
                    $this->info("  ✓ {$count} contrats générés ({$reels} réels, {$virtuels} virtuels)");
                } else {
                    $this->warn("  ⚠ Aucun contrat généré (pas d'agents trouvés pour cette demande)");
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Erreur: " . $e->getMessage());
            }

            $this->newLine();
        }

        $this->newLine();
        $this->info("=== Terminé : {$totalGenerated} contrats générés au total ===");

        return 0;
    }
}
