<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Demande;

$demande = Demande::find(7);
echo "Demande 7: montant=" . $demande->montant . "\n";
echo "Vacations count: " . $demande->vacations->count() . "\n";
echo "\n";

$total_payments = 0;
$demande->vacations->each(function ($v) use (&$total_payments) {
    $payments = $v->agentPayments->count();
    $total = $v->agentPayments->sum('amount');
    $total_payments += $total;
    echo "Vacation " . $v->id . ": payments=" . $payments . ", total=" . number_format($total, 2) . " FCFA\n";
});

echo "\nTotal payments from all vacations: " . number_format($total_payments, 2) . " FCFA\n";
echo "Contract montant: " . number_format($demande->montant, 2) . " FCFA\n";
echo "Overage: " . number_format($total_payments - $demande->montant, 2) . " FCFA\n";
