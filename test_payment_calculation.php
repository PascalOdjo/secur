<?php

/**
 * Test du nouveau système de paiement des agents
 * 
 * Ce fichier teste les calculs pour:
 * - 4 agents à 105,000 CFA → Salaire = 52,500 CFA
 * - 4 agents à 130,000 CFA → Salaire = 65,000 CFA
 */

require_once 'vendor/autoload.php';

use App\Services\PaymentCalculatorService;

echo "=== TEST NOUVEAU SYSTÈME DE PAIEMENT ===\n\n";

$calc = new PaymentCalculatorService();

// TEST 1: 4 agents à 105,000 CFA
echo "TEST 1: 4 agents à 105,000 CFA\n";
echo str_repeat("=", 50) . "\n";

$result1 = $calc->calculateComplete(4, 105000);

if ($result1['valid']) {
    echo "✓ Calcul valide\n";
    echo "  Montant total: " . number_format($result1['montant_total'], 0, ',', ' ') . " CFA\n";
    echo "  Exploitation (50%): " . number_format($result1['exploitation'], 0, ',', ' ') . " CFA\n";
    echo "  Trésorerie (50%): " . number_format($result1['tresorerie'], 0, ',', ' ') . " CFA\n";
    echo "  Salaire par agent: " . number_format($result1['salaire_par_agent'], 0, ',', ' ') . " CFA\n";

    if ($result1['salaire_par_agent'] == 52500) {
        echo "  ✅ CORRECT: Salaire = 52,500 CFA\n";
    } else {
        echo "  ❌ ERREUR: Attendu 52,500 CFA, obtenu " . $result1['salaire_par_agent'] . " CFA\n";
    }

    echo "\n  Répartition par type de vacation:\n";
    echo "    16A (réelles): " . number_format($result1['vacations_par_type']['16A_reelles'], 0, ',', ' ') . " CFA\n";
    echo "    16B (virtuels): " . number_format($result1['vacations_par_type']['16B_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    16C (virtuels): " . number_format($result1['vacations_par_type']['16C_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    16D (virtuels): " . number_format($result1['vacations_par_type']['16D_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    TOTAL: " . number_format($result1['vacations_par_type']['total'], 0, ',', ' ') . " CFA\n";

    echo "\n  Montant par vacation: " . number_format($result1['montant_par_vacation'], 2, ',', ' ') . " CFA\n";
} else {
    echo "✗ Erreur: " . $result1['error'] . "\n";
}

echo "\n";

// TEST 2: 4 agents à 130,000 CFA
echo "TEST 2: 4 agents à 130,000 CFA\n";
echo str_repeat("=", 50) . "\n";

$result2 = $calc->calculateComplete(4, 130000);

if ($result2['valid']) {
    echo "✓ Calcul valide\n";
    echo "  Montant total: " . number_format($result2['montant_total'], 0, ',', ' ') . " CFA\n";
    echo "  Exploitation (50%): " . number_format($result2['exploitation'], 0, ',', ' ') . " CFA\n";
    echo "  Trésorerie (50%): " . number_format($result2['tresorerie'], 0, ',', ' ') . " CFA\n";
    echo "  Salaire par agent: " . number_format($result2['salaire_par_agent'], 0, ',', ' ') . " CFA\n";

    if ($result2['salaire_par_agent'] == 65000) {
        echo "  ✅ CORRECT: Salaire = 65,000 CFA\n";
    } else {
        echo "  ❌ ERREUR: Attendu 65,000 CFA, obtenu " . $result2['salaire_par_agent'] . " CFA\n";
    }

    echo "\n  Répartition par type de vacation:\n";
    echo "    16A (réelles): " . number_format($result2['vacations_par_type']['16A_reelles'], 0, ',', ' ') . " CFA\n";
    echo "    16B (virtuels): " . number_format($result2['vacations_par_type']['16B_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    16C (virtuels): " . number_format($result2['vacations_par_type']['16C_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    16D (virtuels): " . number_format($result2['vacations_par_type']['16D_virtuels'], 0, ',', ' ') . " CFA\n";
    echo "    TOTAL: " . number_format($result2['vacations_par_type']['total'], 0, ',', ' ') . " CFA\n";

    echo "\n  Montant par vacation: " . number_format($result2['montant_par_vacation'], 2, ',', ' ') . " CFA\n";
} else {
    echo "✗ Erreur: " . $result2['error'] . "\n";
}

echo "\n";

// Vérifications
echo "RÉSUMÉ DES VÉRIFICATIONS\n";
echo str_repeat("=", 50) . "\n";

$test1_pass = $result1['valid'] && $result1['salaire_par_agent'] == 52500;
$test2_pass = $result2['valid'] && $result2['salaire_par_agent'] == 65000;

echo "Test 1 (105,000 → 52,500): " . ($test1_pass ? "✅ PASSÉ" : "❌ ÉCHOUÉ") . "\n";
echo "Test 2 (130,000 → 65,000): " . ($test2_pass ? "✅ PASSÉ" : "❌ ÉCHOUÉ") . "\n";

echo "\n";

if ($test1_pass && $test2_pass) {
    echo "🎉 TOUS LES TESTS PASSÉS!\n";
    exit(0);
} else {
    echo "⚠️ CERTAINS TESTS ONT ÉCHOUÉ\n";
    exit(1);
}
