<?php

/**
 * Test d'intégration: Traitement complet des demandes de paiement
 * 
 * Ce fichier simule le traitement d'une demande dans la base de données
 */

require_once 'vendor/autoload.php';

use App\Models\Demande;
use App\Services\PaymentCalculatorService;
use App\Services\AgentPaymentService;
use Illuminate\Database\Capsule\Manager as DB;

// Configuration minimale pour Eloquent
$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'secur',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];

$db = new DB();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

echo "=== TEST D'INTÉGRATION: TRAITEMENT DES DEMANDES ===\n\n";

// Test 1: Créer une demande et la traiter
echo "TEST 1: Créer et traiter une demande avec 4 agents à 105,000 CFA\n";
echo str_repeat("=", 70) . "\n";

try {
    // Créer une demande de test (sans client/site pour simplifier)
    $demande = Demande::create([
        'client_id' => 1, // À adapter selon votre BD
        'site_id' => 1,   // À adapter selon votre BD
        'nombre_agents' => 4,
        'type_vacation' => 'sys_12',
        'status' => 'en_cours',
    ]);

    echo "✓ Demande créée: ID #{$demande->id}\n";

    // Créer le service de calcul
    $calculator = new PaymentCalculatorService();

    // Valider le nombre d'agents
    if (!$calculator->isValidNumberOfAgents($demande->nombre_agents)) {
        echo "  ✗ Nombre d'agents invalide\n";
        exit(1);
    }

    echo "  ✓ Nombre d'agents valide ({$demande->nombre_agents})\n";

    // Montant de test
    $montantParAgent = 105000;

    // Calculer les paiements
    $calculation = $calculator->calculateComplete($demande->nombre_agents, $montantParAgent);

    if (!$calculation['valid']) {
        echo "  ✗ Calcul invalide: {$calculation['error']}\n";
        exit(1);
    }

    echo "  ✓ Calcul valide\n";

    // Mettre à jour la demande
    $demande->update([
        'montant_par_agent' => $montantParAgent,
        'montant_brut' => $calculation['montant_total'],
        'montant_exploitation' => $calculation['exploitation'],
        'montant_tresorerie' => $calculation['tresorerie'],
        'salaire_par_agent' => $calculation['salaire_par_agent'],
        'montant_par_vacation' => $calculation['montant_par_vacation'],
        'status' => 'affecte',
    ]);

    echo "  ✓ Demande mise à jour\n\n";

    // Afficher les résultats
    $demande->refresh();

    echo "  Résultats:\n";
    echo "    Montant brut: " . number_format($demande->montant_brut, 0, ',', ' ') . " CFA\n";
    echo "    Exploitation (50%): " . number_format($demande->montant_exploitation, 0, ',', ' ') . " CFA\n";
    echo "    Trésorerie (50%): " . number_format($demande->montant_tresorerie, 0, ',', ' ') . " CFA\n";
    echo "    Salaire par agent: " . number_format($demande->salaire_par_agent, 0, ',', ' ') . " CFA\n";
    echo "    Montant par vacation: " . number_format($demande->montant_par_vacation, 2, ',', ' ') . " CFA\n";

    // Vérifier le résultat
    if ($demande->salaire_par_agent == 52500) {
        echo "\n  ✅ TEST RÉUSSI: Salaire = 52,500 CFA\n";
    } else {
        echo "\n  ❌ TEST ÉCHOUÉ: Attendu 52,500, obtenu {$demande->salaire_par_agent}\n";
        exit(1);
    }

    // Supprimer la demande de test
    $demande->delete();
    echo "  ✓ Demande de test supprimée\n\n";
} catch (\Exception $e) {
    echo "  ✗ Erreur: {$e->getMessage()}\n";
    exit(1);
}

echo "---\n\n";

// Test 2: Créer et traiter une demande avec 4 agents à 130,000 CFA
echo "TEST 2: Créer et traiter une demande avec 4 agents à 130,000 CFA\n";
echo str_repeat("=", 70) . "\n";

try {
    $demande = Demande::create([
        'client_id' => 1,
        'site_id' => 1,
        'nombre_agents' => 4,
        'type_vacation' => 'sys_12',
        'status' => 'en_cours',
    ]);

    echo "✓ Demande créée: ID #{$demande->id}\n";

    $calculator = new PaymentCalculatorService();
    $montantParAgent = 130000;

    $calculation = $calculator->calculateComplete($demande->nombre_agents, $montantParAgent);

    $demande->update([
        'montant_par_agent' => $montantParAgent,
        'montant_brut' => $calculation['montant_total'],
        'montant_exploitation' => $calculation['exploitation'],
        'montant_tresorerie' => $calculation['tresorerie'],
        'salaire_par_agent' => $calculation['salaire_par_agent'],
        'montant_par_vacation' => $calculation['montant_par_vacation'],
        'status' => 'affecte',
    ]);

    $demande->refresh();

    echo "  ✓ Demande mise à jour\n\n";

    echo "  Résultats:\n";
    echo "    Montant brut: " . number_format($demande->montant_brut, 0, ',', ' ') . " CFA\n";
    echo "    Salaire par agent: " . number_format($demande->salaire_par_agent, 0, ',', ' ') . " CFA\n";
    echo "    Montant par vacation: " . number_format($demande->montant_par_vacation, 2, ',', ' ') . " CFA\n";

    if ($demande->salaire_par_agent == 65000) {
        echo "\n  ✅ TEST RÉUSSI: Salaire = 65,000 CFA\n";
    } else {
        echo "\n  ❌ TEST ÉCHOUÉ: Attendu 65,000, obtenu {$demande->salaire_par_agent}\n";
        exit(1);
    }

    $demande->delete();
    echo "  ✓ Demande de test supprimée\n\n";
} catch (\Exception $e) {
    echo "  ✗ Erreur: {$e->getMessage()}\n";
    exit(1);
}

echo "---\n\n";
echo "🎉 TOUS LES TESTS D'INTÉGRATION PASSÉS!\n";
echo "Le système de paiement est opérationnel et prêt à être utilisé.\n";
