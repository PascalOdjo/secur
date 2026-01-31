<?php
// Test script to verify vacation list page works
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

// Test database connection
try {
    $demandes = \App\Models\Demande::with('vacations')->whereHas('vacations')->limit(5)->get();
    echo "✓ Database connection OK\n";
    echo "✓ Found " . $demandes->count() . " demandes with vacations\n";

    foreach ($demandes as $demande) {
        echo "\nDemande #{$demande->id}:\n";
        echo "  - Client: " . ($demande->client ? $demande->client->nom : 'N/A') . "\n";
        echo "  - Montant Exploitation: " . number_format($demande->montant_exploitation, 0, '.', ' ') . " FCFA\n";
        echo "  - Vacations: " . $demande->vacations->count() . "\n";

        foreach ($demande->vacations as $v) {
            echo "    - Vacation #{$v->id}: {$v->code_vacation} ({$v->vacation_type})\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
