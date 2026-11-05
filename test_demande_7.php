<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('db');

$demande = \App\Models\Demande::with('vacations')->find(7);

if ($demande) {
    echo "Demande 7 found\n";
    echo "Vacations count: " . $demande->vacations->count() . "\n";
    
    $realVacations = $demande->vacations->where('vacation_type', 'reel')->values();
    $virtualVacations = $demande->vacations->where('vacation_type', 'virtuel')->values();
    
    echo "Real vacations: " . $realVacations->count() . "\n";
    echo "Virtual vacations: " . $virtualVacations->count() . "\n";
    
    foreach ($realVacations as $v) {
        echo "  - Real: {$v->code_vacation}\n";
    }
    foreach ($virtualVacations as $v) {
        echo "  - Virtual: {$v->code_vacation}\n";
    }
} else {
    echo "Demande 7 not found\n";
}
