<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

// Initialiser la DB
$app->make('db');

$vacation = \App\Models\Vacation::find(13);
if ($vacation) {
    echo "Vacation 13:\n";
    echo "  ID: " . $vacation->id . "\n";
    echo "  Code: " . $vacation->code_vacation . "\n";
    echo "  Type: " . $vacation->vacation_type . "\n";
    echo "  Start Time: " . ($vacation->start_time ?? 'null') . "\n";
    echo "  End Time: " . ($vacation->end_time ?? 'null') . "\n";
    echo "  Demande ID: " . $vacation->demande_id . "\n";
    if ($vacation->demande) {
        echo "\n  Demande " . $vacation->demande->id . ":\n";
        echo "    Start Date: " . $vacation->demande->start_date . "\n";
        echo "    End Date: " . $vacation->demande->end_date . "\n";
    }
} else {
    echo "Vacation 13 not found\n";
}
