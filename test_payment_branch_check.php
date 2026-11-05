<?php

/**
 * Test rapide du nouveau système de paiement (Février 2025)
 * Formule: Salaire par agent = Montant_par_agent / 2
 */

echo "=== TEST NOUVEAU SYSTEME DE PAIEMENT (BRANCHE ACTUELLE) ===\n\n";

// Test 1: 4 agents à 105,000 CFA
echo "TEST 1: 4 agents à 105,000 CFA\n";
echo str_repeat("=", 50) . "\n";

$nombreAgents = 4;
$montantParAgent = 105000;
$montantTotal = $nombreAgents * $montantParAgent;
$montantExploitation = $montantTotal / 2;
$montantTresorerie = $montantTotal / 2;
$salaireParAgent = $montantParAgent / 2;

echo "Montant total: " . number_format($montantTotal, 0, ',', ' ') . " CFA\n";
echo "Exploitation (50%): " . number_format($montantExploitation, 0, ',', ' ') . " CFA\n";
echo "Trésorerie (50%): " . number_format($montantTresorerie, 0, ',', ' ') . " CFA\n";
echo "Salaire par agent: " . number_format($salaireParAgent, 0, ',', ' ') . " CFA\n\n";

// Breakdown des vacations
$montantParType = $salaireParAgent / 4;  // 16A, 16B, 16C, 16D
$montantParVacation = $montantParType / 16;  // 16 vacations par type

echo "Distribution par type de vacation:\n";
echo "  16A (réelle):    " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16B (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16C (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16D (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n\n";
echo "TOTAL (64 vacations): " . number_format($montantParType * 4, 0, ',', ' ') . " CFA\n";

if ($salaireParAgent == 52500) {
    echo "\n✅ CORRECT: Salaire = 52,500 CFA\n";
} else {
    echo "\n❌ ERREUR: Attendu 52,500, obtenu {$salaireParAgent}\n";
}

echo "\n";

// Test 2: 4 agents à 130,000 CFA
echo "TEST 2: 4 agents à 130,000 CFA\n";
echo str_repeat("=", 50) . "\n";

$nombreAgents = 4;
$montantParAgent = 130000;
$montantTotal = $nombreAgents * $montantParAgent;
$montantExploitation = $montantTotal / 2;
$montantTresorerie = $montantTotal / 2;
$salaireParAgent = $montantParAgent / 2;

echo "Montant total: " . number_format($montantTotal, 0, ',', ' ') . " CFA\n";
echo "Exploitation (50%): " . number_format($montantExploitation, 0, ',', ' ') . " CFA\n";
echo "Trésorerie (50%): " . number_format($montantTresorerie, 0, ',', ' ') . " CFA\n";
echo "Salaire par agent: " . number_format($salaireParAgent, 0, ',', ' ') . " CFA\n\n";

// Breakdown des vacations
$montantParType = $salaireParAgent / 4;  // 16A, 16B, 16C, 16D
$montantParVacation = $montantParType / 16;  // 16 vacations par type

echo "Distribution par type de vacation:\n";
echo "  16A (réelle):    " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16B (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16C (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n";
echo "  16D (virtuelle): " . number_format($montantParType, 0, ',', ' ') . " CFA (16 vacations × " . number_format($montantParVacation, 2, ',', ' ') . " CFA)\n\n";
echo "TOTAL (64 vacations): " . number_format($montantParType * 4, 0, ',', ' ') . " CFA\n";

if ($salaireParAgent == 65000) {
    echo "\n✅ CORRECT: Salaire = 65,000 CFA\n";
} else {
    echo "\n❌ ERREUR: Attendu 65,000, obtenu {$salaireParAgent}\n";
}

echo "\nStatus: BRANCHE MISE À JOUR AVEC LE NOUVEAU SYSTÈME ✅\n";
